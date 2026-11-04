<?php

namespace App\Support;

use App\Models\Produk;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;

/**
 * Keranjang disimpan di session pembeli (bukan database), sesuai asumsi
 * di dokumen analisis sistem. Setiap unit handphone second bersifat unik,
 * jadi keranjang hanya menyimpan daftar id_produk (tanpa kuantitas).
 */
class Cart
{
    protected const SESSION_KEY = 'keranjang';

    /**
     * Ambil daftar id_produk di keranjang.
     *
     * @return array<int>
     */
    public static function ids(): array
    {
        return Session::get(self::SESSION_KEY, []);
    }

    public static function add(int $idProduk): void
    {
        $ids = self::ids();

        if (! in_array($idProduk, $ids, true)) {
            $ids[] = $idProduk;
        }

        Session::put(self::SESSION_KEY, $ids);
    }

    public static function remove(int $idProduk): void
    {
        Session::put(self::SESSION_KEY, array_values(array_diff(self::ids(), [$idProduk])));
    }

    public static function clear(): void
    {
        Session::forget(self::SESSION_KEY);
    }

    public static function count(): int
    {
        return count(self::ids());
    }

    /**
     * Ambil produk di keranjang yang masih berstatus Tersedia.
     */
    public static function items(): Collection
    {
        return Produk::whereIn('id_produk', self::ids())->get();
    }

    public static function total(): float
    {
        return (float) self::items()->sum('harga');
    }
}
