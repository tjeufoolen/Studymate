<?php

namespace App\Http\Controllers;

use App\Role;
use Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $roles = Auth::user()->roles->pluck('name')->toArray();

        # Administrator
        if (in_array(Role::$ADMINISTRATOR, $roles)) {
            return view('admins.dashboard');
        }

        # DeadlineManager
        if (in_array(Role::$DEADLINE_MANAGER, $roles)) {
            return view('deadlines.dashboard');
        }

        return redirect(route('home'));
    }
}
