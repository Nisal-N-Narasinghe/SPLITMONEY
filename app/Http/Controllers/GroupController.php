<?php
namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\GroupMember;
use App\Models\Settlement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\BalanceService;
use Illuminate\Validation\Rule;

class GroupController extends Controller
{
    public function create()
    {
        $users = Auth::user()->friends()->orderBy('name')->get(['users.id', 'users.name', 'users.email']);
        return view('groups.create', compact('users'));
    }

    public function store(Request $request)
    {
        $friendIds = Auth::user()->friends()->pluck('users.id')->all();

        $request->validate([
            'name'    => 'required|string|max:255',
            'members' => 'nullable|array',
            'members.*' => ['integer', Rule::in($friendIds)],
        ]);

        $group = Group::create([
            'name'       => $request->name,
            'created_by' => Auth::id(),
        ]);

        $memberIds = array_unique(array_merge($request->members ?? [], [Auth::id()]));

        foreach ($memberIds as $userId) {
            GroupMember::create([
                'group_id' => $group->id,
                'user_id' => $userId,
            ]);
        }

        return redirect('/groups/' . $group->id)->with('success', 'Group created successfully.');
    }



    public function destroy(Group $group)
    {
        $group->expenses()->each(function ($expense) {
            $expense->splits()->delete();
            $expense->delete();
        });
        $group->members()->delete();

        \App\Models\Settlement::where('group_id', $group->id)->delete();

        $group->delete();

        return redirect('/')->with('success', 'Group deleted successfully.');
    }

    public function show(Group $group, BalanceService $balanceService)
    {
        $group->load(['members.user', 'expenses.payer']);
        $settlements = Settlement::where('group_id', $group->id)->get();
        $balances = $balanceService->getGroupBalances($group->id);
        $trip = $group->trips()->latest('id')->first();

        $totalExpenses = (float) $group->expenses->sum('amount');
        $totalBudget = $trip ? (float) $trip->total_budget : 0.0;
        $budgetUsagePercent = $totalBudget > 0
            ? round(($totalExpenses / $totalBudget) * 100, 2)
            : 0.0;

        $warningExceeded = $trip && $totalBudget > 0 && $totalExpenses > $totalBudget;
        $warning80 = $trip && $totalBudget > 0 && $budgetUsagePercent >= 80 && !$warningExceeded;
        $remainingOrOverAmount = $trip ? abs($totalBudget - $totalExpenses) : 0.0;

        return view('groups.show', compact(
            'group',
            'balances',
            'settlements',
            'trip',
            'totalExpenses',
            'totalBudget',
            'budgetUsagePercent',
            'warning80',
            'warningExceeded',
            'remainingOrOverAmount'
        ));
    }
}
