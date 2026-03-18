<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\Group;
use App\Models\Settlement;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        return response()->json([
            'total_users'       => User::where('is_admin', false)->count(),
            'total_groups'      => Group::count(),
            'total_expenses'    => Expense::count(),
            'total_settlements' => Settlement::count(),
            'recent_users'      => User::where('is_admin', false)
                ->latest()
                ->take(5)
                ->get(['id', 'name', 'email', 'created_at']),
        ]);
    }

    public function users()
    {
        $users = User::where('is_admin', false)
            ->withCount('groupMembers')
            ->latest()
            ->get()
            ->map(fn($u) => [
                'id'           => $u->id,
                'name'         => $u->name,
                'email'        => $u->email,
                'group_count'  => $u->group_members_count,
                'created_at'   => $u->created_at,
            ]);

        return response()->json($users);
    }

    public function deleteUser(User $user)
    {
        if ($user->is_admin) {
            return response()->json(['message' => 'Cannot delete an admin account.'], 403);
        }

        DB::transaction(function () use ($user) {
            foreach ($user->groupMembers as $membership) {
                $group = $membership->group;
                if ($group && $group->created_by === $user->id) {
                    foreach ($group->expenses as $expense) {
                        $expense->splits()->delete();
                        $expense->delete();
                    }
                    $group->settlements()->delete();
                    $group->members()->delete();
                    $group->delete();
                }
            }
            $user->groupMembers()->delete();
            $user->tokens()->delete();
            $user->delete();
        });

        return response()->json(['message' => 'User deleted successfully.']);
    }

    public function groups()
    {
        $groups = Group::with(['creator'])
            ->withCount(['members', 'expenses'])
            ->latest()
            ->get()
            ->map(fn($g) => [
                'id'            => $g->id,
                'name'          => $g->name,
                'created_by'    => $g->created_by,
                'creator_name'  => $g->creator->name ?? null,
                'member_count'  => $g->members_count,
                'expense_count' => $g->expenses_count,
                'created_at'    => $g->created_at,
            ]);

        return response()->json($groups);
    }

    public function deleteGroup(Group $group)
    {
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
}
