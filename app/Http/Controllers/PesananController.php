<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\View\View;

class PesananController extends Controller
{
    /**
     * Konfirmasi pesanan setelah pembayaran berhasil (FP-07).
     */
    public function konfirmasi(Pesanan $pesanan): View
    {
        return view('pesanan.konfirmasi', [
            'pesanan' => $pesanan->load('pembeli', 'detailPesanan.produk', 'pembayaran'),
        ]);
    }
}
