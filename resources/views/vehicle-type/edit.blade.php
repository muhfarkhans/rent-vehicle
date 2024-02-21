@extends('layout')

@section('css')
@endsection

@section('content-title')
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Tipe Kendaraan</h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('vehicle-type.index') }}">Tipe kendaraan</a></li>
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
                    <h4 class="card-title">Edit data tipe kendaraan</h4>
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
                        <form class="form form-horizontal" action="{{ route('vehicle-type.update', $vehicle->id) }}"
                            method="post">
                            @csrf
                            <input type="text" name="id" value="{{ $vehicle->id }}" hidden required>
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="mb-3 form-group">
                                            <label>Nama tipe</label>
                                            <input type="text" class="form-control form-control-lg" name="name"
                                                placeholder="Masukkan nama tipe" value="{{ $vehicle->name }}" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                                    <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
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
