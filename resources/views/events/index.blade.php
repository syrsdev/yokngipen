@extends('layouts.app')

@section('content')
    <section class="py-5 mt-5 bg-light container-md rounded-xl">
        <div class="container-md">
            <h4 class="mb-4 fw-bold">Event Tersedia</h4>

            <div class="row g-4">
                @if ($events->count() > 0)
                    @foreach ($events as $event)
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                            <div class="border-0 shadow-sm card rounded-4 h-100 hover-card">

                                <img src="{{ asset('banner/' . $event->banner) }}" class="card-img-top rounded-top-4"
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
                                        Rp{{ number_format($event->prices->first()->price, 0, ',', '.') }}
                                    </p>
                                    <span class="badge bg-success">{{ $event->status }}</span>

                                    <a href="{{ route('events.detail', $event->id) }}"
                                        class="mt-2 btn btn-primary btn-sm w-100 rounded-pill">
                                        Lihat Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <img src="{{ asset('assets/empty.svg') }}" alt="" style="width: 300px; margin: 0 auto;">
                    <h4 class="text-center">Belum ada event</h4>
                @endif
            </div>

            <h4 class="mt-5 mb-4 fw-bold">Event Sebelumnya</h4>
            <div class="row g-4">
                @if ($closed->count() > 0)
                    @foreach ($closed as $item)
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                            <div class="border-0 shadow-sm card rounded-4 h-100 hover-card">

                                <img src="{{ asset('banner/' . $item->banner) }}" class="card-img-top rounded-top-4"
                                    style="height: 180px; object-fit: cover" alt="{{ $item->title }}">

                                <div class="card-body">
                                    <h6 class="mb-1 fw-bold">{{ $item->title }}</h6>

                                    <p class="mb-2 small text-muted">
                                        {{ Str::limit($item->description, 80) }}
                                    </p>

                                    <div class="mb-2 small text-muted">
                                        📍 {{ $item->location }} <br><br>
                                        📅 {{ \Carbon\Carbon::parse($item->start_date)->translatedFormat('d F Y') }}
                                    </div>
                                    <p class="mb-2 fw-bold text-primary">
                                        Rp{{ number_format($item->prices->first()->price, 0, ',', '.') }}
                                    </p>
                                    <span class="badge bg-success">{{ $item->status }}</span>

                                    <a href="{{ route('events.detail', $item->id) }}"
                                        class="mt-2 btn btn-primary btn-sm w-100 rounded-pill">
                                        Lihat Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <img src="{{ asset('assets/empty.svg') }}" alt="" style="width: 300px; margin: 0 auto;">
                    <h4 class="text-center">Belum ada event</h4>
                @endif
            </div>
        </div>
    </section>
@endsection
