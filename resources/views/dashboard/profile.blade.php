@extends('dashboard.layouts.layout')

@section('contents')
<div class="container mt-4">
    <h3>Edit Profile</h3>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('dashboard.profile.update') }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text"
                        name="name"
                        class="form-control"
                        value="{{ old('name', $user->name) }}"
                        required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email"
                        name="email"
                        class="form-control"
                        value="{{ old('email', $user->email) }}"
                        required>
                </div>

                <button class="btn btn-primary">
                    Simpan Perubahan
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
