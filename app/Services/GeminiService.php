<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Pemanggil Gemini API (Google AI) untuk dua kebutuhan:
 * 1. Menebak merek/model/warna dari foto handphone (bantu cocokkan foto ke produk).
 * 2. Membaca foto pricelist (daftar harga) dan mengubahnya jadi data produk siap import.
 *
 * AI tidak dipakai untuk menilai kondisi/minus fisik unit — itu tetap input manual admin.
 */
class GeminiService
{
    protected const PROMPT_FOTO_HP = <<<'PROMPT'
        Kamu melihat foto sebuah handphone (smartphone) bekas yang akan dijual di toko online.
        Tebak merek, model, dan warna handphone pada foto ini.

        Balas HANYA dengan JSON tanpa teks lain, format persis seperti ini:
        {"merek": "...", "model": "...", "warna": "...", "keyakinan": "tinggi|sedang|rendah"}

        Jika foto tidak menunjukkan handphone sama sekali, balas:
        {"merek": null, "model": null, "warna": null, "keyakinan": "rendah"}
        PROMPT;

    protected const PROMPT_PRICELIST = <<<'PROMPT'
        Kamu melihat foto/screenshot tabel pricelist (daftar harga) handphone dari toko/supplier.
        Baca SETIAP baris tabel itu, lalu untuk tiap baris pisahkan jadi: merek, model, spesifikasi
        (kapasitas RAM/penyimpanan kalau ada, format "RAM/Penyimpanan", misal "8GB/256GB"), dan harga.

        Aturan:
        - Kolom kode/nomor urut/lokasi (misal "NO", "LOK SPK", kode gudang) DIABAIKAN, jangan dimasukkan ke hasil.
        - Harga ditulis sebagai angka murni tanpa titik/koma/spasi/"Rp" (misal tertulis "1.900.000" jadikan 1900000).
        - Kalau ada catatan umum di luar tabel yang berlaku untuk SEMUA unit (misal "semua unit tanpa cas dan dus",
          "unit batangan/HP only"), tulis ringkas di "catatan_umum" (satu kalimat singkat, boleh kosong kalau tidak ada).
        - Jangan lewati baris apa pun di tabel, termasuk baris yang modelnya sama tapi beda lokasi/kode.

        Balas HANYA dengan JSON tanpa teks lain, format persis seperti ini:
        {
          "catatan_umum": "...",
          "unit": [
            {"merek": "...", "model": "...", "spesifikasi": "...", "harga": 0}
          ]
        }

        Jika gambar tidak menunjukkan tabel pricelist handphone sama sekali, balas:
        {"catatan_umum": null, "unit": []}
        PROMPT;

    protected ?string $pesanErrorTerakhir = null;

    public function sudahDikonfigurasi(): bool
    {
        return filled(config('services.gemini.key'));
    }

    /**
     * Analisis satu foto handphone, kembalikan tebakan merek/model/warna.
     *
     * @return array{merek: ?string, model: ?string, warna: ?string, keyakinan: string, error: ?string}
     */
    public function identifikasiHp(string $pathFileLokal, string $mimeType): array
    {
        $gagal = ['merek' => null, 'model' => null, 'warna' => null, 'keyakinan' => 'rendah', 'error' => null];

        $hasil = $this->panggil(self::PROMPT_FOTO_HP, $pathFileLokal, $mimeType);

        if ($hasil === null) {
            $gagal['error'] = $this->pesanErrorTerakhir;

            return $gagal;
        }

        return [
            'merek' => $hasil['merek'] ?? null,
            'model' => $hasil['model'] ?? null,
            'warna' => $hasil['warna'] ?? null,
            'keyakinan' => $hasil['keyakinan'] ?? 'rendah',
            'error' => null,
        ];
    }

    /**
     * Baca foto pricelist, kembalikan daftar unit (merek/model/spesifikasi/harga)
     * siap dijadikan draft produk, plus catatan umum (mis. "tanpa cas & dus").
     *
     * @return array{catatan_umum: ?string, unit: array<int, array{merek: ?string, model: ?string, spesifikasi: ?string, harga: ?int}>, error: ?string}
     */
    public function ekstrakPricelist(string $pathFileLokal, string $mimeType): array
    {
        $gagal = ['catatan_umum' => null, 'unit' => [], 'error' => null];

        $hasil = $this->panggil(self::PROMPT_PRICELIST, $pathFileLokal, $mimeType);

        if ($hasil === null) {
            $gagal['error'] = $this->pesanErrorTerakhir;

            return $gagal;
        }

        $unit = collect($hasil['unit'] ?? [])
            ->map(fn ($u) => [
                'merek' => $u['merek'] ?? null,
                'model' => $u['model'] ?? null,
                'spesifikasi' => $u['spesifikasi'] ?? null,
                'harga' => is_numeric($u['harga'] ?? null) ? (int) $u['harga'] : null,
            ])
            ->values()
            ->all();

        return [
            'catatan_umum' => $hasil['catatan_umum'] ?? null,
            'unit' => $unit,
            'error' => null,
        ];
    }

    /**
     * Kirim prompt + gambar ke Gemini, kembalikan hasil JSON yang sudah di-decode,
     * atau null kalau gagal (pesan error tersimpan di $pesanErrorTerakhir).
     */
    protected function panggil(string $prompt, string $pathFileLokal, string $mimeType): ?array
    {
        if (! $this->sudahDikonfigurasi()) {
            $this->pesanErrorTerakhir = 'GEMINI_API_KEY belum diatur di .env';

            return null;
        }

        try {
            $gambarBase64 = base64_encode(file_get_contents($pathFileLokal));
            $model = config('services.gemini.model');

            $response = Http::timeout(60)->post(
                "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key=" . config('services.gemini.key'),
                [
                    'contents' => [[
                        'parts' => [
                            ['text' => $prompt],
                            ['inline_data' => ['mime_type' => $mimeType, 'data' => $gambarBase64]],
                        ],
                    ]],
                    'generationConfig' => [
                        'temperature' => 0.1,
                        'responseMimeType' => 'application/json',
                    ],
                ]
            );

            if ($response->failed()) {
                Log::warning('Gemini API gagal', ['status' => $response->status(), 'body' => $response->body()]);
                $this->pesanErrorTerakhir = 'Gagal menghubungi Gemini API (' . $response->status() . ')';

                return null;
            }

            $teks = data_get($response->json(), 'candidates.0.content.parts.0.text');
            $hasil = json_decode((string) $teks, true);

            if (! is_array($hasil)) {
                $this->pesanErrorTerakhir = 'Respons Gemini tidak bisa dibaca';

                return null;
            }

            return $hasil;
        } catch (\Throwable $e) {
            Log::warning('Gemini API exception', ['pesan' => $e->getMessage()]);
            $this->pesanErrorTerakhir = 'Terjadi kesalahan saat memanggil Gemini API';

            return null;
        }
    }
}
