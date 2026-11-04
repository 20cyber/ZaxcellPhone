<?php

namespace Database\Seeders;

use App\Models\Produk;
use Illuminate\Database\Seeder;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Produk::factory()->count(20)->create();

        // Beberapa unit contoh berstatus Ditahan / Terjual, biar admin bisa lihat variasinya.
        Produk::factory()->count(2)->create(['status' => 'Ditahan']);
        Produk::factory()->count(2)->create(['status' => 'Terjual']);
    }
}
