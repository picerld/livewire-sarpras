<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\IncomingItemDetail;
use App\Models\SubmissionDetail;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User Seeder
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@localhost',
            'role' => 'admin',
            'password' => Hash::make('password')
        ]);
        
        User::factory()->create([
            'name' => 'Unit',
            'email' => 'unit@localhost',
            'role' => 'unit',
            'password' => Hash::make('password')
        ]);

        User::factory()->create([
            'name' => 'Pengawas',
            'email' => 'pengawas@localhost',
            'role' => 'pengawas',
            'password' => Hash::make('password')
        ]);

        User::factory(10)->create();

        $this->call(UnitSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(ItemSeeder::class);
        $this->call(SupplierSeeder::class);
        $this->call(SubmissionSeeder::class);
        $this->call(SubmissionDetailSeeder::class);
        $this->call(RequestSeeder::class);
        $this->call(RequestDetailSeeder::class);
        $this->call(IncomingItemSeeder::class);
        $this->call(IncomingItemDetailSeeder::class);
        $this->call(OutgoingItemSeeder::class);
        $this->call(OutgoingItemDetailSeeder::class);
    }
}
