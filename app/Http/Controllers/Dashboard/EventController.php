<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Event;
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

    public function verif()
    {
        $activeMenu = 'verif';
        $events = events::with('prices')->where('status', 'draft')->get();
        return view('dashboard.pages.events.verif', compact('events', 'activeMenu'));
    }

    public function accept($id)
    {
        $event = events::findOrFail($id);
        $event->status = 'published';
        $event->save();
        return redirect()->back()->with('success', 'Event berhasil dipublish!');
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
            'payment_method' => 'required',
            'account_number' => 'required',
            "banner" => "required|image|mimes:jpg,png,jpeg,svg|max:2048",
        ]);
        $credential2 = $request->validate([
            'name' => 'required',
            'price' => 'required',
            'quota' => 'required',
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
        $activeMenu = 'event';
        $event = Event::with(['prices.orders'])->findOrFail($id);
        return view('dashboard.pages.events.detail', compact('event', 'activeMenu'));
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
            'payment_method' => 'required',
            'account_number' => 'required',
            'banner' => 'nullable|image|mimes:jpg,png,jpeg,svg|max:2048',
        ]);

        $event = events::findOrFail($id);
        $credential['status'] = $event->status;
        $event->update($credential);
        return redirect()->route('events.index')->with('success', 'Event berhasil diupdate!');
    }

    public function createPrice($id)
    {
        $activeMenu = 'event';
        return view('dashboard.pages.events.prices.add', compact('activeMenu', 'id'));
    }
    public function storePrice(Request $request, $id)
    {
        $credential = $request->validate([
            'name' => 'required',
            'price' => 'required',
            'quota' => 'required',
        ]);
        $credential['events_id'] = $id;
        event_prices::create($credential);

        return redirect()->route('events.show', $id)->with('success', 'Harga berhasil ditambahkan!');
    }
    public function update_event_price(Request $request, $id)
    {
        $credential2 = $request->validate([
            'name' => 'required',
            'price' => 'required',
            'quota' => 'required',
        ]);

        $event_prices = event_prices::findOrFail($id);
        $event_prices->update($credential2);
        return redirect()->route('events.index')->with('success', 'Event Price berhasil diupdate!');
    }

    public function destroy($id)
    {
        $event = events::findOrFail($id);
        $event->status = 'closed';
        $event->save();
        return redirect()->back()->with('success', 'Event ditutup!');
    }
}
