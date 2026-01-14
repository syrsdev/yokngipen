@extends('layouts.app')

@section('content')
    <section class="py-5 mt-5 bg-light container-md rounded-xl">
        <div class="container-md">
            <h4 class="mb-4 fw-bold">Tiket Saya</h4>

            <div class="row g-4">

                @forelse ($orders as $order)
                    @php
                        $event = $order->eventPrice->event;
                    @endphp

                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                        <div class="border-0 shadow-sm card rounded-4 h-100 hover-card">

                            <img src="{{ asset('banner/' . $event->banner) }}" class="card-img-top rounded-top-4"
                                style="height: 180px; object-fit: cover">

                            <div class="card-body">
                                <h6 class="mb-1 fw-bold">{{ $event->title }}</h6>

                                <p class="mb-2 small text-muted">
                                    {{ Str::limit($event->description, 70) }}
                                </p>

                                <div class="mb-2 small text-muted">
                                    📍 {{ $event->location }} <br>
                                    📅 {{ \Carbon\Carbon::parse($event->start_date)->translatedFormat('d F Y') }}
                                </div>

                                <div class="mb-2 small">
                                    🎟 {{ $order->eventPrice->name }} <br>
                                    Jumlah: {{ $order->quantity }} tiket
                                </div>

                                <p class="mb-2 fw-bold text-primary">
                                    Rp{{ number_format($order->quantity * $order->eventPrice->price, 0, ',', '.') }}
                                </p>

                                {{-- STATUS --}}
                                @if ($order->status === 'accepted')
                                    <span class="badge bg-success">Paid</span>
                                @elseif ($order->status === 'pending')
                                    <span class="badge bg-warning text-dark">Menunggu Verifikasi</span>
                                @else
                                    <span class="badge bg-danger">Ditolak</span>
                                @endif

                                {{-- BUTTON --}}
                                <a href="{{ route('ticket.show', $order->id) }}"
                                    class="mt-3 btn btn-outline-primary btn-sm w-100 rounded-pill">
                                    Detail Tiket
                                </a>
                            </div>
                        </div>
                    </div>

                @empty
                    <div class="text-center">
                        <img src="{{ asset('assets/empty.svg') }}" style="width:300px">
                        <h5 class="mt-3">Belum ada tiket</h5>
                    </div>
                @endforelse

            </div>
        </div>
    </section>
@endsection
