<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Pemanggil Gemini API (Google AI) untuk menganalisis foto handphone:
 * menebak merek, model, dan warna dari gambar. Dipakai untuk membantu
 * mencocokkan foto ke data produk hasil import Excel, bukan untuk
 * menilai kondisi/minus fisik unit (itu tetap input manual admin).
 */
class GeminiService
{
    protected const PROMPT = <<<'PROMPT'
        Kamu melihat foto sebuah handphone (smartphone) bekas yang akan dijual di toko online.
        Tebak merek, model, dan warna handphone pada foto ini.

        Balas HANYA dengan JSON tanpa teks lain, format persis seperti ini:
        {"merek": "...", "model": "...", "warna": "...", "keyakinan": "tinggi|sedang|rendah"}

        Jika foto tidak menunjukkan handphone sama sekali, balas:
        {"merek": null, "model": null, "warna": null, "keyakinan": "rendah"}
        PROMPT;

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

        if (! $this->sudahDikonfigurasi()) {
            $gagal['error'] = 'GEMINI_API_KEY belum diatur di .env';

            return $gagal;
        }

        try {
            $gambarBase64 = base64_encode(file_get_contents($pathFileLokal));
            $model = config('services.gemini.model');

            $response = Http::timeout(30)->post(
                "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key=" . config('services.gemini.key'),
                [
                    'contents' => [[
                        'parts' => [
                            ['text' => self::PROMPT],
                            ['inline_data' => ['mime_type' => $mimeType, 'data' => $gambarBase64]],
                        ],
                    ]],
                    'generationConfig' => [
                        'temperature' => 0.2,
                        'responseMimeType' => 'application/json',
                    ],
                ]
            );

            if ($response->failed()) {
                Log::warning('Gemini API gagal', ['status' => $response->status(), 'body' => $response->body()]);
                $gagal['error'] = 'Gagal menghubungi Gemini API (' . $response->status() . ')';

                return $gagal;
            }

            $teks = data_get($response->json(), 'candidates.0.content.parts.0.text');
            $hasil = json_decode((string) $teks, true);

            if (! is_array($hasil)) {
                $gagal['error'] = 'Respons Gemini tidak bisa dibaca';

                return $gagal;
            }

            return [
                'merek' => $hasil['merek'] ?? null,
                'model' => $hasil['model'] ?? null,
                'warna' => $hasil['warna'] ?? null,
                'keyakinan' => $hasil['keyakinan'] ?? 'rendah',
                'error' => null,
            ];
        } catch (\Throwable $e) {
            Log::warning('Gemini API exception', ['pesan' => $e->getMessage()]);
            $gagal['error'] = 'Terjadi kesalahan saat memanggil Gemini API';

            return $gagal;
        }
    }
}
