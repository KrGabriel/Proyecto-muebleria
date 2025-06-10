<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CuentaBancaria;

class CuentasSeeder extends Seeder
{
    public function run(): void
    {
        CuentaBancaria::factory()->count(10)->create();
    }
}
