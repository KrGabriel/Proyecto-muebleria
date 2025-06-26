<?php

namespace Database\Factories;

use App\Models\CuentaBancaria;
use App\Models\Banco;
use Illuminate\Database\Eloquent\Factories\Factory;

class CuentaBancariaFactory extends Factory
{
    protected $model = CuentaBancaria::class;

    public function definition(): array
    {
        return [
            'numero_banco' => Banco::inRandomOrder()->first()->numero ?? Banco::factory(),
            'numero_cuenta' => $this->faker->unique()->randomNumber(8, true),
        ];
    }
}
