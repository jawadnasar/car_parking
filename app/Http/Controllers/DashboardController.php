<?php

namespace App\Http\Controllers;

use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the dashboard
     */
    public function dashboard()
    {
        return view('dashboard.dashboard', [
            // 'user' => Auth::user(),
        ]);
    }
}
