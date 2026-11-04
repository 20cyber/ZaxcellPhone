<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProdukController extends Controller
{
    /**
     * Daftar produk untuk admin.
     */
    public function index(Request $request): View
    {
        $produk = Produk::query()
            ->when($request->string('q')->trim()->value(), function ($query, $keyword) {
                $query->where(function ($q) use ($keyword) {
                    $q->where('merek', 'like', "%{$keyword}%")
                        ->orWhere('model', 'like', "%{$keyword}%");
                });
            })
            ->orderByDesc('created_at')
            ->paginate(15)
            ->withQueryString();

        return view('admin.produk.index', ['produk' => $produk]);
    }

    /**
     * Form tambah produk (FA-03).
     */
    public function create(): View
    {
        return view('admin.produk.create');
    }

    /**
     * Simpan produk baru.
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateData($request);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('produk', 'public');
        }

        Produk::create($data);

        return redirect()->route('admin.produk.index')->with('status', 'Produk berhasil ditambahkan.');
    }

    /**
     * Form ubah produk (FA-03, FA-04 — harga termasuk di sini).
     */
    public function edit(Produk $produk): View
    {
        return view('admin.produk.edit', ['produk' => $produk]);
    }

    /**
     * Simpan perubahan produk.
     */
    public function update(Request $request, Produk $produk): RedirectResponse
    {
        $data = $this->validateData($request);

        if ($request->hasFile('foto')) {
            if ($produk->foto) {
                Storage::disk('public')->delete($produk->foto);
            }
            $data['foto'] = $request->file('foto')->store('produk', 'public');
        }

        $produk->update($data);

        return redirect()->route('admin.produk.index')->with('status', 'Produk berhasil diperbarui.');
    }

    /**
     * Hapus produk.
     */
    public function destroy(Produk $produk): RedirectResponse
    {
        try {
            if ($produk->foto) {
                Storage::disk('public')->delete($produk->foto);
            }
            $produk->delete();
        } catch (QueryException) {
            return back()->with('error', 'Produk tidak bisa dihapus karena sudah pernah masuk pesanan.');
        }

        return redirect()->route('admin.produk.index')->with('status', 'Produk berhasil dihapus.');
    }

    /**
     * Perbarui stok — menu terpisah dari edit unit (FA-05).
     */
    public function updateStok(Request $request, Produk $produk): RedirectResponse
    {
        $validated = $request->validate([
            'stok' => ['required', 'integer', 'min:0'],
        ]);

        $produk->update($validated);

        return back()->with('status', "Stok {$produk->merek} {$produk->model} diperbarui ke {$validated['stok']}.");
    }

    /**
     * Validasi data form tambah/ubah produk.
     *
     * @return array<string, mixed>
     */
    protected function validateData(Request $request): array
    {
        return $request->validate([
            'merek' => ['required', 'string', 'max:255'],
            'model' => ['required', 'string', 'max:255'],
            'spesifikasi' => ['nullable', 'string'],
            'warna' => ['nullable', 'string', 'max:255'],
            'kondisi' => ['required', 'string', 'max:255'],
            'kelengkapan' => ['nullable', 'string', 'max:255'],
            'harga' => ['required', 'numeric', 'min:0'],
            'status' => ['required', 'in:Tersedia,Ditahan,Terjual'],
            'foto' => ['nullable', 'image', 'max:2048'],
        ]);
    }
}
