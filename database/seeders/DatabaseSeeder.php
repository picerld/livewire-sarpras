<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Employee;
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
        Employee::factory()->create([
            'avatar' => 'avatars/01.png',
            'name' => 'Admin'
        ]);

        Employee::factory()->create([
            'avatar' => 'avatars/01.png',
            'name' => 'pengawas'
        ]);

        Employee::factory()->create([
            'avatar' => 'avatars/01.png',
            'name' => 'Unit'
        ]);

        User::factory()->create([
            'email' => 'admin@localhost',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'employee_id' => 1
        ]);

        User::factory()->create([
            'email' => 'pengawas@localhost',
            'password' => Hash::make('password'),
            'role' => 'pengawas',
            'employee_id' => 2
        ]);

        User::factory()->create([
            'email' => 'unit@localhost',
            'password' => Hash::make('password'),
            'role' => 'unit',
            'employee_id' => 3
        ]);

        Employee::factory(10)->create();
        User::factory(10)->create();

        // $this->call(UnitSeeder::class);
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
