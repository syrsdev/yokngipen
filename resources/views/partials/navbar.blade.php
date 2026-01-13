<nav class="bg-white shadow-sm sticky-top py-3 position-relative">
    <div class="container d-flex align-items-center justify-content-between">

        <!-- Logo kiri -->
        <a class="fw-bold fs-3 text-decoration-none" href="/" style="color: #211e75;">
            Yokngipen
        </a>

        <!-- MENU TENGAH (DESKTOP ONLY) -->
        <div class="d-none d-xl-flex position-absolute top-50 start-50 translate-middle gap-4">
            <a class="fw-semibold text-decoration-none text-dark" href="/">Home</a>
            <a class="fw-semibold text-decoration-none text-dark" href="{{ route('events.all') }}">Event</a>
            @auth
                <a class="fw-semibold text-decoration-none text-dark" href="#">Tiket</a>
            @endauth
        </div>

        <!-- BUTTON KANAN (DESKTOP ONLY) -->
        <div class="d-none d-xl-flex align-items-center gap-2">
            @auth
                @if (Auth::user()->role != 'user')
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-dark rounded-pill px-4">
                        Dashboard
                    </a>
                @endif
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

        <!-- HAMBURGER (TABLET & MOBILE) -->
        <button class="btn d-xl-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu">
            ☰
        </button>
    </div>
</nav>

<!-- OFFCANVAS MENU (MOBILE & TABLET) -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="mobileMenu">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title">Menu</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>

    <div class="offcanvas-body d-flex flex-column gap-3">

        <a class="fw-semibold text-decoration-none text-dark" href="/">Home</a>
        <a class="fw-semibold text-decoration-none text-dark" href="{{ route('events.all') }}">Event</a>

        @auth
            <a class="fw-semibold text-decoration-none text-dark" href="#">Tiket</a>
        @endauth

        <hr>

        <div class="d-flex flex-column gap-2">
            @auth
                @if (Auth::user()->role != 'user')
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-dark rounded-pill">
                        Dashboard
                    </a>
                @endif
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger rounded-pill w-100">
                        Logout
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn btn-outline-dark rounded-pill">
                    Login
                </a>
                <a href="{{ route('register') }}" class="btn btn-dark rounded-pill">
                    Register
                </a>
            @endauth
        </div>

    </div>
</div>
