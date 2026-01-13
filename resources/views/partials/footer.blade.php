<footer class="pt-5 pb-4 mt-5 text-white" style="background-color: #211e75;">
    <div class="container py-4">
        <div class="row gy-4 justify-content-between text-center text-md-start">

            <!-- Brand -->
            <div class="col-12 col-md-3">
                <h3 class="mb-3 fw-bold fs-3">Yokngipen</h3>
                <p class="mb-0 opacity-75 fs-6">
                    Tempat beli tiket event terbaik dan terpercaya.
                </p>
            </div>

            <!-- Menu -->
            <div class="col-12 col-md-3">
                <h5 class="mb-4 fw-bold">Menu</h5>
                <ul class="list-unstyled fs-6">
                    <li class="mb-3">
                        <a href="{{ route('home') }}" class="text-white text-decoration-none opacity-75">
                            Halaman Utama
                        </a>
                    </li>
                    <li class="mb-3">
                        <a href="{{ route('events.all') }}" class="text-white text-decoration-none opacity-75">
                            Lihat Event
                        </a>
                    </li>
                </ul>
            </div>

        </div>

        <hr class="my-5 border-white opacity-25">

        <div class="d-flex flex-column flex-md-row justify-content-center align-items-center fs-6 text-center gap-2">
            <p class="mb-0">
                © {{ date('Y') }} Yokngipen. Hak Cipta Dilindungi.
            </p>
        </div>
    </div>
</footer>
