@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="row g-4">

        <!-- KIRI: Banner -->
        <div class="col-12 col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <img src="{{ asset('storage/' . $event->banner) }}" class="img-fluid w-100"
                    style="max-height: 420px; object-fit: cover;">
            </div>

            <h3 class="mt-4 fw-bold">{{ $event->title }}</h3>

            <div class="mt-3">
                <h5 class="fw-bold">Deskripsi</h5>
                <p class="text-muted">
                    {{ $event->description }}
                </p>
            </div>
        </div>

        <!-- KANAN: Info -->
        <div class="col-12 col-lg-4">
            <div class="p-4 border-0 shadow-sm card rounded-4">

                <h5 class="mb-3 fw-bold">Detail Event</h5>

                <div class="mb-3">
                    <small class="text-muted">📅 Tanggal</small>
                    <div class="fw-semibold">
                        {{ \Carbon\Carbon::parse($event->start_date)->translatedFormat('d F Y') }}
                    </div>
                </div>

                <div class="mb-3">
                    <small class="text-muted">📍 Lokasi</small>
                    <div class="fw-semibold">{{ $event->location }}</div>
                </div>

                <div class="mb-3">
                    <small class="text-muted">💰 Harga</small>
                    <div class="fw-semibold text-primary">
                        Rp{{ number_format($event->price, 0, ',', '.') }}
                    </div>
                </div>

                <div class="mb-3">
                    <small class="text-muted">📌 Status</small>
                    <div>
                        <span class="badge bg-success">{{ $event->status }}</span>
                    </div>
                </div>

                <button class="btn btn-primary w-100 rounded-pill">
                    Beli Tiket
                </button>
            </div>
        </div>

    </div>
</div>
@endsection
