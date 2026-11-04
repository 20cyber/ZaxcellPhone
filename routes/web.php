<?php

use App\Http\Controllers\ProdukController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ProdukController::class, 'index'])->name('katalog.index');
Route::get('/produk/{produk}', [ProdukController::class, 'show'])->name('katalog.show');
