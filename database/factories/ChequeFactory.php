<?php

namespace Database\Factories;

use App\Models\CuentaBancaria;
use App\Models\Factura;
use Illuminate\Database\Eloquent\Factories\Factory;

class ChequeFactory extends Factory
{
    public function definition(): array
    {
        $debe = $this->faker->randomFloat(2, 100, 5000);
        $haber = $this->faker->randomFloat(2, 100, 5000);

        return [
            'entro' => $this->faker->boolean(),
            'codigo_cuenta' => CuentaBancaria::inRandomOrder()->first()->codigo ?? CuentaBancaria::factory(),
            'numero_cheque' => $this->faker->bothify('CHQ-#####'),
            'fecha' => $this->faker->date(),
            'debe' => $debe,
            'haber' => $haber,
            'codigo_factura' => Factura::inRandomOrder()->first()->id ?? Factura::factory(),
        ];
    }
}
