<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\Settlement;
use Illuminate\Http\Request;

class SettlementController extends Controller
{
    public function index(Request $request, Group $group)
    {
        $userId = $request->user()->id;
        $isMember = $group->members()->where('user_id', $userId)->exists()
                 || $group->created_by === $userId;

        if (!$isMember) {
            return response()->json(['message' => 'Forbidden.'], 403);
        }

        $settlements = $group->settlements()->with(['fromUser', 'toUser'])->get()->map(fn($s) => [
            'id'            => $s->id,
            'group_id'      => $s->group_id,
            'paid_from'     => $s->paid_from,
            'from_name'     => $s->fromUser->name ?? null,
            'paid_to'       => $s->paid_to,
            'to_name'       => $s->toUser->name ?? null,
            'amount'        => $s->amount,
            'note'          => $s->note,
            'settled_at'    => $s->settled_at,
        ]);

        return response()->json($settlements);
    }

    public function store(Request $request)
    {
        $request->validate([
            'group_id'   => 'required|exists:groups,id',
            'paid_from'  => 'required|exists:users,id',
            'paid_to'    => 'required|exists:users,id|different:paid_from',
            'amount'     => 'required|numeric|min:0.01',
            'settled_at' => 'required|date',
            'note'       => 'nullable|string|max:255',
        ]);

        $group = Group::findOrFail($request->group_id);
        $userId = $request->user()->id;
        $isMember = $group->members()->where('user_id', $userId)->exists()
                 || $group->created_by === $userId;

        if (!$isMember) {
            return response()->json(['message' => 'Forbidden.'], 403);
        }

        $settlement = Settlement::create($request->only([
            'group_id', 'paid_from', 'paid_to', 'amount', 'settled_at', 'note',
        ]));

        $settlement->load(['fromUser', 'toUser']);

        return response()->json([
            'message'    => 'Settlement recorded successfully.',
            'settlement' => [
                'id'         => $settlement->id,
                'group_id'   => $settlement->group_id,
                'paid_from'  => $settlement->paid_from,
                'from_name'  => $settlement->fromUser->name ?? null,
                'paid_to'    => $settlement->paid_to,
                'to_name'    => $settlement->toUser->name ?? null,
                'amount'     => $settlement->amount,
                'note'       => $settlement->note,
                'settled_at' => $settlement->settled_at,
            ],
        ], 201);
    }
}
