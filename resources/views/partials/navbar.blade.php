<nav class="py-3 bg-white shadow-sm sticky-top">
    <div class="container d-flex align-items-center justify-content-between">

        <!-- BRAND -->
        <a class="fw-bold fs-3 text-decoration-none" href="/" style="color: #211e75;">
            Yokngipen
        </a>

        <!-- MENU -->
        <ul class="gap-4 mb-0 d-flex align-items-center list-unstyled fs-5">
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
        <div class="gap-2 d-flex">
            @auth
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

    </div>
</nav>
