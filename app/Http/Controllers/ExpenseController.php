<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\ExpenseSplit;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExpenseController extends Controller
{
    public function create(Group $group)
    {
        $group->load('members.user');
        return view('expenses.create', compact('group'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'group_id' => 'required|exists:groups,id',
            'paid_by' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:0.01',
            'description' => 'required|string|max:255',
            'expense_date' => 'required|date',
            'members' => 'required|array|min:1',
        ]);

        DB::transaction(function () use ($request) {
            $expense = Expense::create([
                'group_id' => $request->group_id,
                'paid_by' => $request->paid_by,
                'amount' => $request->amount,
                'description' => $request->description,
                'expense_date' => $request->expense_date,
            ]);

            $splitAmount = round($request->amount / count($request->members), 2);

            foreach ($request->members as $memberId) {
                ExpenseSplit::create([
                    'expense_id' => $expense->id,
                    'user_id' => $memberId,
                    'amount' => $splitAmount,
                ]);
            }
        });

        return redirect('/groups/' . $request->group_id)->with('success', 'Expense added successfully.');
    }
}
