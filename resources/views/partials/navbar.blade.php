<nav class="py-3 bg-white shadow-sm sticky-top position-relative">
    <div class="container d-flex align-items-center justify-content-between">

        <a class="fw-bold fs-3 text-decoration-none" href="/" style="color: #211e75;">
            Yokngipen
        </a>

        <div class="gap-4 d-none d-xl-flex position-absolute top-50 start-50 translate-middle">
            <a class="fw-semibold text-decoration-none {{ $activeMenu == 'home' ? 'text-primary' : 'text-dark' }}"
                href="/">Home</a>
            <a class="fw-semibold text-decoration-none {{ $activeMenu == 'events' ? 'text-primary' : 'text-dark' }}"
                href="{{ route('events.all') }}">Events</a>
            @auth
                @if (Auth::user()->role == 'user')
                    <a class="fw-semibold text-decoration-none {{ $activeMenu == 'tiket' ? 'text-primary' : 'text-dark' }}"
                        href="#">Tiket</a>
                    <a class="fw-semibold text-decoration-none {{ $activeMenu == 'profile' ? 'text-primary' : 'text-dark' }}"
                        href="#">Profile</a>
                @endif
            @endauth
        </div>

        <div class="gap-2 d-none d-xl-flex align-items-center">
            @auth
                @if (Auth::user()->role != 'user')
                    <a href="{{ route('dashboard') }}" class="px-4 btn btn-outline-dark rounded-pill">
                        Dashboard
                    </a>
                @endif
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="px-4 btn btn-outline-danger rounded-pill">
                        Logout
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="px-4 btn btn-outline-dark rounded-pill">
                    Login
                </a>
                <a href="{{ route('register') }}" class="px-4 btn btn-dark rounded-pill">
                    Register
                </a>
            @endauth
        </div>

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

    <div class="gap-3 offcanvas-body d-flex flex-column">

        <a class="fw-semibold text-decoration-none {{ $activeMenu == 'home' ? 'text-primary' : 'text-dark' }}"
            href="/">Home</a>
        <a class="fw-semibold text-decoration-none {{ $activeMenu == 'event' ? 'text-primary' : 'text-dark' }}"
            href="{{ route('events.all') }}">Events</a>

        @auth
            <a class="fw-semibold text-decoration-none {{ $activeMenu == 'tiket' ? 'text-primary' : 'text-dark' }}"
                href="#">Tiket</a>
            <a class="fw-semibold text-decoration-none {{ $activeMenu == 'profile' ? 'text-primary' : 'text-dark' }}"
                href="#">Profile</a>
        @endauth

        <hr>

        <div class="gap-2 d-flex flex-column">
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
