@extends('dashboard.layouts.layout')

@section('contents')
    @include('dashboard.partials.heading', ['title' => 'Buat Event'])

    <section class="section">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('events.storePrice') }}">
                    @csrf
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
