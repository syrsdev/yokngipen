<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class HomeController extends Controller
{
    public function index()
    {
        $activeMenu = 'home';
        $events = Event::latest()->take(4)->get();
        return view('home', compact('events', 'activeMenu'));
    }

    public function allEvents()
    {
        $activeMenu = 'events';
        $events = Event::latest()->get();
        return view('events.index', compact('events', 'activeMenu'));
    }

    public function show($id)
    {
        $event = Event::findOrFail($id);
        return view('events.detail', compact('event'));
    }

}