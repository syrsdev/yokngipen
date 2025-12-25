<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\event_prices;
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
    public function detail($id)
    {
        $event = events::findOrFail($id);
        $event_prices = event_prices::where('id_event',$id)->get();
        return;
    }
    public function update_event(Request $request, $id) {

        $credential = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'location' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'banner' => 'required',
            'status' => 'required',
        ]);
        
        $event = events::findOrFail($id);
        $event->update($credential);
        return;

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
        return;
    }
}
