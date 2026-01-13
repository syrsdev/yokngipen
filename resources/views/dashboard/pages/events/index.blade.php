@extends('dashboard.layouts.layout')

@section('contents')
    @include('dashboard.partials.heading', [
        'title' => ($title = auth()->user()->role == 'admin' ? 'Semua Event' : 'Event Saya'),
    ])

    <section class="section">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title">
                    Data Event
                </h5>

                @if (auth()->user()->role == 'organizer')
                    <a href="{{ route('events.create') }}" class="btn btn-success">Buat Event</a>
                @endif
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" id="table1">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Start date</th>
                                <th>End date</th>
                                <th>status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($events as $item)
                                <tr>
                                    <td>{{ $item->title }}</td>
                                    <td>{{ $item->start_date }}</td>
                                    <td>{{ $item->end_date }}</td>
                                    <td>{{ $item->status }}</td>
                                    <td>
                                        @include('dashboard.partials.action', [
                                            'route' => 'events',
                                            'id' => $item->id,
                                            'show' => true,
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
