@extends('auth.layouts.layout')

@section('content')
    @include('auth.partials.heading', [
        'title' => 'Log in.',
        'desc' => 'Log in with your data that you entered during registration.',
    ])

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="mb-4 form-group position-relative has-icon-left">
            <input type="email" class="form-control form-control-xl" placeholder="Email" required autofocus
                value="{{ old('email') }}" name="email">
            <div class="form-control-icon">
                <i class="bi bi-envelope"></i>
            </div>
        </div>
        <div class="mb-4 form-group position-relative has-icon-left">
            <input type="password" class="form-control form-control-xl" placeholder="Password" required name="password">
            <div class="form-control-icon">
                <i class="bi bi-shield-lock"></i>
            </div>
        </div>
        <button class="mt-5 shadow-lg btn btn-primary btn-block btn-lg">Log in</button>
    </form>
    <div class="mt-5 text-lg text-center fs-4">
        <p class="text-gray-600">Don't have an account? <a href="{{ route('register') }}" class="font-bold">Register</a>.
        </p>
    </div>
@endsection
