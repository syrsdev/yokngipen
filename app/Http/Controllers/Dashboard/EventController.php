<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\events;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function store(Request $request)
    {
        $credential = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'location' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'banner' => 'required',
            'status' => 'required',
        ]);
        $credential2 = $request->validate([
            'name' => 'required',
            'price' => 'required',
            'quota' => 'required',
            'payment_method' => 'required',
            'account_number' => 'required',
        ]);
        $event = events::create($credential);

        $event->prices()->create($credential2);
        return;
    }
    // public function index()
    // {
    //     return view('dashboard.pages.dashboard');
    // }
    // public function index()
    // {
    //     return view('dashboard.pages.dashboard');
    // }
}
