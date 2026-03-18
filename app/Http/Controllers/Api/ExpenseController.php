<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\ExpenseSplit;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExpenseController extends Controller
{
    public function index(Request $request, Group $group)
    {
        $userId = $request->user()->id;
        $isMember = $group->members()->where('user_id', $userId)->exists()
                 || $group->created_by === $userId;

        if (!$isMember) {
            return response()->json(['message' => 'Forbidden.'], 403);
        }

        $expenses = $group->expenses()->with(['payer', 'splits.user'])->get()->map(fn($e) => [
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
        ]);

        return response()->json($expenses);
    }

    public function store(Request $request)
    {
        $request->validate([
            'group_id'     => 'required|exists:groups,id',
            'paid_by'      => 'required|exists:users,id',
            'amount'       => 'required|numeric|min:0.01',
            'description'  => 'required|string|max:255',
            'expense_date' => 'required|date',
            'members'      => 'required|array|min:1',
            'members.*'    => 'exists:users,id',
        ]);

        $group = Group::findOrFail($request->group_id);
        $userId = $request->user()->id;
        $isMember = $group->members()->where('user_id', $userId)->exists()
                 || $group->created_by === $userId;

        if (!$isMember) {
            return response()->json(['message' => 'Forbidden.'], 403);
        }

        $expense = DB::transaction(function () use ($request) {
            $expense = Expense::create([
                'group_id'     => $request->group_id,
                'paid_by'      => $request->paid_by,
                'amount'       => $request->amount,
                'description'  => $request->description,
                'expense_date' => $request->expense_date,
            ]);

            $splitAmount = round($request->amount / count($request->members), 2);

            foreach ($request->members as $memberId) {
                ExpenseSplit::create([
                    'expense_id' => $expense->id,
                    'user_id'    => $memberId,
                    'amount'     => $splitAmount,
                ]);
            }

            return $expense;
        });

        $expense->load(['payer', 'splits.user']);

        return response()->json([
            'message' => 'Expense added successfully.',
            'expense' => [
                'id'           => $expense->id,
                'description'  => $expense->description,
                'amount'       => $expense->amount,
                'paid_by'      => $expense->paid_by,
                'payer_name'   => $expense->payer->name ?? null,
                'expense_date' => $expense->expense_date,
                'splits'       => $expense->splits->map(fn($s) => [
                    'user_id'   => $s->user_id,
                    'user_name' => $s->user->name ?? null,
                    'amount'    => $s->amount,
                ]),
            ],
        ], 201);
    }
}
