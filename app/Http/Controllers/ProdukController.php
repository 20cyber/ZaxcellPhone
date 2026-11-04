<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    /**
     * Beranda & katalog (FP-01, FP-02).
     */
    public function index(Request $request)
    {
        $query = Produk::query()->where('status', 'Tersedia');

        if ($keyword = $request->string('q')->trim()->value()) {
            $query->where(function ($q) use ($keyword) {
                $q->where('merek', 'like', "%{$keyword}%")
                    ->orWhere('model', 'like', "%{$keyword}%");
            });
        }

        if ($merek = $request->string('merek')->trim()->value()) {
            $query->where('merek', $merek);
        }

        if ($hargaMin = $request->input('harga_min')) {
            $query->where('harga', '>=', $hargaMin);
        }

        if ($hargaMax = $request->input('harga_max')) {
            $query->where('harga', '<=', $hargaMax);
        }

        $produk = $query->orderByDesc('created_at')->paginate(12)->withQueryString();

        $daftarMerek = Produk::query()->distinct()->orderBy('merek')->pluck('merek');

        return view('katalog.index', [
            'produk' => $produk,
            'daftarMerek' => $daftarMerek,
        ]);
    }

    /**
     * Detail produk (FP-03).
     */
    public function show(Produk $produk)
    {
        return view('katalog.show', [
            'produk' => $produk,
        ]);
    }
}
