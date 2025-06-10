<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Factura;

class FacturasSeeder extends Seeder
{
    public function run(): void
    {
        Factura::factory()
            ->count(20)
            ->create()
            ->each(function ($factura) {
                $factura->total = $factura->neto + $factura->neto * ($factura->tasa + ($factura->sobretasa ?? 0)) / 100;
                $factura->save();
            });
    }
}
