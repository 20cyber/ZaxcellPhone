<?php

namespace Database\Factories;

use App\Models\Pembeli;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Pembeli>
 */
class PembeliFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama' => $this->faker->name(),
            'nomor_hp' => '08' . $this->faker->numerify('##########'),
            'alamat' => $this->faker->address(),
        ];
    }
}
