@extends('auth.layouts.layout')

@section('content')
    @include('auth.partials.heading', [
        'title' => 'Register.',
        'desc' => 'Sign up with your data that you entered during registration.',
    ])
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="mb-4 form-group position-relative has-icon-left">
            <input type="text" class="form-control form-control-xl" placeholder="Nama Lengkap" name="name"
                value="{{ old('name') }}" autofocus required>
            <div class="form-control-icon">
                <i class="bi bi-person"></i>
            </div>
        </div>
        <div class="mb-4 form-group position-relative has-icon-left">
            <input type="email" class="form-control form-control-xl" placeholder="Email" name="email"
                value="{{ old('email') }}" required>
            <div class="form-control-icon">
                <i class="bi bi-envelope"></i>
            </div>
        </div>
        <div class="mb-4 form-group position-relative has-icon-left">
            <input type="text" class="form-control form-control-xl" placeholder="Nomor Telepon" name="phone"
                value="{{ old('phone') }}" required>
            <div class="form-control-icon">
                <i class="bi bi-telephone"></i>
            </div>
        </div>
        <div class="mb-4 form-group position-relative has-icon-left">
            <input type="password" class="form-control form-control-xl" placeholder="Password" name="password" required>
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
        <button class="mt-5 shadow-lg btn btn-primary btn-block btn-lg">Register</button>
    </form>
    <div class="mt-5 text-lg text-center fs-4">
        <p class="text-gray-600">Don't have an account? <a href="{{ route('login') }}" class="font-bold">Log in</a>.</p>
    </div>
@endsection
