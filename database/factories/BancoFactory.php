<?php

namespace Database\Factories;

use App\Models\Banco;
use Illuminate\Database\Eloquent\Factories\Factory;

class BancoFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->company . ' Bank',
            'comentario' => $this->faker->optional()->sentence(),
        ];
    }
}
