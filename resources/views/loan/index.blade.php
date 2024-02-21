@extends('layout')

@section('css')
    <link rel="stylesheet" href="assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="./assets/compiled/css/table-datatable-jquery.css">
@endsection

@section('content-title')
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Peminjaman</h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">Peminjaman</li>
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
                            Export
                        </h5>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <a href="{{ route('loan.export') }}">
                    <button class="btn btn-primary">
                        Export seluruh data
                    </button>
                </a>
                <form action="{{ route('loan.export') }}" method="post" class="mt-5">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Tanggal mulai</label>
                                <input type="date" class="form-control form-control-lg" name="start_date" required>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Tanggal selesai</label>
                                <input type="date" class="form-control form-control-lg" name="end_date" required>
                            </div>
                        </div>
                        <div class="col-md-4 d-flex  align-items-center">
                            <button class="btn btn-primary btn-block">Export</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
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
                            @if (Auth::user()->role_id == 1)
                                <a href="{{ route('loan.create') }}">
                                    <button class="btn btn-primary">
                                        Create
                                    </button>
                                </a>
                            @endif
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
                            <th>Tanggal pengajuan</th>
                            <th>Status</th>
                            <th>Nama Kendaraan</th>
                            <th>Nama Peminjam</th>
                            <th>BBM</th>
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
                ajax: "{{ route('loan.datatables') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'message_text',
                        name: 'message_text'
                    },
                    {
                        data: 'vehicle.name',
                        name: 'vehicle.name'
                    },
                    {
                        data: 'pegawai.name',
                        name: 'pegawai.name'
                    },
                    {
                        data: 'fuel_cost',
                        name: 'fuel_cost'
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
