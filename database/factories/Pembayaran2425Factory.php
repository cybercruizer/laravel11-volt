<?php

namespace Database\Factories;

use App\Models\Pembayaran2425;
use Illuminate\Database\Eloquent\Factories\Factory;

class Pembayaran2425Factory extends Factory
{
    protected $model = Pembayaran2425::class;

    public function definition()
    {
        return [
            'nis' => $this->faker->numerify('#####'),
            'nama' => $this->faker->name,
            'jenis' => 'A',
            'jenjang' => $this->faker->randomElement(['SMK', 'SMA']),
            'paralel' => $this->faker->randomElement(['A', 'B', 'C']),
            'tahap' => $this->faker->numberBetween(1, 12),
            'jumlah' => $this->faker->numberBetween(100000, 1000000),
            'kategori' => 'SPP',
            // Add other necessary fields
        ];
    }
}
