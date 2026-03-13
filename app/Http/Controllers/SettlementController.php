<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Settlement;
use Illuminate\Http\Request;

class SettlementController extends Controller
{
    public function create(Group $group)
    {
        $group->load('members.user');
        return view('settlements.create', compact('group'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'group_id' => 'required|exists:groups,id',
            'paid_from' => 'required|exists:users,id',
            'paid_to' => 'required|exists:users,id|different:paid_from',
            'amount' => 'required|numeric|min:0.01',
            'settled_at' => 'required|date',
            'note' => 'nullable|string|max:255',
        ]);

        Settlement::create($request->all());

        return redirect('/groups/' . $request->group_id)->with('success', 'Settlement recorded successfully.');
    }
}
