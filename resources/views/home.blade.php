@extends('layouts.app')

@section('content')
    <div class="container my-4">
        <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">
            <div class="overflow-hidden shadow carousel-inner rounded-4">

                <div class="carousel-item active">
                    <img src="{{ asset('assets/hero1.jpg') }}" class="d-block w-100 hero-img" alt="Slide 1">
                </div>

                <div class="carousel-item">
                    <img src="{{ asset('assets/hero2.jpg') }}" class="d-block w-100 hero-img" alt="Slide 2">
                </div>

                <div class="carousel-item">
                    <img src="{{ asset('assets/hero3.jpg') }}" class="d-block w-100 hero-img" alt="Slide 3">
                </div>

            </div>

            <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                <span class="p-2 carousel-control-prev-icon bg-dark rounded-circle"></span>
            </button>

            <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                <span class="p-2 carousel-control-next-icon bg-dark rounded-circle"></span>
            </button>

            <div class="carousel-indicators">
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active"></button>
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"></button>
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2"></button>
            </div>
        </div>
    </div>

    <section class="py-5 bg-light">
        <div class="container">
            <h4 class="mb-4 fw-bold">Event Terkini</h4>

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
