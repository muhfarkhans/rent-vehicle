@extends('layout')

@section('css')
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
                        <li class="breadcrumb-item"><a href="{{ route('loan.index') }}">Peminjaman</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Mengembalikan</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <section class="section">
        <div class="row">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Mengembalikan peminjaman</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        @if (session('message'))
                            <div class="col-lg-12">
                                <div class="alert alert-success" role="alert">{{ session('message') }}</div>
                            </div>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form class="form form-horizontal" action="{{ route('loan.return-back-store', $loan->id) }}"
                            method="post">
                            @csrf
                            <input type="text" name="id" value="{{ $loan->id }}" hidden required>
                            <div class="form-body">
                                <div class="row">
                                    <div class="mb-3 form-group">
                                        <p>Nama Kendaraan</p>
                                        <h5>{{ $loan->vehicle->name }}</h5>
                                        <p>Jenis Kendaraan</p>
                                        <h5>{{ $loan->vehicle->vehicleType->name }}</h5>
                                        <p>Asal Kendaraan</p>
                                        <h5>{{ $loan->vehicle->vehicleOrigin->name }}</h5>
                                        <p>Nomor Polisi</p>
                                        <h5>{{ $loan->vehicle->police_number }}</h5>
                                        <p>Jenis Bahan Bakar</p>
                                        <h5>{{ $loan->vehicle->fuel_type }}</h5>
                                        <hr>
                                        <p>Tanggal Peminjaman</p>
                                        <h5>{{ $loan->created_at }}</h5>
                                        <p>Disetujui oleh</p>
                                        <ul>
                                            <ol>
                                                <h5>{{ $loan->admin->name }}</h5>
                                            </ol>
                                            <ol>
                                                <h5>{{ $loan->petugas->name }}</h5>
                                            </ol>
                                        </ul>
                                    </div>
                                    <div class="mb-3 form-group">
                                        <label>Cost Penggunaan BBM</label>
                                        <input type="number" class="form-control form-control-lg" name="fuel_cost"
                                            placeholder="Harga BBM yang digunakan" required>
                                    </div>
                                    <div class="col-sm-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                                        <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('js')
@endpush
