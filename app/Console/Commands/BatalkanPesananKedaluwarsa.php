<?php

namespace App\Console\Commands;

use App\Models\Pesanan;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

#[Signature('app:batalkan-pesanan-kedaluwarsa')]
#[Description('Batalkan pesanan yang belum dibayar setelah lewat batas waktu, lalu lepas unit yang ditahan (FS-04)')]
class BatalkanPesananKedaluwarsa extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $pesananKedaluwarsa = Pesanan::query()
            ->where('status_pesanan', 'Menunggu Pembayaran')
            ->where('batas_bayar', '<', now())
            ->with('detailPesanan.produk')
            ->get();

        foreach ($pesananKedaluwarsa as $pesanan) {
            DB::transaction(function () use ($pesanan) {
                $pesanan->update(['status_pesanan' => 'Dibatalkan']);

                foreach ($pesanan->detailPesanan as $detail) {
                    if ($detail->produk?->status === 'Ditahan') {
                        $detail->produk->update(['status' => 'Tersedia']);
                    }
                }
            });
        }

        $this->info("{$pesananKedaluwarsa->count()} pesanan kedaluwarsa dibatalkan.");

        return self::SUCCESS;
    }
}
