<?php

use App\Http\Controllers\Admin\AkunController as AdminAkunController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FotoMassalController;
use App\Http\Controllers\Admin\PesananController as AdminPesananController;
use App\Http\Controllers\Admin\ProdukController as AdminProdukController;
use App\Http\Controllers\Admin\PricelistImportController;
use App\Http\Controllers\Admin\ProdukImportController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\ProdukController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ProdukController::class, 'index'])->name('katalog.index');
Route::get('/produk/{produk}', [ProdukController::class, 'show'])->name('katalog.show');

Route::get('/keranjang', [CartController::class, 'index'])->name('cart.index');
Route::post('/keranjang/{produk}', [CartController::class, 'store'])->name('cart.store');
Route::delete('/keranjang/{produk}', [CartController::class, 'destroy'])->name('cart.destroy');

Route::get('/checkout', [CheckoutController::class, 'create'])->name('checkout.create');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

Route::get('/pembayaran/{pesanan}', [PembayaranController::class, 'show'])->name('pembayaran.show');
Route::post('/pembayaran/{pesanan}/notifikasi', [PembayaranController::class, 'notifikasi'])->name('pembayaran.notifikasi');

Route::get('/pesanan/{pesanan}/konfirmasi', [PesananController::class, 'konfirmasi'])->name('pesanan.konfirmasi');

Route::middleware('guest')->group(function () {
    Route::get('/admin/login', [LoginController::class, 'create'])->name('login');
    Route::post('/admin/login', [LoginController::class, 'store'])->middleware('throttle:5,1');
});

Route::prefix('admin')->middleware('auth')->name('admin.')->group(function () {
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('produk', AdminProdukController::class)->except(['show']);
    Route::patch('produk/{produk}/stok', [AdminProdukController::class, 'updateStok'])->name('produk.stok');
    Route::delete('produk-hapus-massal', [AdminProdukController::class, 'hapusMassal'])->name('produk.hapus-massal');

    Route::get('produk-import', [ProdukImportController::class, 'create'])->name('produk.import.create');
    Route::get('produk-import/template', [ProdukImportController::class, 'template'])->name('produk.import.template');
    Route::post('produk-import', [ProdukImportController::class, 'store'])->name('produk.import.store');

    Route::get('pricelist-import', [PricelistImportController::class, 'create'])->name('pricelist-import.create');
    Route::post('pricelist-import/analisis', [PricelistImportController::class, 'analisis'])->name('pricelist-import.analisis');
    Route::post('pricelist-import/simpan', [PricelistImportController::class, 'simpan'])->name('pricelist-import.simpan');

    Route::get('foto-massal', [FotoMassalController::class, 'create'])->name('foto-massal.create');
    Route::post('foto-massal/analisis', [FotoMassalController::class, 'analisis'])->name('foto-massal.analisis');
    Route::post('foto-massal/simpan', [FotoMassalController::class, 'simpan'])->name('foto-massal.simpan');

    Route::get('pesanan', [AdminPesananController::class, 'index'])->name('pesanan.index');
    Route::get('pesanan/{pesanan}', [AdminPesananController::class, 'show'])->name('pesanan.show');
    Route::patch('pesanan/{pesanan}/status', [AdminPesananController::class, 'updateStatus'])->name('pesanan.status');

    Route::get('akun', [AdminAkunController::class, 'index'])->name('akun.index');
    Route::get('akun/tambah', [AdminAkunController::class, 'create'])->name('akun.create');
    Route::post('akun', [AdminAkunController::class, 'store'])->name('akun.store');
});
