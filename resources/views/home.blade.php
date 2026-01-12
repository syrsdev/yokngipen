@extends('layouts.app')

@section('content')
<nav class="bg-white shadow-sm sticky-top py-3">
    <div class="container d-flex align-items-center justify-content-between">

        <!-- BRAND -->
        <a class="fw-bold fs-3 text-decoration-none" href="/" style="color: #211e75;">
            Yokngipen
        </a>    

        <!-- MENU -->
        <ul class="d-flex align-items-center gap-4 mb-0 list-unstyled fs-5">
            <li>
                <a class="text-dark fw-semibold text-decoration-none" href="/">Home</a>
            </li>
            <li>
                <a class="text-dark fw-semibold text-decoration-none" href="{{ route('events.all') }}">Event</a>
                {{-- <a class="text-dark fw-semibold text-decoration-none" href="#events">Event</a> --}}
            </li>
            <li>
                <a class="text-dark fw-semibold text-decoration-none" href="#">Tiket</a>
            </li>
        </ul>

        <!-- AUTH -->
        <div class="d-flex gap-2">
            @auth
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger rounded-pill px-4">
                        Logout
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn btn-outline-dark rounded-pill px-4">
                    Login
                </a>
                <a href="{{ route('register') }}" class="btn btn-dark rounded-pill px-4">
                    Register
                </a>
            @endauth
        </div>

    </div>
</nav>



<!-- HERO SLIDER -->
<div class="container my-4">
    <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">
        <div class="carousel-inner rounded-4 overflow-hidden shadow">

            <!-- Slide 1 -->
            <div class="carousel-item active">
                <img src="{{ asset('storage/slider-hero/hero1.jpg') }}"
                     class="d-block w-100 hero-img"
                     alt="Slide 1">
            </div>

            <!-- Slide 2 -->
            <div class="carousel-item">
                <img src="{{ asset('storage/slider-hero/hero2.jpg') }}"
                     class="d-block w-100 hero-img"
                     alt="Slide 2">
            </div>

            <!-- Slide 3 -->
            <div class="carousel-item">
                <img src="{{ asset('storage/slider-hero/hero3.jpg') }}"
                     class="d-block w-100 hero-img"
                     alt="Slide 3">
            </div>

        </div>

        <!-- Controls -->
        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon bg-dark rounded-circle p-2"></span>
        </button>

        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon bg-dark rounded-circle p-2"></span>
        </button>

        <!-- Indicators -->
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2"></button>
        </div>
    </div>
</div>



<!-- REKOMENDASI EVENT -->
<section class="py-5 bg-light">
    <div class="container">
        <h4 class="fw-bold mb-4">Rekomendasi Event</h4>

        <div class="row g-4">
            @foreach($events as $event)
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="card border-0 shadow-sm rounded-4 h-100 hover-card">

                        <img src="{{ asset('storage/' . $event->banner) }}"
                             class="card-img-top rounded-top-4"
                             style="height: 180px; object-fit: cover"
                             alt="{{ $event->title }}">

                        <div class="card-body">
                            <h6 class="fw-bold mb-1">{{ $event->title }}</h6>

                            <p class="small text-muted mb-2">
                                {{ Str::limit($event->description, 80) }}
                            </p>

                            <div class="small text-muted mb-2">
                                📍 {{ $event->location }} <br><br>
                                📅 {{ \Carbon\Carbon::parse($event->start_date)->translatedFormat('d F Y') }}
                            </div>
                            <p class="fw-bold text-primary mb-2">
                                Rp{{ number_format($event->price, 0, ',', '.') }}
                            </p>
                            <span class="badge bg-success">{{ $event->status }}</span>

                            <a href="#" class="btn btn-primary btn-sm w-100 rounded-pill mt-2">
                                Lihat Detail
                            </a>
                        </div>

                    </div>
                </div>
            @endforeach
        </div>

    </div>
</section>

{{-- footer --}}
<footer class="text-white pt-5 pb-4 mt-5" style="background-color: #211e75;">
    <div class="container py-4">
        <div class="row gy-5">

            <!-- Brand -->
            <div class="col-12 col-md-3">
                <h3 class="fw-bold mb-3">Yokngipen</h3>
                <p class="opacity-75 fs-6 mb-0">
                    Your Professional Ticketing Partner
                </p>
            </div>

            <!-- Tentang Kami -->
            <div class="col-6 col-md-3">
                <h5 class="fw-bold mb-4">Tentang Kami</h5>
                <ul class="list-unstyled fs-6">
                    <li class="mb-3"><a href="#" class="footer-link">Tentang Kami</a></li>
                    <li class="mb-3"><a href="#" class="footer-link">Our Journey</a></li>
                    <li class="mb-3"><a href="#" class="footer-link">Hubungi Kami</a></li>
                    <li><a href="#" class="footer-link">Biaya</a></li>
                </ul>
            </div>

            <!-- Informasi -->
            <div class="col-6 col-md-3">
                <h5 class="fw-bold mb-4">Informasi</h5>
                <ul class="list-unstyled fs-6">
                    <li class="mb-3"><a href="#" class="footer-link">Syarat & Ketentuan</a></li>
                    <li class="mb-3"><a href="#" class="footer-link">Kebijakan Privasi</a></li>
                    <li class="mb-3"><a href="#" class="footer-link">FAQ</a></li>
                    <li><a href="#" class="footer-link">Tiket Gelang</a></li>
                </ul>
            </div>

            <!-- Kategori -->
            <div class="col-12 col-md-3">
                <h5 class="fw-bold mb-4">Kategori Event</h5>
                <ul class="list-unstyled fs-6">
                    <li class="mb-3"><a href="#" class="footer-link">Musik</a></li>
                    <li class="mb-3"><a href="#" class="footer-link">Pameran</a></li>
                    <li class="mb-3"><a href="#" class="footer-link">Wahana</a></li>
                    <li class="mb-3"><a href="#" class="footer-link">Olahraga</a></li>
                    <li><a href="#" class="footer-link">Semua Kategori</a></li>
                </ul>
            </div>

        </div>

        <hr class="border-white opacity-25 my-5">

        <!-- Bottom -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-4 fs-6">
            <p class="mb-0 text-center text-md-start">
                © {{ date('Y') }} Yokngipen. Hak Cipta Dilindungi.
            </p>

            <div class="d-flex gap-4 fs-4">
                <a href="#" class="footer-icon"><i class="bi bi-whatsapp"></i></a>
                <a href="#" class="footer-icon"><i class="bi bi-instagram"></i></a>
                <a href="#" class="footer-icon"><i class="bi bi-tiktok"></i></a>
                <a href="#" class="footer-icon"><i class="bi bi-twitter-x"></i></a>
                <a href="#" class="footer-icon"><i class="bi bi-linkedin"></i></a>
                <a href="#" class="footer-icon"><i class="bi bi-facebook"></i></a>
            </div>
        </div>
    </div>
</footer>




@endsection
