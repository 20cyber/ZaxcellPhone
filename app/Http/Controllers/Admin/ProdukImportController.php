<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ProdukTemplateExport;
use App\Http\Controllers\Controller;
use App\Imports\ProdukImport;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;

class ProdukImportController extends Controller
{
    /**
     * Form upload Excel untuk import produk massal.
     */
    public function create(): View
    {
        return view('admin.produk.import');
    }

    /**
     * Download template Excel kosong.
     */
    public function template()
    {
        return Excel::download(new ProdukTemplateExport, 'template-produk-zaxcellphone.xlsx');
    }

    /**
     * Proses import file Excel yang diupload.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:xlsx,xls,csv'],
        ]);

        $import = new ProdukImport;
        Excel::import($import, $request->file('file'));

        $jumlahGagal = $import->failures()->count() + $import->errors()->count();

        $pesanBaris = $import->failures()->map(function ($failure) {
            return "Baris {$failure->row()}: " . implode(', ', $failure->errors());
        })->values();

        return redirect()
            ->route('admin.produk.index')
            ->with('status', "{$import->jumlahBerhasil} produk berhasil diimport." . ($jumlahGagal > 0 ? " {$jumlahGagal} baris gagal." : ''))
            ->with('importErrors', $pesanBaris);
    }
}
