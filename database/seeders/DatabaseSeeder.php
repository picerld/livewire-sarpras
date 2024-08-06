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
            'name' => 'Rafi',
            'nip' => '111'
        ]);

        Employee::factory()->create([
            'avatar' => 'avatars/02.png',
            'name' => 'Pice',
            'nip' => '222'
        ]);

        Employee::factory()->create([
            'avatar' => 'avatars/03.png',
            'name' => 'Picerld',
            'nip' => '333'
        ]);

        User::factory()->create([
            'username' => 'admin@localhost',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'nip' => '111'
        ]);

        User::factory()->create([
            'username' => 'pengawas@localhost',
            'password' => Hash::make('password'),
            'role' => 'pengawas',
            'nip' => '222'
        ]);

        User::factory()->create([
            'username' => 'unit@localhost',
            'password' => Hash::make('password'),
            'role' => 'unit',
            'nip' => '333'
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
