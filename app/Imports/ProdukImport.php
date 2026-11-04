<?php

namespace App\Imports;

use App\Models\Produk;
use Illuminate\Support\Collection as BaseCollection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

/**
 * Import produk massal dari file Excel (.xlsx).
 *
 * Kolom yang dibaca (baris pertama = judul kolom):
 * merek, model, spesifikasi, warna, kondisi, kelengkapan, harga
 */
class ProdukImport implements SkipsOnError, SkipsOnFailure, ToCollection, WithHeadingRow, WithValidation
{
    use Importable, SkipsErrors, SkipsFailures;

    public int $jumlahBerhasil = 0;

    public function collection(BaseCollection $rows): void
    {
        foreach ($rows as $row) {
            if (blank($row['merek'] ?? null)) {
                continue;
            }

            Produk::create([
                'merek' => $row['merek'],
                'model' => $row['model'],
                'spesifikasi' => $row['spesifikasi'] ?? null,
                'warna' => $row['warna'] ?? null,
                'kondisi' => $row['kondisi'],
                'kelengkapan' => $row['kelengkapan'] ?? null,
                'harga' => $row['harga'],
                'stok' => 1,
                'status' => 'Tersedia',
            ]);

            $this->jumlahBerhasil++;
        }
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'merek' => ['required', 'string', 'max:255'],
            'model' => ['required', 'string', 'max:255'],
            'kondisi' => ['required', 'string', 'max:255'],
            'harga' => ['required', 'numeric', 'min:0'],
        ];
    }

    public function customValidationAttributes(): array
    {
        return [
            'merek' => 'Merek',
            'model' => 'Model',
            'kondisi' => 'Kondisi',
            'harga' => 'Harga',
        ];
    }
}
