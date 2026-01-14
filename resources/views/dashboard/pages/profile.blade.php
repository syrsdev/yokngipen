@extends('dashboard.layouts.layout')

@section('contents')
    <div class="mt-4">
        <h3>Edit Profile</h3>
        <div class="mt-3 card">
            <div class="card-body">
                <form method="POST" action="{{ route('dashboard.profile.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="form-label">Nama</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}"
                            required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}"
                            required>
                    </div>

                    <button class="btn btn-primary">
                        Simpan Perubahan
                    </button>
                </form>
            </div>
        </div>
    </div>
    <h3>Ganti Password</h3>
    <div class="mt-3 card">
        <div class="card-body">
            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                @method('PUT')
                <div class="mb-4 form-group position-relative has-icon-left">
                    <input type="password" class="form-control form-control-xl" placeholder="Password saat ini"
                        name="current_password" required>
                    <div class="form-control-icon">
                        <i class="bi bi-shield-lock"></i>
                    </div>
                </div>
                <div class="mb-4 form-group position-relative has-icon-left">
                    <input type="password" class="form-control form-control-xl" placeholder="Password baru" name="password"
                        required>
                    <div class="form-control-icon">
                        <i class="bi bi-shield-lock"></i>
                    </div>
                </div>
                <div class="mb-4 form-group position-relative has-icon-left">
                    <input type="password" class="form-control form-control-xl" placeholder="Konfirmasi Password"
                        name="password_confirmation" required>
                    <div class="form-control-icon">
                        <i class="bi bi-shield-lock"></i>
                    </div>
                </div>
                <button class="btn btn-primary">
                    Simpan Perubahan
                </button>
            </form>
        </div>
    </div>
@endsection
