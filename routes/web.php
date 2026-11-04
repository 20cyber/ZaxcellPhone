<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ProdukController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ProdukController::class, 'index'])->name('katalog.index');
Route::get('/produk/{produk}', [ProdukController::class, 'show'])->name('katalog.show');

Route::middleware('guest')->group(function () {
    Route::get('/admin/login', [LoginController::class, 'create'])->name('login');
    Route::post('/admin/login', [LoginController::class, 'store'])->middleware('throttle:5,1');
});

Route::middleware('auth')->group(function () {
    Route::post('/admin/logout', [LoginController::class, 'destroy'])->name('admin.logout');
    Route::get('/admin', [DashboardController::class, 'index'])->name('admin.dashboard');
});
