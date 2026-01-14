<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

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
}
