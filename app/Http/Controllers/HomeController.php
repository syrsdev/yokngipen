<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\orders;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $activeMenu = 'home';
        $events = Event::with('prices')->where('status', 'published')->latest()->take(4)->get();
        return view('home', compact('events', 'activeMenu'));
    }

    public function allEvents()
    {
        $activeMenu = 'events';
        $events = Event::with('prices')->where('status', 'published')->latest()->get();
        $closed = Event::with('prices')->where('status', 'closed')->latest()->get();
        return view('events.index', compact('events', 'closed', 'activeMenu'));
    }

    public function show($id)
    {
        $activeMenu = 'events';
        $event = Event::with('prices')->findOrFail($id);
        return view('events.detail', compact('event', 'activeMenu'));
    }

    public function myTickets()
    {
        $activeMenu = 'tiket';
        $orders = orders::with('eventPrice.event')
            ->where('id_user', Auth::user()->id)
            ->latest()
            ->get();

        return view('tiket.index', compact('orders', 'activeMenu'));
    }
    public function showTiket($id)
    {
        $activeMenu = 'tiket';
        $order = orders::with([
            'eventPrice.event',
            'payment'
        ])
            ->where('id_user', Auth::user()->id)
            ->findOrFail($id);

        return view('tiket.show', compact('order', 'activeMenu'));
    }
}
