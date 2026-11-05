<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

/**
 * Template Excel (berisi beberapa baris contoh) untuk import produk massal.
 */
class ProdukTemplateExport implements FromArray, ShouldAutoSize, WithEvents, WithHeadings
{
    public function headings(): array
    {
        return ['merek', 'model', 'spesifikasi', 'warna', 'kondisi', 'kelengkapan', 'harga'];
    }

    public function array(): array
    {
        return [
            ['Samsung', 'Galaxy A54', '128GB/8GB RAM', 'Hitam', 'Mulus 95%, baret halus di pojok layar', 'Unit + charger', 3500000],
            ['iPhone', '12', '64GB/4GB RAM', 'Putih', 'Mulus 90%, battery health 87%', 'Fullset (dus + charger)', 6000000],
            ['Xiaomi', 'Redmi Note 12', '128GB/6GB RAM', 'Biru', 'Normal, tidak ada minus', 'Unit saja', 2800000],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Header baris pertama ditebalkan + background abu-abu.
                $sheet->getStyle('A1:G1')->getFont()->setBold(true);
                $sheet->getStyle('A1:G1')->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setRGB('E2E8F0');

                // 3 baris contoh (baris 2-4) diberi warna kuning pucat + catatan,
                // supaya kelihatan jelas itu cuma contoh dan boleh dihapus/diganti.
                $sheet->getStyle('A2:G4')->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setRGB('FEF9C3');

                $sheet->setCellValue('I1', 'Catatan:');
                $sheet->setCellValue('I2', '- Baris kuning (2-4) cuma contoh, hapus/timpa dengan data asli.');
                $sheet->setCellValue('I3', '- Kolom "kondisi" diisi manual, catat minus/cacat unit di sini.');
                $sheet->setCellValue('I4', '- Kolom "harga" isi angka saja, tanpa titik/koma/Rp.');
                $sheet->setCellValue('I5', '- Baris kosong otomatis dilewati saat import.');
                $sheet->getStyle('I1')->getFont()->setBold(true);
                $sheet->getColumnDimension('I')->setWidth(60);
            },
        ];
    }
}
