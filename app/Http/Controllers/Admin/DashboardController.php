<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Models\Produk;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Dashboard ringkasan admin (FA-02).
     */
    public function index(): View
    {
        return view('admin.dashboard', [
            'jumlahProduk' => Produk::count(),
            'jumlahTersedia' => Produk::where('status', 'Tersedia')->count(),
            'jumlahPesananMasuk' => Pesanan::where('status_pesanan', 'Menunggu Pembayaran')->count(),
        ]);
    }
}
