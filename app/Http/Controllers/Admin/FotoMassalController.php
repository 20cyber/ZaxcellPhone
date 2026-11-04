<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Services\GeminiService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class FotoMassalController extends Controller
{
    /**
     * Form upload banyak foto sekaligus.
     */
    public function create(): View
    {
        return view('admin.produk.foto-massal', [
            'jumlahBelumAdaFoto' => Produk::whereNull('foto')->count(),
            'geminiSiap' => app(GeminiService::class)->sudahDikonfigurasi(),
        ]);
    }

    /**
     * Terima banyak foto, analisis tiap foto pakai Gemini, dan cari
     * produk yang paling cocok untuk ditinjau admin sebelum disimpan.
     */
    public function analisis(Request $request, GeminiService $gemini): View|RedirectResponse
    {
        $request->validate([
            'foto' => ['required', 'array', 'min:1'],
            'foto.*' => ['image', 'max:8192'],
        ]);

        $kandidatProduk = Produk::whereNull('foto')->orWhere('foto', '')->orderByDesc('created_at')->get();

        $baris = [];

        foreach ($request->file('foto') as $file) {
            $path = $file->store('produk-massal', 'public');

            $tebakan = $gemini->identifikasiHp(Storage::disk('public')->path($path), $file->getMimeType());

            $skor = $kandidatProduk
                ->map(fn ($produk) => [
                    'produk' => $produk,
                    'skor' => $this->skorKecocokan($produk, $tebakan),
                ])
                ->sortByDesc('skor')
                ->take(5)
                ->values();

            $baris[] = [
                'path' => $path,
                'url' => Storage::disk('public')->url($path),
                'tebakan' => $tebakan,
                'kandidat' => $skor,
            ];
        }

        return view('admin.produk.foto-massal-review', [
            'baris' => $baris,
        ]);
    }

    /**
     * Simpan hasil konfirmasi admin: tetapkan foto ke produk terpilih,
     * hapus file untuk baris yang dilewati.
     */
    public function simpan(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'baris' => ['required', 'array'],
            'baris.*.path' => ['required', 'string'],
            'baris.*.produk_id' => ['nullable', 'integer', 'exists:produk,id_produk'],
        ]);

        $jumlahTersimpan = 0;
        $jumlahDilewati = 0;

        foreach ($data['baris'] as $item) {
            if (empty($item['produk_id'])) {
                Storage::disk('public')->delete($item['path']);
                $jumlahDilewati++;

                continue;
            }

            $produk = Produk::find($item['produk_id']);

            if ($produk->foto) {
                Storage::disk('public')->delete($produk->foto);
            }

            $produk->update(['foto' => $item['path']]);
            $jumlahTersimpan++;
        }

        return redirect()
            ->route('admin.produk.index')
            ->with('status', "{$jumlahTersimpan} foto berhasil dipasang ke produk." . ($jumlahDilewati > 0 ? " {$jumlahDilewati} foto dilewati." : ''));
    }

    /**
     * Hitung skor kecocokan produk dengan hasil tebakan AI.
     *
     * @param  array{merek: ?string, model: ?string, warna: ?string}  $tebakan
     */
    protected function skorKecocokan(Produk $produk, array $tebakan): int
    {
        $skor = 0;

        if ($tebakan['merek'] && str_contains(
            strtolower($produk->merek),
            strtolower($tebakan['merek'])
        ) || $tebakan['merek'] && str_contains(strtolower($tebakan['merek']), strtolower($produk->merek))) {
            $skor += 50;
        }

        if ($tebakan['model']) {
            similar_text(strtolower($produk->model), strtolower($tebakan['model']), $persen);
            $skor += (int) round($persen * 0.3);
        }

        if ($tebakan['warna'] && $produk->warna && str_contains(strtolower($produk->warna), strtolower($tebakan['warna']))) {
            $skor += 20;
        }

        return $skor;
    }
}
