<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\GroupMember;
use App\Models\User;
use App\Services\BalanceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GroupController extends Controller
{
    public function index(Request $request)
    {
        $userId = $request->user()->id;

        $groups = Group::with(['creator', 'members.user'])
            ->whereHas('members', fn($q) => $q->where('user_id', $userId))
            ->orWhere('created_by', $userId)
            ->get()
            ->unique('id')
            ->values()
            ->map(fn($g) => [
                'id'           => $g->id,
                'name'         => $g->name,
                'created_by'   => $g->created_by,
                'creator_name' => $g->creator->name ?? null,
                'member_count' => $g->members->count(),
                'created_at'   => $g->created_at,
            ]);

        return response()->json($groups);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'members' => 'nullable|array',
            'members.*' => 'exists:users,id',
        ]);

        $group = Group::create([
            'name'       => $request->name,
            'created_by' => $request->user()->id,
        ]);

        $memberIds = collect($request->members ?? [])->push($request->user()->id)->unique();
        foreach ($memberIds as $id) {
            GroupMember::create(['group_id' => $group->id, 'user_id' => $id]);
        }

        $group->load('members.user');

        return response()->json([
            'message' => 'Group created successfully.',
            'group'   => [
                'id'         => $group->id,
                'name'       => $group->name,
                'created_by' => $group->created_by,
                'members'    => $group->members->map(fn($m) => [
                    'id'   => $m->user->id,
                    'name' => $m->user->name,
                ]),
                'created_at' => $group->created_at,
            ],
        ], 201);
    }

    public function show(Request $request, Group $group)
    {
        $userId = $request->user()->id;
        $isMember = $group->members()->where('user_id', $userId)->exists()
                 || $group->created_by === $userId;

        if (!$isMember) {
            return response()->json(['message' => 'Forbidden.'], 403);
        }

        $group->load(['members.user', 'expenses.payer', 'expenses.splits.user']);

        $balances = (new BalanceService())->getGroupBalances($group->id);

        return response()->json([
            'id'         => $group->id,
            'name'       => $group->name,
            'created_by' => $group->created_by,
            'members'    => $group->members->map(fn($m) => [
                'id'   => $m->user->id,
                'name' => $m->user->name,
            ]),
            'expenses'   => $group->expenses->map(fn($e) => [
                'id'           => $e->id,
                'description'  => $e->description,
                'amount'       => $e->amount,
                'paid_by'      => $e->paid_by,
                'payer_name'   => $e->payer->name ?? null,
                'expense_date' => $e->expense_date,
                'splits'       => $e->splits->map(fn($s) => [
                    'user_id'   => $s->user_id,
                    'user_name' => $s->user->name ?? null,
                    'amount'    => $s->amount,
                ]),
            ]),
            'balances'   => $balances,
            'created_at' => $group->created_at,
        ]);
    }

    public function destroy(Request $request, Group $group)
    {
        $userId = $request->user()->id;

        if ($group->created_by !== $userId && !$request->user()->is_admin) {
            return response()->json(['message' => 'Forbidden. Only the group creator can delete this group.'], 403);
        }

        DB::transaction(function () use ($group) {
            foreach ($group->expenses as $expense) {
                $expense->splits()->delete();
                $expense->delete();
            }
            $group->settlements()->delete();
            $group->members()->delete();
            $group->delete();
        });

        return response()->json(['message' => 'Group deleted successfully.']);
    }

    public function users(Request $request)
    {
        $userId = $request->user()->id;
        $users = User::where('id', '!=', $userId)
            ->where('is_admin', false)
            ->get(['id', 'name', 'email']);

        return response()->json($users);
    }
}
