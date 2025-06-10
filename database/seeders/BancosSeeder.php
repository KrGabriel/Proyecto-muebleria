<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Banco;

class BancosSeeder extends Seeder
{
    public function run(): void
    {
        Banco::factory()->count(5)->create();
    }
}
