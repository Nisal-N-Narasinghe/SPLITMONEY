<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $groups = Group::whereHas('members', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        })->orWhere('created_by', $userId)->get()->unique('id');

        return view('dashboard.index', compact('groups'));
    }
}
