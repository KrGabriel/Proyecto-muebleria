<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProveedorFactory extends Factory
{
    public function definition(): array
    {
        return [
            'numero_proveedor' => $this->faker->unique()->numberBetween(1000, 9999), // ← agregado
            'nombre' => $this->faker->company(),
            'direccion' => $this->faker->optional()->address(),
            'telefono' => $this->faker->optional()->phoneNumber(),
            'localidad' => $this->faker->optional()->city(),
            'provincia' => $this->faker->optional()->state(),
            'fecha_ultima_compra' => $this->faker->optional()->date(),
        ];
    }
}
