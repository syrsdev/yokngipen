<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\event_prices;
use Illuminate\Http\Request;
use App\Models\orders;
use App\Models\events;
use App\Models\payments;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function index()
    {
        $activeMenu = 'payment';
        $data = orders::with(['eventPrice.event', 'payment'])
            ->where('status', 'pending')
            ->get();
        return view('dashboard.pages.payment.index', compact('data', 'activeMenu'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'event_price_id' => 'required|exists:event_prices,id',
            'quantity' => 'required|integer|min:1',
            'payment_proof' => 'required|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        DB::transaction(function () use ($request) {

            // 1. Ambil harga tiket
            $eventPrice = event_prices::lockForUpdate()->findOrFail($request->event_price_id);

            // 2. Cek kuota
            if ($eventPrice->quota < $request->quantity) {
                throw new \Exception('Kuota tiket tidak mencukupi');
            }

            // 3. Upload bukti pembayaran
            $paymentProofPath = $request->file('payment_proof')
                ->store('payment_proofs', 'public');

            // 4. Simpan payment
            $payment = payments::create([
                'payment_proof' => $paymentProofPath,
            ]);

            // 5. Simpan order
            orders::create([
                'id_user' => Auth::id(),
                'id_event_price' => $eventPrice->id,
                'id_payment' => $payment->id,
                'order_code' => 'ORD-' . strtoupper(Str::random(8)),
                'quantity' => $request->quantity,
                'total_price' => $eventPrice->price * $request->quantity,
                'status' => 'pending',
            ]);

            // 6. Kurangi kuota
            $eventPrice->decrement('quota', $request->quantity);
        });

        return redirect()->back()->with('success', 'Tiket berhasil dipesan, menunggu verifikasi.');
    }


    public function validatePayment(Request $request, $id)
    {
        $request->validate([
            'action' => 'required|in:approve,reject'
        ]);

        DB::transaction(function () use ($request, $id, &$message) {

            $order = orders::with('eventPrice')->findOrFail($id);

            if ($request->action === 'approve') {

                if ($order->status === 'accepted') {
                    throw new \Exception('Order sudah dikonfirmasi.');
                }

                $order->update([
                    'status' => 'accepted'
                ]);

                $message = 'Pembayaran berhasil dikonfirmasi.';
            } else {

                $order->eventPrice->increment('quota', $order->quantity);

                $order->update([
                    'status' => 'rejected'
                ]);

                $message = 'Pembayaran ditolak.';
            }
        });

        return redirect()->back()->with('success', $message);
    }
}