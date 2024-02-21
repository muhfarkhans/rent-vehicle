<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\VehicleOriginController;
use App\Http\Controllers\VehicleTypeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::get('/layout', function () {
    return view('layout');
});

Route::middleware('auth.role:1.2')->get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/authenticate', [AuthController::class, 'authenticate'])->name('authenticate');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->get('/profile', [ProfileController::class, 'index'])->name('profile');
Route::middleware(['auth'])->post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

Route::middleware(['auth.role:1.2'])->name('vehicle-origin.')->prefix('vehicle-origin')->group(
    function () {
        Route::get('/', [VehicleOriginController::class, 'index'])->name('index');
        Route::get('/datatables', [VehicleOriginController::class, 'datatables'])->name('datatables');
        Route::get('/create', [VehicleOriginController::class, 'create'])->name('create');
        Route::post('/store', [VehicleOriginController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [VehicleOriginController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [VehicleOriginController::class, 'update'])->name('update');
        Route::get('/delete/{id}', [VehicleOriginController::class, 'delete'])->name('delete');
    }
);

Route::middleware(['auth.role:1.2'])->name('vehicle-type.')->prefix('vehicle-type')->group(
    function () {
        Route::get('/', [VehicleTypeController::class, 'index'])->name('index');
        Route::get('/datatables', [VehicleTypeController::class, 'datatables'])->name('datatables');
        Route::get('/create', [VehicleTypeController::class, 'create'])->name('create');
        Route::post('/store', [VehicleTypeController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [VehicleTypeController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [VehicleTypeController::class, 'update'])->name('update');
        Route::get('/delete/{id}', [VehicleTypeController::class, 'delete'])->name('delete');
    }
);

Route::middleware(['auth.role:1.2'])->name('user.')->prefix('user')->group(
    function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/datatables', [UserController::class, 'datatables'])->name('datatables');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/store', [UserController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [UserController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [UserController::class, 'update'])->name('update');
        Route::get('/delete/{id}', [UserController::class, 'delete'])->name('delete');
    }
);

Route::middleware(['auth.role:1.2'])->name('vehicle.')->prefix('vehicle')->group(
    function () {
        Route::get('/', [VehicleController::class, 'index'])->name('index');
        Route::get('/datatables', [VehicleController::class, 'datatables'])->name('datatables');
        Route::get('/create', [VehicleController::class, 'create'])->name('create');
        Route::post('/store', [VehicleController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [VehicleController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [VehicleController::class, 'update'])->name('update');
        Route::get('/delete/{id}', [VehicleController::class, 'delete'])->name('delete');
    }
);

Route::middleware(['auth.role:1.2'])->name('loan.')->prefix('loan')->group(
    function () {
        Route::get('/', [LoanController::class, 'index'])->name('index');
        Route::get('/datatables', [LoanController::class, 'datatables'])->name('datatables');
        Route::get('/create', [LoanController::class, 'create'])->name('create');
        Route::post('/store', [LoanController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [LoanController::class, 'edit'])->name('edit');
        Route::get('/approve/{id}', [LoanController::class, 'approve'])->name('approve');
        Route::get('/unapprove/{id}', [LoanController::class, 'unApprove'])->name('unapprove');
        Route::get('/decline/{id}', [LoanController::class, 'decline'])->name('decline');
        Route::post('/update/{id}', [LoanController::class, 'update'])->name('update');
        Route::get('/delete/{id}', [LoanController::class, 'delete'])->name('delete');
        Route::get('/return-back/{id}', [LoanController::class, 'returnBack'])->name('return-back');
        Route::post('/return-back/{id}', [LoanController::class, 'returnBackStore'])->name('return-back-store');
        Route::get('/export', [LoanController::class, 'export'])->name('export');
        Route::post('/export', [LoanController::class, 'export'])->name('export');
    }
);