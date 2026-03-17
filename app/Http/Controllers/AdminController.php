<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Group;
use App\Models\Expense;
use App\Models\Settlement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'users'       => User::where('is_admin', false)->count(),
            'groups'      => Group::count(),
            'expenses'    => Expense::count(),
            'settlements' => Settlement::count(),
        ];

        $recentUsers = User::where('is_admin', false)->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentUsers'));
    }

    public function users()
    {
        $users = User::where('is_admin', false)->latest()->get();
        return view('admin.users', compact('users'));
    }

    public function deleteUser(User $user)
    {
        if ($user->is_admin) {
            return back()->with('error', 'Cannot delete admin accounts.');
        }

        foreach ($user->groups ?? [] as $group) {
            $group->expenses()->each(fn($e) => $e->splits()->delete() && $e->delete());
            $group->members()->delete();
            Settlement::where('group_id', $group->id)->delete();
            $group->delete();
        }

        \App\Models\GroupMember::where('user_id', $user->id)->delete();

        $user->delete();

        return back()->with('success', 'User deleted successfully.');
    }

    public function groups()
    {
        $groups = Group::with('creator')->latest()->get();
        return view('admin.groups', compact('groups'));
    }

    public function deleteGroup(Group $group)
    {
        $group->expenses()->each(function ($expense) {
            $expense->splits()->delete();
            $expense->delete();
        });
        $group->members()->delete();
        Settlement::where('group_id', $group->id)->delete();
        $group->delete();

        return back()->with('success', 'Group deleted successfully.');
    }
}
