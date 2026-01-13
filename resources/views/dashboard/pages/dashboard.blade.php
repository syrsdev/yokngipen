@extends('dashboard.layouts.layout')

@section('contents')
    @include('dashboard.partials.heading', ['title' => 'Dashboard'])

    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-9">
                <div class="row">
                    <div class="col-6 col-lg-4 col-md-6">
                        <div class="card">
                            <div class="px-4 card-body py-4-5">
                                <div class="row">
                                    <div style="width: fit-content" class="d-flex justify-content-start">
                                        <div class="mb-2 stats-icon purple">
                                            <i class="bi-calendar-event-fill"></i>
                                        </div>
                                    </div>
                                    <div style="width: fit-content" class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="font-semibold text-muted">Jumlah Event</h6>
                                        <h6 class="mb-0 font-extrabold">{{ $jumlahEvent }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-4 col-md-6">
                        <div class="card">
                            <div class="px-4 card-body py-4-5">
                                <div class="row">
                                    <div style="width: fit-content" class="d-flex justify-content-start">
                                        <div class="mb-2 stats-icon blue">
                                            <i class="iconly-boldShow"></i>
                                        </div>
                                    </div>
                                    <div style="width: fit-content" class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="font-semibold text-muted">Event Berlangsung</h6>
                                        <h6 class="mb-0 font-extrabold">{{ $eventBerlangsung }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if (auth()->user()->role == 'organizer')
                        <div class="col-6 col-lg-4 col-md-6">
                            <div class="card">
                                <div class="px-4 card-body py-4-5">
                                    <div class="row">
                                        <div style="width: fit-content" class="d-flex justify-content-start">
                                            <div class="mb-2 stats-icon red">
                                                <i class="iconly-boldBookmark"></i>
                                            </div>
                                        </div>
                                        <div style="width: fit-content" class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                            <h6 class="font-semibold text-muted">Event Selesai</h6>
                                            <h6 class="mb-0 font-extrabold">{{ $eventSelesai }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if (auth()->user()->role == 'admin')
                        <div class="col-6 col-lg-4 col-md-6">
                            <div class="card">
                                <div class="px-4 card-body py-4-5">
                                    <div class="row">
                                        <div style="width: fit-content" class="d-flex justify-content-start">
                                            <div class="mb-2 stats-icon red">
                                                <i class="iconly-boldProfile"></i>
                                            </div>
                                        </div>
                                        <div style="width: fit-content" class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                            <h6 class="font-semibold text-muted">Jumlah User</h6>
                                            <h6 class="mb-0 font-extrabold">{{ $jumlahUser }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Profile Visit</h4>
                            </div>
                            <div class="card-body">
                                <div id="chart-profile-visit"></div>
                            </div>
                        </div>
                    </div>
                </div>
                @if (auth()->user()->role == 'admin')
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Pengguna</h4>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table" id="table1">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Phone</th>
                                                    <th>Role</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($users as $item)
                                                    <tr>
                                                        <td>{{ $item->name }}</td>
                                                        <td>{{ $item->email }}</td>
                                                        <td>{{ $item->phone }}</td>
                                                        <td>{{ $item->role }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <a href="{{ route('users.index') }}" class="mt-5 btn btn-primary w-100">Lihat
                                            Semua</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <div class="col-12 col-lg-3">
                <div class="card">
                    <div class="px-4 py-4 card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar avatar-xl">
                                <img src="{{ asset('/template/assets/compiled/jpg/1.jpg') }}" alt="Face 1">
                            </div>
                            <div class="ms-3 name">
                                <h5 class="font-bold text-wrap">{{ auth()->user()->name }}</h5>
                                <h6 class="mb-0 text-muted text-wrap">{{ auth()->user()->email }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
                @if (auth()->user()->role == 'admin')
                    <div class="card">
                        <div class="card-header">
                            <h4>Perbandingan Pengguna</h4>
                        </div>
                        <div class="card-body">
                            <div id="chart-visitors-profile"></div>
                        </div>
                    </div>
                @endif
            </div>
        </section>
    </div>
@endsection
