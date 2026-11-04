<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProdukController as AdminProdukController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ProdukController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ProdukController::class, 'index'])->name('katalog.index');
Route::get('/produk/{produk}', [ProdukController::class, 'show'])->name('katalog.show');

Route::middleware('guest')->group(function () {
    Route::get('/admin/login', [LoginController::class, 'create'])->name('login');
    Route::post('/admin/login', [LoginController::class, 'store'])->middleware('throttle:5,1');
});

Route::prefix('admin')->middleware('auth')->name('admin.')->group(function () {
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('produk', AdminProdukController::class)->except(['show']);
    Route::patch('produk/{produk}/stok', [AdminProdukController::class, 'updateStok'])->name('produk.stok');
});
