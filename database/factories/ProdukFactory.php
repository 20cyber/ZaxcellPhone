<?php

namespace Database\Factories;

use App\Models\Produk;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Produk>
 */
class ProdukFactory extends Factory
{
    /**
     * Daftar merek dan model handphone second yang umum dijual.
     *
     * @var array<string, array<int, string>>
     */
    protected array $katalog = [
        'iPhone' => ['iPhone 11', 'iPhone 12', 'iPhone 12 Pro', 'iPhone 13', 'iPhone 13 Pro', 'iPhone XR'],
        'Samsung' => ['Galaxy A54', 'Galaxy A34', 'Galaxy S21', 'Galaxy S22', 'Galaxy Note 20'],
        'Xiaomi' => ['Redmi Note 11', 'Redmi Note 12', 'Poco X5', 'Mi 11 Lite'],
        'Oppo' => ['Reno 7', 'Reno 8', 'A77', 'A96'],
        'Vivo' => ['V25', 'V27', 'Y36', 'Y100'],
        'Realme' => ['Realme 9', 'Realme 10', 'Realme C55'],
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $merek = $this->faker->randomElement(array_keys($this->katalog));
        $model = $this->faker->randomElement($this->katalog[$merek]);

        return [
            'merek' => $merek,
            'model' => $model,
            'spesifikasi' => $this->faker->randomElement(['128GB/4GB RAM', '128GB/6GB RAM', '256GB/8GB RAM', '64GB/4GB RAM']),
            'warna' => $this->faker->randomElement(['Hitam', 'Putih', 'Biru', 'Hijau', 'Gold', 'Silver']),
            'kondisi' => $this->faker->randomElement(['Mulus 99%', 'Mulus 95%', 'Normal', 'Ada baret halus']),
            'kelengkapan' => $this->faker->randomElement(['Fullset (dus + charger)', 'Unit + charger', 'Unit saja']),
            'harga' => $this->faker->numberBetween(15, 120) * 100000,
            'stok' => 1,
            'status' => 'Tersedia',
            'foto' => null,
        ];
    }
}
