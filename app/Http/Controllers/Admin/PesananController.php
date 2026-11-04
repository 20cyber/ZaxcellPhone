<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PesananController extends Controller
{
    /**
     * Status lanjutan yang valid dari tiap status pesanan saat ini.
     *
     * @var array<string, array<int, string>>
     */
    protected const ALUR_STATUS = [
        'Menunggu Pembayaran' => ['Dibatalkan'],
        'Dibayar' => ['Diproses', 'Dibatalkan'],
        'Diproses' => ['Dikirim'],
        'Dikirim' => ['Selesai'],
        'Selesai' => [],
        'Dibatalkan' => [],
    ];

    /**
     * Daftar pesanan masuk & cek ketersediaan stok (FA-06).
     */
    public function index(Request $request): View
    {
        $pesanan = Pesanan::query()
            ->with('pembeli')
            ->when($request->string('status')->trim()->value(), function ($query, $status) {
                $query->where('status_pesanan', $status);
            })
            ->orderByDesc('created_at')
            ->paginate(15)
            ->withQueryString();

        return view('admin.pesanan.index', ['pesanan' => $pesanan]);
    }

    /**
     * Detail pesanan: verifikasi pembayaran (FA-07), proses & kirim (FA-08).
     */
    public function show(Pesanan $pesanan): View
    {
        $pesanan->load('pembeli', 'detailPesanan.produk', 'pembayaran', 'admin');

        return view('admin.pesanan.show', [
            'pesanan' => $pesanan,
            'statusLanjutan' => self::ALUR_STATUS[$pesanan->status_pesanan] ?? [],
        ]);
    }

    /**
     * Perbarui status pesanan, isi nomor resi saat dikirim (FA-08, FA-09).
     */
    public function updateStatus(Request $request, Pesanan $pesanan): RedirectResponse
    {
        $lanjutanValid = self::ALUR_STATUS[$pesanan->status_pesanan] ?? [];

        $data = $request->validate([
            'status_pesanan' => ['required', 'in:' . implode(',', $lanjutanValid)],
            'nomor_resi' => ['nullable', 'string', 'max:255', 'required_if:status_pesanan,Dikirim'],
        ]);

        DB::transaction(function () use ($pesanan, $data) {
            $pesanan->update([
                'status_pesanan' => $data['status_pesanan'],
                'nomor_resi' => $data['nomor_resi'] ?? $pesanan->nomor_resi,
                'id_admin' => auth()->id(),
            ]);

            if ($data['status_pesanan'] === 'Dibatalkan') {
                foreach ($pesanan->detailPesanan as $detail) {
                    if ($detail->produk && in_array($detail->produk->status, ['Ditahan', 'Terjual'], true)) {
                        $detail->produk->update(['status' => 'Tersedia']);
                    }
                }
            }
        });

        return redirect()->route('admin.pesanan.show', $pesanan)->with('status', 'Status pesanan diperbarui.');
    }
}
