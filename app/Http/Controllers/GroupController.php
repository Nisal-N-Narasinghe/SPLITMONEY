<?php
namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\GroupMember;
use App\Models\Settlement;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\BalanceService;

class GroupController extends Controller
{
    public function create()
    {
        $users = User::where('id', '!=', Auth::id())->get();
        return view('groups.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'members' => 'nullable|array',
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
        $group->load(['members.user', 'expenses']);
        $settlements = Settlement::where('group_id', $group->id)->get();
        $balances = $balanceService->getGroupBalances($group->id);

        return view('groups.show', compact('group', 'balances', 'settlements'));
    }
}