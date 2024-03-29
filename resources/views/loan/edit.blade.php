@extends('layout')

@section('css')
@endsection

@section('content-title')
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Pengguna</h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('user.index') }}">Pengguna</a></li>
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
                    <h4 class="card-title">Edit data pengguna</h4>
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
                        <form class="form form-horizontal" action="{{ route('user.update', $user->id) }}" method="post">
                            @csrf
                            <input type="text" name="id" value="{{ $user->id }}" hidden required>
                            <div class="form-body">
                                <div class="row">
                                    <div class="mb-3 form-group">
                                        <label>Nama</label>
                                        <input type="text" class="form-control form-control-lg" name="name"
                                            placeholder="Nama" value="{{ $user->name }}" required>
                                    </div>
                                    <div class="mb-3 form-group">
                                        <label>Email</label>
                                        <input type="email" class="form-control form-control-lg" name="email"
                                            placeholder="email@email.com" value="{{ $user->email }}" required>
                                    </div>
                                    <div class="mb-3 form-group">
                                        <label>Password</label>
                                        <input type="password" class="form-control form-control-lg" name="password">
                                    </div>
                                    <div class="mb-3 form-group">
                                        <label>Role</label>
                                        <select name="role_id" id="" class="form-control form-control-lg" required>
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->id }}" @selected($user->role_id == $role->id)>
                                                    {{ $role->name }}
                                                </option>
                                            @endforeach
                                        </select>
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
