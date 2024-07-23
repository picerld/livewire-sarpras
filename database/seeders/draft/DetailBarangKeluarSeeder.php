<?php

namespace Database\Seeders;

use App\Models\DetailBarangKeluar;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DetailBarangKeluarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DetailBarangKeluar::factory(10)->create();
    }
}
