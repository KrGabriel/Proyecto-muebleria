<?php

namespace Database\Factories;

use App\Models\Proveedor;
use Illuminate\Database\Eloquent\Factories\Factory;

class FacturaFactory extends Factory
{
    public function definition(): array
    {
        return [
            'codigo_proveedor' => Proveedor::inRandomOrder()->first()->codigo ?? Proveedor::factory(),
            'fecha' => $this->faker->date(),
            'numero' => $this->faker->bothify('FAC-####'),
            'neto' => $this->faker->randomFloat(2, 1000, 10000),
            'tasa' => $this->faker->randomFloat(2, 5, 25),
            'sobretasa' => $this->faker->optional()->randomFloat(2, 1, 5),
            'total' => 0, // lo calcularemos en el seeder
        ];
    }
}
