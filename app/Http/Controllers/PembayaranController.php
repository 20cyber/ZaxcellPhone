<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Pesanan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PembayaranController extends Controller
{
    /**
     * Halaman pembayaran — mensimulasikan redirect ke payment gateway
     * (Midtrans/Xendit belum diintegrasikan, lihat docs/keputusan-teknologi.md).
     */
    public function show(Pesanan $pesanan): View|RedirectResponse
    {
        $this->batalkanJikaKedaluwarsa($pesanan);
        $pesanan->refresh();

        if ($pesanan->status_pesanan === 'Dibayar') {
            return redirect()->route('pesanan.konfirmasi', $pesanan);
        }

        if ($pesanan->status_pesanan === 'Dibatalkan') {
            return redirect()->route('katalog.index')->with('error', 'Pesanan sudah kedaluwarsa dan dibatalkan.');
        }

        $pembayaran = Pembayaran::firstOrCreate(
            ['id_pesanan' => $pesanan->id_pesanan, 'status' => 'pending'],
            [
                'order_id_gateway' => 'ZAX-' . $pesanan->id_pesanan . '-' . Str::upper(Str::random(6)),
                'metode' => 'simulasi',
                'jumlah' => $pesanan->total,
            ]
        );

        return view('pembayaran.show', [
            'pesanan' => $pesanan->load('detailPesanan.produk'),
            'pembayaran' => $pembayaran,
        ]);
    }

    /**
     * Simulasi notifikasi dari payment gateway (FS-01).
     * Di produksi, endpoint ini akan digantikan webhook resmi gateway.
     */
    public function notifikasi(Request $request, Pesanan $pesanan): RedirectResponse
    {
        $this->batalkanJikaKedaluwarsa($pesanan);
        $pesanan->refresh();

        if ($pesanan->status_pesanan !== 'Menunggu Pembayaran') {
            return redirect()->route('pembayaran.show', $pesanan);
        }

        $berhasil = $request->input('hasil') === 'berhasil';

        DB::transaction(function () use ($pesanan, $berhasil) {
            $pembayaran = Pembayaran::where('id_pesanan', $pesanan->id_pesanan)
                ->where('status', 'pending')
                ->latest()
                ->first();

            $pembayaran?->update([
                'status' => $berhasil ? 'success' : 'failed',
                'waktu_bayar' => $berhasil ? now() : null,
            ]);

            if ($berhasil) {
                $pesanan->update(['status_pesanan' => 'Dibayar']);

                foreach ($pesanan->detailPesanan as $detail) {
                    $detail->produk?->update(['status' => 'Terjual']);
                }
            }
        });

        return redirect()->route(
            $berhasil ? 'pesanan.konfirmasi' : 'pembayaran.show',
            $pesanan
        )->with($berhasil ? 'status' : 'error', $berhasil
            ? 'Pembayaran berhasil.'
            : 'Simulasi pembayaran gagal. Silakan coba lagi.');
    }

    /**
     * Batalkan pesanan & lepas unit kalau sudah lewat batas bayar (FS-04).
     */
    protected function batalkanJikaKedaluwarsa(Pesanan $pesanan): void
    {
        if ($pesanan->status_pesanan !== 'Menunggu Pembayaran' || $pesanan->batas_bayar->isFuture()) {
            return;
        }

        DB::transaction(function () use ($pesanan) {
            $pesanan->update(['status_pesanan' => 'Dibatalkan']);

            foreach ($pesanan->detailPesanan as $detail) {
                if ($detail->produk?->status === 'Ditahan') {
                    $detail->produk->update(['status' => 'Tersedia']);
                }
            }
        });
    }
}
