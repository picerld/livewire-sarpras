<?php

namespace Database\Seeders;

use App\Models\DetailBarangMasuk;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DetailBarangMasukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DetailBarangMasuk::factory(10)->create();
    }
}
