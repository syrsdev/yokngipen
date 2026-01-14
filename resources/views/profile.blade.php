@extends('layouts.app')

@section('content')
    <section class="container mt-5 mb-5">

        <div class="row justify-content-center">
            <div class="col-lg-8">

                <div class="mb-4 border-0 shadow-sm card rounded-4">
                    <div class="bg-white border-0 card-header">
                        <h5 class="mb-0 fw-bold">Edit Profil</h5>
                        <small class="text-muted">Perbarui informasi akun Anda</small>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('dashboard.profile.update') }}">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Nama Lengkap</label>
                                <input type="text" name="name" class="form-control rounded-pill"
                                    value="{{ old('name', $user->name) }}" required>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold">Email</label>
                                <input type="email" name="email" class="form-control rounded-pill"
                                    value="{{ old('email', $user->email) }}" required>
                            </div>

                            <button class="px-4 btn btn-primary rounded-pill">
                                Simpan Perubahan
                            </button>
                        </form>
                    </div>
                </div>

                <div class="border-0 shadow-sm card rounded-4">
                    <div class="bg-white border-0 card-header">
                        <h5 class="mb-0 fw-bold">Ganti Password</h5>
                        <small class="text-muted">Gunakan password yang kuat & aman</small>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf
                            @method('PUT')

                            <div class="mb-3 position-relative">
                                <label class="form-label fw-semibold">Password Saat Ini</label>
                                <input type="password" class="form-control rounded-pill" name="current_password" required>
                            </div>

                            <div class="mb-3 position-relative">
                                <label class="form-label fw-semibold">Password Baru</label>
                                <input type="password" class="form-control rounded-pill" name="password" required>
                            </div>

                            <div class="mb-4 position-relative">
                                <label class="form-label fw-semibold">Konfirmasi Password Baru</label>
                                <input type="password" class="form-control rounded-pill" name="password_confirmation"
                                    required>
                            </div>

                            <button class="px-4 btn btn-warning rounded-pill">
                                Update Password
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>

    </section>
@endsection
