@extends('dashboard.layouts.layout')

@section('contents')
    @include('dashboard.partials.heading', ['title' => 'Detail Event'])

    <section class="section">
        <div class="card">
            <div class="card-body">
                <div class="row">

                    <div class="mb-4 col-lg-5">
                        <div class="border-0 shadow-sm card">
                            <img src="{{ asset('banner/' . $event->banner) }}" class="card-img-top"
                                style="height: 220px; object-fit: cover">

                            <div class="card-body">
                                <h5 class="fw-bold">{{ $event->title }}</h5>

                                <p class="text-muted small">
                                    {{ $event->description }}
                                </p>

                                <ul class="mb-0 list-unstyled small">
                                    <li>📍 <strong>Lokasi:</strong> {{ $event->location }}</li>
                                    <li>📅 <strong>Tanggal:</strong>
                                        {{ \Carbon\Carbon::parse($event->start_date)->translatedFormat('d F Y') }}
                                        -
                                        {{ \Carbon\Carbon::parse($event->end_date)->translatedFormat('d F Y') }}
                                    </li>
                                    <li>
                                        <strong>Status:</strong>
                                        @if ($event->status === 'published')
                                            <span class="badge bg-success">published</span>
                                        @else
                                            <span class="badge bg-secondary">Closed</span>
                                        @endif
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4 col-lg-7">
                        <div class="row g-3">

                            @php
                                $totalSold = 0;
                                $totalQuota = 0;

                                foreach ($event->prices as $price) {
                                    $sold = $price->orders->where('status', 'paid')->sum('quantity');
                                    $totalSold += $sold;
                                    $totalQuota += $price->quota + $sold;
                                }
                            @endphp

                            <div class="col-md-6">
                                <div class="text-center border-0 shadow-sm card">
                                    <div class="card-body">
                                        <h6 class="text-muted">Tiket Terjual</h6>
                                        <h3 class="fw-bold text-primary">{{ $totalSold }}</h3>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="text-center border-0 shadow-sm card">
                                    <div class="card-body">
                                        <h6 class="text-muted">Sisa Kuota</h6>
                                        <h3 class="fw-bold text-success">{{ $totalQuota - $totalSold }}</h3>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="mt-4 border-0 shadow-sm card">
                            <div class="card-body">
                                <h6 class="mb-3 fw-bold">Daftar Harga Tiket</h6>

                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Nama</th>
                                                <th>Harga</th>
                                                <th>Sisa</th>
                                                <th>Terjual</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($event->prices as $price)
                                                @php
                                                    $sold = $price->orders
                                                        ->where('status', 'accepted')
                                                        ->sum('quantity');
                                                @endphp
                                                <tr>
                                                    <td>{{ $price->name }}</td>
                                                    <td>Rp{{ number_format($price->price, 0, ',', '.') }}</td>
                                                    <td>{{ $price->quota }}</td>
                                                    <td>{{ $sold }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <a href="{{ route('events.createPrice', $event->id) }}"
                                        class="btn btn-success w-100">Tambah Harga
                                        Event</a>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </section>
@endsection
