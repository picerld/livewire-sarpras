<?php

namespace Database\Seeders;

use App\Models\Permintaan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermintaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permintaan::factory(10)->create();
    }
}
