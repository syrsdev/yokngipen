<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $activeMenu = 'dashboard';
        $jumlahEvent = Event::count();
        $eventBerlangsung = Event::where('status', 'published')->count();
        $eventSelesai = 0;
        $jumlahUser = 0;

        $users = User::where('role', '!=', 'admin')->limit(5)->get();

        if (Auth::user()->role == "organizer") {
            $eventSelesai = Event::where('status', 'closed')->count();
        } else {
            $jumlahUser = User::where('role', '!=', 'admin')->count();
        }
        return view('dashboard.pages.dashboard', compact('activeMenu', 'jumlahEvent', 'eventBerlangsung', 'eventSelesai', 'jumlahUser', 'users'));
    }
}
