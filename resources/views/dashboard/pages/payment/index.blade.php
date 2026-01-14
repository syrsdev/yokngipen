@extends('dashboard.layouts.layout')

@section('contents')
    @include('dashboard.partials.heading', [
        'title' => 'Verifikasi Pembayaran',
    ])

    <section class="section">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title">
                    Konfirmasi untuk pembayaran tiket event
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" id="table1">
                        <thead>
                            <tr>
                                <th>Code</th>
                                <th>Jumlah</th>
                                <th>Bukti bayar</th>
                                <th>status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{ $item->order_code }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>
                                        <a href="{{ Storage::url($item->payment->payment_proof) }}" target="_blank">
                                            Lihat Bukti
                                        </a>
                                    </td>
                                    <td>{{ $item->status }}</td>
                                    <td class="gap-2 d-flex">
                                        <form action="{{ route('orders.validate', $item->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="action" value="approve">
                                            <button class="btn btn-success btn-sm">
                                                Approve
                                            </button>
                                        </form>

                                        <form action="{{ route('orders.validate', $item->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin tolak pembayaran ini?')">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="action" value="reject">
                                            <button class="btn btn-danger btn-sm">
                                                Reject
                                            </button>
                                        </form>

                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </section>
@endsection

@section('css')
    <link rel="stylesheet"
        href="{{ asset('/template/assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">

    <link rel="stylesheet" href="{{ asset('/template/assets/compiled/css/table-datatable-jquery.css') }}">
@endsection

@section('js')
    <script src="{{ asset('/template/assets/extensions/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('/template/assets/extensions/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('/template/assets/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('/template/assets/static/js/pages/datatables.js') }}"></script>
@endsection
