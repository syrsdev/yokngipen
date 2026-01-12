<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class HomeController extends Controller
{
    public function index()
    {
       $events = Event::latest()->take(4)->get();
        return view('home', compact('events'));
    }
    
    public function allEvents()
    {
        $events = Event::latest()->get(); // semua event
        return view('events.index', compact('events'));
    }

}
