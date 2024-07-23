<?php

namespace Database\Seeders;

use App\Models\DetailPermintaan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DetailPermintaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DetailPermintaan::factory(10)->create();
    }
}
