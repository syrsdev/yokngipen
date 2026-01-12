@extends('dashboard.layouts.layout')

@section('contents')
    @include('dashboard.partials.heading', ['title' => 'Tambah User'])

    <section class="section">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('users.update', $data->id) }}">
                    @csrf
                    @method('PUT')
                    <h6>Data</h6>
                    <div class="mb-4 form-group position-relative has-icon-left">
                        <input type="text" class="form-control form-control-xl" placeholder="Nama Lengkap" name="name"
                            value="{{ $data->name }}" autofocus required>
                        <div class="form-control-icon">
                            <i class="bi bi-person"></i>
                        </div>
                    </div>
                    <div class="mb-4 form-group position-relative has-icon-left">
                        <input type="email" class="form-control form-control-xl" placeholder="Email" name="email"
                            value="{{ $data->email }}" required>
                        <div class="form-control-icon">
                            <i class="bi bi-envelope"></i>
                        </div>
                    </div>
                    <div class="mb-4 form-group position-relative has-icon-left">
                        <input type="text" class="form-control form-control-xl" placeholder="Nomor Telepon"
                            name="phone" value="{{ $data->phone }}" required>
                        <div class="form-control-icon">
                            <i class="bi bi-telephone"></i>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="role" class="form-label">Role</label>
                        <div class="d-flex">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="role" id="role1" value="user"
                                    {{ $data->role == 'user' ? 'checked' : '' }}>
                                <label class="form-check-label" for="role1">
                                    User
                                </label>
                            </div>
                            <div class="form-check ms-4">
                                <input class="form-check-input" type="radio" name="role" id="role2"
                                    value="organizer" {{ $data->role == 'organizer' ? 'checked' : '' }}>
                                <label class="form-check-label" for="role2">
                                    Organizer
                                </label>
                            </div>
                        </div>
                    </div>

                    <button class="mt-5 shadow-lg btn btn-primary btn-block btn-lg">Simpan</button>
                </form>
            </div>
        </div>

    </section>
@endsection
