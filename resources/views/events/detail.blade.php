@extends('layouts.app')

@section('content')
    <div class="container my-5">
        <div class="row g-4">

            <div class="col-12 col-lg-8">
                <div class="overflow-hidden border-0 shadow-sm card rounded-4">
                    <img src="{{ asset('banner/' . $event->banner) }}" class="img-fluid w-100"
                        style="max-height: 420px; object-fit: cover;">
                </div>

                <h3 class="mt-4 fw-bold fs-3">{{ $event->title }}</h3>

                <div class="mt-3">
                    <h5 class="fw-bold">Deskripsi</h5>
                    <p class="text-muted">
                        {{ $event->description }}
                    </p>
                </div>
            </div>

            <div class="col-12 col-lg-4">
                <div class="p-4 border-0 shadow-sm card rounded-4">

                    <h5 class="mb-3 fw-bold">Detail Event</h5>

                    <div class="mb-3">
                        <small class="text-muted">📅 Tanggal</small>
                        <div class="fw-semibold">
                            {{ \Carbon\Carbon::parse($event->start_date)->translatedFormat('d F Y') }}
                        </div>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted">📍 Lokasi</small>
                        <div class="fw-semibold">{{ $event->location }}</div>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted">💰 Harga</small>
                        @foreach ($event->prices as $item)
                            <p>
                                {{ $item->name }} :
                                <span class="fw-semibold text-primary">
                                    Rp{{ number_format($item->price, 0, ',', '.') }}
                                </span> (tersisa {{ $item->quota }} tiket)
                            </p>
                        @endforeach
                    </div>

                    <div class="mb-3">
                        <small class="text-muted">📌 Status</small>
                        <div>
                            <span class="badge bg-success">{{ $event->status }}</span>
                        </div>
                    </div>
                </div>
                @if (auth()->user()->role == 'user' && $event->status == 'published')
                    <form action="{{ route('order.store') }}" method="POST" class="p-4 mt-5 border-0 shadow-sm card"
                        enctype="multipart/form-data">
                        @csrf
                        <h5 class="mb-3 fw-bold">Beli tiket</h5>
                        <select name="event_price_id" class="form-select rounded-pill" aria-label="Default select example">
                            <option selected>Pilih Harga dan Tipe</option>
                            @foreach ($event->prices as $item)
                                <option  value="{{ $item->id }}">{{ $item->name }} -
                                    Rp{{ number_format($item->price, 0, ',', '.') }}</option>
                            @endforeach
                        </select>
                        <div class="mt-4 form-group">
                            <label for="quantity" class="form-label">Jumlah Tiket</label>
                            <input type="number" class="form-control form-control-xl rounded-pill"
                                placeholder="Jumlah Tiket" name="quantity" value="{{ old('quantity') }}" autofocus
                                required>
                        </div>
                        <div class="my-4">
                            <small class="text-muted">Bayar Melalui</small>
                            <div class="fw-semibold">{{ $event->payment_method }} - {{ $event->account_number }}</div>
                        </div>
                        <div class="mb-4 form-group">
                            <label for="payment_proof" class="form-label">Upload Bukti Pembayaran</label>
                            <input type="file" class="form-control" name="payment_proof" id="payment_proof">
                        </div>
                        <button class="mt-4 btn btn-primary w-100 rounded-pill">
                            Beli Tiket
                        </button>
                    </form>
                @endif
            </div>

        </div>
    </div>
@endsection
