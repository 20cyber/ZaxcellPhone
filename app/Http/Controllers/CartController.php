<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Support\Cart;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CartController extends Controller
{
    /**
     * Lihat isi keranjang (FP-04).
     */
    public function index(): View
    {
        return view('cart.index', [
            'items' => Cart::items(),
            'total' => Cart::total(),
        ]);
    }

    /**
     * Tambah unit ke keranjang.
     */
    public function store(Produk $produk): RedirectResponse
    {
        if ($produk->status !== 'Tersedia') {
            return back()->with('error', 'Unit ini sudah tidak tersedia.');
        }

        Cart::add($produk->id_produk);

        return back()->with('status', "{$produk->merek} {$produk->model} ditambahkan ke keranjang.");
    }

    /**
     * Hapus unit dari keranjang.
     */
    public function destroy(Produk $produk): RedirectResponse
    {
        Cart::remove($produk->id_produk);

        return back()->with('status', 'Unit dihapus dari keranjang.');
    }
}
