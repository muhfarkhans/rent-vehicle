@extends('layout')

@section('css')
@endsection

@section('content-title')
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Kendaraan</h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('vehicle.index') }}">Kendaraan</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit</li>
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
                    <h4 class="card-title">Edit data kendaraan</h4>
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
                        <form class="form form-horizontal" action="{{ route('vehicle.update', $vehicle->id) }}"
                            method="post">
                            @csrf
                            <input type="text" name="id" value="{{ $vehicle->id }}" hidden required>
                            <div class="form-body">
                                <div class="row">
                                    <div class="mb-3 form-group">
                                        <label>Asal kendaraan</label>
                                        <select name="vehicle_origin_id" id="" class="form-control form-control-lg"
                                            required>
                                            @foreach ($origins as $origin)
                                                <option value="{{ $origin->id }}" @selected($origin->id == $vehicle->vehicle_origin_id)>
                                                    {{ $origin->name }}
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3 form-group">
                                        <label>Tipe kendaraan</label>
                                        <select name="vehicle_type_id" id="" class="form-control form-control-lg"
                                            required>
                                            @foreach ($types as $type)
                                                <option value="{{ $type->id }}" @selected($type->id == $vehicle->vehicle_type_id)>
                                                    {{ $type->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3 form-group">
                                        <label>Kepemilikan</label>
                                        <input type="text" class="form-control form-control-lg" name="ownership"
                                            placeholder="Kepemilikan" value="{{ $vehicle->ownership }}" required>
                                    </div>
                                    <div class="mb-3 form-group">
                                        <label>Nama</label>
                                        <input type="text" class="form-control form-control-lg" name="name"
                                            placeholder="Nama kendaraan" value="{{ $vehicle->name }}" required>
                                    </div>
                                    <div class="mb-3 form-group">
                                        <label>No polisi</label>
                                        <input type="text" class="form-control form-control-lg" name="police_number"
                                            placeholder="XX-XXXX-XX" value="{{ $vehicle->police_number }}" required>
                                    </div>
                                    <div class="mb-3 form-group">
                                        <label>Jenis bahan bakar</label>
                                        <select name="fuel_type" id="" class="form-control form-control-lg"
                                            required>
                                            @foreach ($fuelTypes as $fuel)
                                                <option value="{{ $fuel }}" @selected($fuel == $vehicle->fuel_type)>
                                                    {{ $fuel }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3 form-group">
                                        <label>Tanggal awal service</label>
                                        <input type="date" class="form-control form-control-lg" name="repair_date"
                                            value="{{ $vehicle->repair_date }}" required>
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
