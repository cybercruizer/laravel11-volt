<?php

namespace Database\Factories;

use App\Models\Siswa;
use Illuminate\Database\Eloquent\Factories\Factory;

class SiswaFactory extends Factory
{
    protected $model = Siswa::class;

    public function definition()
    {
        return [
            'nis' => $this->faker->unique()->numerify('#####'),
            'nama' => $this->faker->name,
            // Add other necessary fields for the Siswa model
        ];
    }
}
