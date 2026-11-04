<?php

namespace Database\Seeders;

use App\Models\Pembeli;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin Zaxcellphone',
            'email' => 'admin@zaxcellphone.test',
            'password' => 'password',
        ]);

        Pembeli::factory()->count(5)->create();

        $this->call(ProdukSeeder::class);
    }
}
