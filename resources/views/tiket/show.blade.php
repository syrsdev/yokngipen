@extends('layouts.app')

@section('content')
    <section class="py-5 mt-5 container-md">
        <div class="row justify-content-center">

            <div class="col-md-8">
                <div class="border-0 shadow-sm card rounded-4">

                    <div class="text-center bg-white border-0 card-header">
                        <h4 class="mb-0 fw-bold">Detail Tiket</h4>
                        <small class="text-muted">Kode Order: {{ $order->order_code }}</small>
                    </div>

                    <div class="card-body">
                        @php
                            $event = $order->eventPrice->event;
                        @endphp

                        <div class="mb-4">
                            <h5 class="fw-bold">{{ $event->title }}</h5>
                            <p class="mb-1 text-muted">
                                📍 {{ $event->location }}
                            </p>
                            <p class="mb-0 text-muted">
                                📅 {{ \Carbon\Carbon::parse($event->start_date)->translatedFormat('d F Y') }}
                            </p>
                        </div>

                        <hr>

                        <div class="mb-3 row">
                            <div class="col-6">
                                <small class="text-muted">Tipe Tiket</small>
                                <p class="fw-semibold">{{ $order->eventPrice->name }}</p>
                            </div>
                            <div class="col-6">
                                <small class="text-muted">Jumlah</small>
                                <p class="fw-semibold">{{ $order->quantity }} Tiket</p>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <div class="col-6">
                                <small class="text-muted">Total Harga</small>
                                <p class="fw-bold text-primary">
                                    Rp{{ number_format($order->quantity * $order->eventPrice->price, 0, ',', '.') }}
                                </p>
                            </div>
                            <div class="col-6">
                                <small class="text-muted">Status</small><br>
                                @if ($order->status === 'accepted')
                                    <span class="badge bg-success">Paid</span>
                                @elseif ($order->status === 'pending')
                                    <span class="badge bg-warning text-dark">Menunggu Verifikasi</span>
                                @else
                                    <span class="badge bg-danger">Ditolak</span>
                                @endif
                            </div>
                        </div>

                        <hr>

                        <div class="mb-3">
                            <small class="text-muted">Bukti Pembayaran</small><br>

                            @if ($order->payment)
                                <a href="{{ Storage::url($order->payment->payment_proof) }}" target="_blank"
                                    class="mt-1 btn btn-outline-secondary btn-sm">
                                    Lihat Bukti Pembayaran
                                </a>
                            @else
                                <p class="text-muted">Belum ada bukti pembayaran</p>
                            @endif
                        </div>
                    </div>

                    <div class="text-center bg-white border-0 card-footer">
                        <a href="{{ route('ticket') }}" class="btn btn-outline-primary rounded-pill">
                            Kembali ke Tiket Saya
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </section>
@endsection
