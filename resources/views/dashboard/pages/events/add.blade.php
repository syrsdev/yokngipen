@extends('dashboard.layouts.layout')

@section('contents')
    @include('dashboard.partials.heading', ['title' => 'Buat Event'])

    <section class="section">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('events.store') }}" enctype="multipart/form-data">
                    @csrf
                    <h5>Data Event</h5>
                    <div class="mb-4 form-group position-relative">
                        <label for="banner" class="form-label">Banner Event</label>
                        <input type="file" class="form-control" name="banner" id="banner">
                    </div>
                    <div class="mb-4 form-group position-relative ">
                        <label for="title" class="form-label">Nama Event</label>
                        <input type="text" class="form-control form-control-xl" placeholder="Nama Event" name="title"
                            value="{{ old('title') }}" autofocus required>
                    </div>
                    <div class="mb-4 form-group position-relative">
                        <label for="description" class="form-label">Deskripsi Event</label>
                        <textarea name="description" class="form-control" id="description" cols="30" rows="10"></textarea>
                    </div>
                    <div class="mb-4 form-group position-relative ">
                        <label for="location" class="form-label">Lokasi</label>
                        <input type="text" class="form-control form-control-xl" placeholder="Lokasi" name="location"
                            value="{{ old('location') }}" autofocus required>
                    </div>
                    <div class="mb-4 form-group position-relative ">
                        <label for="start_date" class="form-label">Tanggal mulai</label>
                        <input type="datetime-local" class="form-control form-control-xl" placeholder="Tanggal mulai"
                            name="start_date" value="{{ old('start_date') }}" autofocus required>
                    </div>
                    <div class="mb-4 form-group position-relative ">
                        <label for="end_date" class="form-label">Tanggal selesai</label>
                        <input type="datetime-local" class="form-control form-control-xl" placeholder="Tanggal selesai"
                            name="end_date" value="{{ old('end_date') }}" autofocus required>
                    </div>
                    <div class="mb-4 form-group position-relative ">
                        <label for="payment_method" class="form-label">Metode Pembayaran</label>
                        <input type="text" class="form-control form-control-xl" placeholder="Ex: BCA/Mandiri/Gopay/Dana"
                            name="payment_method" value="{{ old('payment_method') }}" autofocus required>
                    </div>
                    <div class="mb-4 form-group position-relative ">
                        <label for="account_number" class="form-label">Nomor Rekening/Tujuan Pembayaran</label>
                        <input type="text" class="form-control form-control-xl" placeholder="Ex: 123456"
                            name="account_number" value="{{ old('account_number') }}" autofocus required>
                    </div>

                    <h5 class="mt-5">Tipe dan Harga</h5>
                    <div class="mb-4 form-group position-relative ">
                        <label for="name" class="form-label">Nama Tipe</label>
                        <input type="text" class="form-control form-control-xl" placeholder="Ex: Vip" name="name"
                            value="{{ old('name') }}" autofocus required>
                    </div>
                    <div class="mb-4 form-group position-relative ">
                        <label for="price" class="form-label">Harga</label>
                        <input type="text" class="form-control form-control-xl" placeholder="Ex: 500000" name="price"
                            value="{{ old('price') }}" autofocus required>
                    </div>
                    <div class="mb-4 form-group position-relative ">
                        <label for="quota" class="form-label">Slot/Kapasitas</label>
                        <input type="text" class="form-control form-control-xl" placeholder="Ex: 500" name="quota"
                            value="{{ old('quota') }}" autofocus required>
                    </div>
                    <button class="mt-5 shadow-lg btn btn-primary btn-block btn-lg">Buat</button>
                </form>
            </div>
        </div>
    </section>
@endsection
