<?php

namespace App\Http\Controllers;

use App\Models\Group;

class DashboardController extends Controller
{
    public function index()
    {
        $groups = Group::all();

        return view('dashboard.index', compact('groups'));
    }
}
