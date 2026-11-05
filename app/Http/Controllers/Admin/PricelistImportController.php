<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Services\GeminiService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PricelistImportController extends Controller
{
    /**
     * Form upload foto pricelist.
     */
    public function create(): View
    {
        return view('admin.produk.pricelist-import', [
            'geminiSiap' => app(GeminiService::class)->sudahDikonfigurasi(),
        ]);
    }

    /**
     * Baca foto pricelist pakai Gemini, tampilkan hasil ekstraksi untuk ditinjau admin.
     */
    public function analisis(Request $request, GeminiService $gemini): View|RedirectResponse
    {
        $request->validate([
            'foto' => ['required', 'array', 'min:1'],
            'foto.*' => ['image', 'max:8192'],
            'kondisi_default' => ['required', 'string', 'max:255'],
            'kelengkapan_default' => ['nullable', 'string', 'max:255'],
        ]);

        $baris = [];
        $catatanUmum = [];
        $pesanError = null;

        foreach ($request->file('foto') as $file) {
            $hasil = $gemini->ekstrakPricelist($file->getRealPath(), $file->getMimeType());

            if ($hasil['error']) {
                $pesanError = $hasil['error'];

                continue;
            }

            if ($hasil['catatan_umum']) {
                $catatanUmum[] = $hasil['catatan_umum'];
            }

            foreach ($hasil['unit'] as $unit) {
                $baris[] = [
                    'merek' => $unit['merek'],
                    'model' => $unit['model'],
                    'spesifikasi' => $unit['spesifikasi'],
                    'warna' => null,
                    'kondisi' => $request->input('kondisi_default'),
                    'kelengkapan' => $request->input('kelengkapan_default') ?: ($catatanUmum[0] ?? null),
                    'harga' => $unit['harga'],
                ];
            }
        }

        if (empty($baris)) {
            return redirect()
                ->route('admin.pricelist-import.create')
                ->with('error', $pesanError ?: 'Tidak ada data unit yang terbaca dari foto. Coba foto yang lebih jelas.');
        }

        return view('admin.produk.pricelist-review', [
            'baris' => $baris,
            'catatanUmum' => array_unique($catatanUmum),
            'pesanError' => $pesanError,
        ]);
    }

    /**
     * Simpan baris yang sudah ditinjau/diedit admin jadi produk baru.
     */
    public function simpan(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'baris' => ['required', 'array'],
            'baris.*.sertakan' => ['nullable', 'string'],
            'baris.*.merek' => ['nullable', 'string', 'max:255'],
            'baris.*.model' => ['nullable', 'string', 'max:255'],
            'baris.*.spesifikasi' => ['nullable', 'string', 'max:255'],
            'baris.*.warna' => ['nullable', 'string', 'max:255'],
            'baris.*.kondisi' => ['nullable', 'string', 'max:255'],
            'baris.*.kelengkapan' => ['nullable', 'string', 'max:255'],
            'baris.*.harga' => ['nullable', 'numeric', 'min:0'],
        ]);

        $jumlahTersimpan = 0;

        foreach ($data['baris'] as $item) {
            if (empty($item['sertakan']) || blank($item['merek'] ?? null) || blank($item['harga'] ?? null)) {
                continue;
            }

            Produk::create([
                'merek' => $item['merek'],
                'model' => $item['model'] ?? '-',
                'spesifikasi' => $item['spesifikasi'] ?? null,
                'warna' => $item['warna'] ?? null,
                'kondisi' => $item['kondisi'] ?: 'Belum dicek',
                'kelengkapan' => $item['kelengkapan'] ?? null,
                'harga' => $item['harga'],
                'stok' => 1,
                'status' => 'Tersedia',
            ]);

            $jumlahTersimpan++;
        }

        return redirect()
            ->route('admin.produk.index')
            ->with('status', "{$jumlahTersimpan} produk berhasil ditambahkan dari pricelist.");
    }
}
