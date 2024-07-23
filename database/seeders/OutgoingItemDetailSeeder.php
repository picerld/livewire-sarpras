<?php

namespace Database\Seeders;

use App\Models\OutgoingItemDetail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OutgoingItemDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        OutgoingItemDetail::factory(10)->create();
    }
}
