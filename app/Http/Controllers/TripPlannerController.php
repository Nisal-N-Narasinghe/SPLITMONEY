<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\GroupMember;
use App\Models\Trip;
use App\Models\User;
use App\Services\TripPlannerAiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;

class TripPlannerController extends Controller
{
    public function index()
    {
        $users = User::where('id', '!=', Auth::id())
            ->where('is_admin', false)
            ->orderBy('name')
            ->get(['id', 'name', 'email']);

        return view('trip-planner.index', compact('users'));
    }

    public function plan(Request $request, TripPlannerAiService $tripPlannerAiService)
    {
        $data = $request->validate([
            'destination' => 'required|string|max:120',
            'days' => 'required|integer|min:1|max:30',
            'travelers' => 'required|integer|min:1|max:30',
            'budget_mode' => 'required|in:total,category,both',
            'total_budget' => 'nullable|numeric|min:1',
            'notes' => 'nullable|string|max:2000',
        ]);

        try {
            $plan = $tripPlannerAiService->generatePlan($data);

            return response()->json([
                'message' => 'Plan generated successfully.',
                'plan' => $plan,
            ]);
        } catch (Throwable $e) {
            report($e);

            $error = strtolower($e->getMessage());
            if (str_contains($error, 'error 429')) {
                return response()->json([
                    'message' => 'AI request limit reached. Please wait a bit and try again.',
                ], 429);
            }

            if (str_contains($error, 'not found') || str_contains($error, 'not supported')) {
                return response()->json([
                    'message' => 'AI model is not available. Update GEMINI_MODEL and try again.',
                ], 422);
            }

            return response()->json([
                'message' => 'Could not generate plan right now. Please try again.',
            ], 422);
        }
    }

    public function createGroup(Request $request)
    {
        $validated = $request->validate([
            'group_name' => 'required|string|max:255',
            'member_ids' => 'nullable|array',
            'member_ids.*' => 'integer|exists:users,id',
            'plan_json' => 'required|string',
        ]);

        $plan = json_decode($validated['plan_json'], true);
        if (!is_array($plan)) {
            return back()->with('error', 'Invalid plan payload. Please regenerate the trip plan.');
        }

        $userId = Auth::id();

        DB::transaction(function () use ($validated, $plan, $userId) {
            $group = Group::create([
                'name' => $validated['group_name'],
                'created_by' => $userId,
            ]);

            $memberIds = collect($validated['member_ids'] ?? [])->push($userId)->unique();
            foreach ($memberIds as $memberId) {
                GroupMember::create([
                    'group_id' => $group->id,
                    'user_id' => $memberId,
                ]);
            }

            Trip::create([
                'user_id' => $userId,
                'group_id' => $group->id,
                'destination' => (string) data_get($plan, 'destination', 'Unknown'),
                'days' => (int) data_get($plan, 'days', 1),
                'travelers' => (int) data_get($plan, 'travelers', 1),
                'budget_mode' => (string) data_get($plan, 'budget_mode', 'both'),
                'total_budget' => (float) data_get($plan, 'budget.total', 0),
                'category_budgets' => (array) data_get($plan, 'budget.categories', []),
                'daily_plan' => (array) data_get($plan, 'daily_plan', []),
                'summary' => (string) data_get($plan, 'summary', ''),
                'tips' => (array) data_get($plan, 'tips', []),
            ]);
        });

        return redirect('/')->with('success', 'Group created from AI trip plan.');
    }
}
