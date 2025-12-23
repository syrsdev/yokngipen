<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\orders;
use App\Models\events;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $event = events::findOrFail($request->event_id);

        if ($event->quota < $request->quantity) {
            return redirect()->back()->with('error', 'Maaf, kuota tiket tidak mencukupi.');
        }

        $order = orders::create([
            'user_id' => Auth::id(),
            'event_id' => $event->id,
            'quantity' => $request->quantity,
            'total_price' => $event->price * $request->quantity,
            'status' => 'unpaid'
        ]);

        return redirect()->route('', $order->id);
    }

    public function uploadPayment(Request $request, $id)
    {
        $request->validate([
            'payment_proof' => 'required|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        $order = orders::findOrFail($id);

        if ($request->hasFile('payment_proof')) {
            $file = $request->file('payment_proof');
            $path = $file->store('proofs', 'public');

            $order->update([
                'payment_proof' => $path,
                'status' => 'pending'
            ]);
        }

        return redirect()->back()->with('success', 'Bukti transfer berhasil dikirim!');
    }

    public function validatePayment(Request $request, $id)
    {
        $order = orders::findOrFail($id);
        $event = events::findOrFail($order->event_id);

        if ($request->action == 'approve') {
            $order->update(['status' => 'paid']);

            $event->decrement('quota', $order->quantity);

            $msg = "Pembayaran dikonfirmasi!";
        } else {
            $order->update(['status' => 'rejected']);
            $msg = "Pembayaran ditolak.";
        }

        return redirect()->back()->with('success', $msg);
    }
}
