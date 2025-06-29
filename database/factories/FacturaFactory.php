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
            'total' => 0,
        ];
    }
}
