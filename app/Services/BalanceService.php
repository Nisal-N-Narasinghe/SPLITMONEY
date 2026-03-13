<?php

namespace App\Services;

use App\Models\Expense;
use App\Models\Settlement;
use App\Models\User;

class BalanceService
{
    public function getGroupBalances($groupId)
    {
        $paid = [];
        $owed = [];
        $balances = [];

        $expenses = Expense::with('splits')
            ->where('group_id', $groupId)
            ->get();

        foreach ($expenses as $expense) {
            $paid[$expense->paid_by] = ($paid[$expense->paid_by] ?? 0) + $expense->amount;

            foreach ($expense->splits as $split) {
                $owed[$split->user_id] = ($owed[$split->user_id] ?? 0) + $split->amount;
            }
        }

        $settlements = Settlement::where('group_id', $groupId)->get();

        foreach ($settlements as $settlement) {
            // payer's debt reduces
            $paid[$settlement->paid_from] = ($paid[$settlement->paid_from] ?? 0) + $settlement->amount;

            // receiver's credit reduces
            $paid[$settlement->paid_to] = ($paid[$settlement->paid_to] ?? 0) - $settlement->amount;
        }

        $userIds = array_unique(array_merge(array_keys($paid), array_keys($owed)));
        $users = User::whereIn('id', $userIds)->get()->keyBy('id');

        foreach ($userIds as $userId) {
            $balance = round(($paid[$userId] ?? 0) - ($owed[$userId] ?? 0), 2);

            $balances[] = [
                'user_id' => $userId,
                'name' => $users[$userId]->name ?? 'Unknown',
                'balance' => $balance,
            ];
        }

        return $balances;
    }
}
