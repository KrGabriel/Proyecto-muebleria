<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cheque;

class ChequesSeeder extends Seeder
{
    public function run(): void
    {
        Cheque::factory()->count(30)->create();
    }
}
