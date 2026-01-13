<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\event_prices;
use App\Models\events;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function index()
    {
        $activeMenu = 'event';
        if (Auth::user()->role == "organizer") {
            $events = events::with('prices')->where('id_organizer', Auth::user()->id)->get();
        } else {
            $events = events::with('prices')->get();
        }
        return view('dashboard.pages.events.index', compact('events', 'activeMenu'));
    }

    public function create()
    {
        $activeMenu = 'event';
        return view('dashboard.pages.events.add', compact('activeMenu'));
    }

    public function store(Request $request)
    {
        $credential = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'location' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            "banner" => "required|image|mimes:jpg,png,jpeg,svg|max:2048",
        ]);
        $credential2 = $request->validate([
            'name' => 'required',
            'price' => 'required',
            'quota' => 'required',
            'payment_method' => 'required',
            'account_number' => 'required',
        ]);

        if ($request->hasFile('banner')) {
            $file = $request->file('banner');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move("banner/", $filename);
            $credential['banner'] = $filename;
        }

        $credential['status'] = 'draft';
        $credential['id_organizer'] = Auth::user()->id;
        $event = events::create($credential);

        $event->prices()->create($credential2);
        return redirect()->route('events.index')->with('success', 'Event berhasil ditambahkan!');
    }
    public function show($id)
    {
        $event = events::findOrFail($id);
        $event_prices = event_prices::where('id_event', $id)->get();
        return;
    }

    public function edit($id)
    {
        $activeMenu = 'event';
        $event = events::findOrFail($id);
        $event_prices = event_prices::where('events_id', $id)->get();
        return view('dashboard.pages.events.edit', compact('event', 'event_prices', 'activeMenu'));
    }

    public function update_event(Request $request, $id)
    {

        $credential = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'location' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'banner' => 'nullable|image|mimes:jpg,png,jpeg,svg|max:2048',
        ]);

        $event = events::findOrFail($id);
        $credential['status'] = $event->status;
        $event->update($credential);
        return redirect()->route('events.index')->with('success', 'Event berhasil diupdate!');
    }
    public function update_event_price(Request $request, $id)
    {
        $credential2 = $request->validate([
            'name' => 'required',
            'price' => 'required',
            'quota' => 'required',
            'payment_method' => 'required',
            'account_number' => 'required',
        ]);

        $event_prices = event_prices::findOrFail($id);
        $event_prices->update($credential2);
        return redirect()->route('events.index')->with('success', 'Event Price berhasil diupdate!');
    }
}
