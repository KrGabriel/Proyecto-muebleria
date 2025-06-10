<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProveedorFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->company(),
            'direccion' => $this->faker->optional()->address(),
            'telefono' => $this->faker->optional()->phoneNumber(),
            'localidad' => $this->faker->optional()->city(),
            'provincia' => $this->faker->optional()->state(),
            'fecha_ultima_compra' => $this->faker->optional()->date(),
        ];
    }
}
