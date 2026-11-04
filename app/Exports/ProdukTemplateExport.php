<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

/**
 * Template Excel kosong (berisi 1 baris contoh) untuk import produk massal.
 */
class ProdukTemplateExport implements FromArray, WithHeadings
{
    public function headings(): array
    {
        return ['merek', 'model', 'spesifikasi', 'warna', 'kondisi', 'kelengkapan', 'harga'];
    }

    public function array(): array
    {
        return [
            ['Samsung', 'Galaxy A54', '128GB/8GB RAM', 'Hitam', 'Mulus 95%, baret halus di pojok', 'Unit + charger', 3500000],
        ];
    }
}
