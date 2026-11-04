<?php

namespace App\Http\Controllers;

use App\Models\DetailPesanan;
use App\Models\Pembeli;
use App\Models\Pesanan;
use App\Models\Produk;
use App\Support\Cart;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    /**
     * Batas waktu pembayaran sejak pesanan dibuat.
     */
    protected const MENIT_BATAS_BAYAR = 30;

    /**
     * Form checkout: isi data pembeli (FP-05).
     */
    public function create(): View|RedirectResponse
    {
        $items = Cart::items();

        if ($items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang masih kosong.');
        }

        return view('checkout.create', [
            'items' => $items,
            'total' => Cart::total(),
        ]);
    }

    /**
     * Proses checkout: buat pesanan & tahan unit (FS-02, FS-03 saat belum
     * bayar belum berlaku — unit baru ditandai Terjual setelah pembayaran
     * berhasil; di sini unit ditahan dulu agar tidak dipesan ganda).
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'nomor_hp' => ['required', 'string', 'max:20'],
            'alamat' => ['required', 'string'],
        ]);

        $idProduk = Cart::ids();

        if (empty($idProduk)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang masih kosong.');
        }

        try {
            $pesanan = $this->buatPesanan($data, $idProduk);
        } catch (\RuntimeException $e) {
            return redirect()->route('cart.index')->with('error', $e->getMessage());
        }

        Cart::clear();

        return redirect()->route('pembayaran.show', $pesanan);
    }

    /**
     * @param  array<string, mixed>  $data
     * @param  array<int>  $idProduk
     */
    protected function buatPesanan(array $data, array $idProduk): Pesanan
    {
        return DB::transaction(function () use ($data, $idProduk) {
            $produkTerkunci = Produk::whereIn('id_produk', $idProduk)->lockForUpdate()->get();

            $tidakTersedia = $produkTerkunci->where('status', '!=', 'Tersedia');
            if ($tidakTersedia->isNotEmpty()) {
                $nama = $tidakTersedia->map(fn ($p) => "{$p->merek} {$p->model}")->implode(', ');
                throw new \RuntimeException("Unit berikut sudah tidak tersedia: {$nama}");
            }

            $pembeli = Pembeli::create($data);

            $pesanan = Pesanan::create([
                'id_pembeli' => $pembeli->id_pembeli,
                'total' => $produkTerkunci->sum('harga'),
                'status_pesanan' => 'Menunggu Pembayaran',
                'batas_bayar' => now()->addMinutes(self::MENIT_BATAS_BAYAR),
            ]);

            foreach ($produkTerkunci as $produk) {
                DetailPesanan::create([
                    'id_pesanan' => $pesanan->id_pesanan,
                    'id_produk' => $produk->id_produk,
                    'harga_satuan' => $produk->harga,
                    'jumlah' => 1,
                ]);

                $produk->update(['status' => 'Ditahan']);
            }

            return $pesanan;
        });
    }
}
