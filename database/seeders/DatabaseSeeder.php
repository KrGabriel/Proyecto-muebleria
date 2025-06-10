<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            BancosSeeder::class,
            CuentasSeeder::class,
            ProveedoresSeeder::class,
            FacturasSeeder::class,
            ChequesSeeder::class,
        ]);
    }
}
