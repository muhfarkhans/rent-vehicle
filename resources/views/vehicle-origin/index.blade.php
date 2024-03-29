@extends('layout')

@section('css')
    <link rel="stylesheet" href="assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="./assets/compiled/css/table-datatable-jquery.css">
@endsection

@section('content-title')
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Asal Kendaraan</h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">Asal Kendaraan</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <section class="section">
        <div class="card">
            <div class="card-header">
                <div class="btn-group d-flex justify-content-between">
                    <div class="d-flex justify-content-start mt-2">
                        <h5 class="card-title">
                            Tabel
                        </h5>
                    </div>

                    <div class="d-flex justify-content-end mb-3">
                        <div class="mb-n3">
                            <a href="{{ route('vehicle-origin.create') }}">
                                <button class="btn btn-primary">
                                    Tambah data
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if (session('message'))
                    <div class="col-lg-12">
                        <div class="alert alert-success" role="alert">{{ session('message') }}</div>
                    </div>
                @endif
                <table class="table table-striped datatables" id="table1">
                    <thead>
                        <tr>
                            <th>No. </th>
                            <th>Nama</th>
                            <th>Jumlah Kendaraan</th>
                            <th>Alamat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>

    </section>
@endsection

@push('js')
    <script src="assets/extensions/jquery/jquery.min.js"></script>
    <script src="assets/extensions/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="assets/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
    <script type="text/javascript">
        $(function() {
            const table = $('.datatables').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('vehicle-origin.datatables') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'total_vehicle',
                        name: 'total_vehicle'
                    },
                    {
                        data: 'address',
                        name: 'address'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: true,
                        searchable: true
                    },
                ]
            });
        });
    </script>
@endpush
