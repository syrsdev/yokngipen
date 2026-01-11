@extends('dashboard.layouts.layout')

@section('contents')
    @include('dashboard.partials.heading', ['title' => 'Management User'])

    <section class="section">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title">
                    Data User
                </h5>

                <a href="{{ route('users.create') }}" class="btn btn-success">Tambah User</a>
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
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>{{ $item->phone }}</td>
                                    <td>{{ $item->role }}</td>
                                    <td>
                                        @include('dashboard.partials.action', [
                                            'route' => 'users',
                                            'id' => $item->id,
                                            'show' => false,
                                            'edit' => true,
                                            'delete' => true,
                                        ])
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
