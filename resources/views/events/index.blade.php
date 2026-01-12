@extends('layouts.app')

@section('content')
    <!-- REKOMENDASI EVENT -->
    <section class="py-5 bg-light">
        <div class="container">
            <h4 class="mb-4 fw-bold">Rekomendasi Event</h4>

            <div class="row g-4">
                @foreach ($events as $event)
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                        <div class="border-0 shadow-sm card rounded-4 h-100 hover-card">

                            <img src="{{ asset('storage/' . $event->banner) }}" class="card-img-top rounded-top-4"
                                style="height: 180px; object-fit: cover" alt="{{ $event->title }}">

                            <div class="card-body">
                                <h6 class="mb-1 fw-bold">{{ $event->title }}</h6>

                                <p class="mb-2 small text-muted">
                                    {{ Str::limit($event->description, 80) }}
                                </p>

                                <div class="mb-2 small text-muted">
                                    📍 {{ $event->location }} <br><br>
                                    📅 {{ \Carbon\Carbon::parse($event->start_date)->translatedFormat('d F Y') }}
                                </div>
                                <p class="mb-2 fw-bold text-primary">
                                    Rp{{ number_format($event->price, 0, ',', '.') }}
                                </p>
                                <span class="badge bg-success">{{ $event->status }}</span>

                                <a href="#" class="mt-2 btn btn-primary btn-sm w-100 rounded-pill">
                                    Lihat Detail
                                </a>
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </section>
@endsection
