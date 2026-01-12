<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $activeMenu = 'dashboard';
        return view('dashboard.pages.dashboard', compact('activeMenu'));
    }
}
