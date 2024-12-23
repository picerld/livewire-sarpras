<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\Employee;
use App\Models\Item;
use App\Models\Supplier;
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
        Employee::factory()->create([
            'id' => '111',
            'avatar' => 'avatars/01.png',
            // 'email' => 'rafi@localhost',
            'name' => 'Rafi',
        ]);

        Employee::factory()->create([
            'id' => '222',
            'avatar' => 'avatars/02.png',
            // 'email' => 'pice@localhost',
            'name' => 'Pice',
        ]);

        Employee::factory()->create([
            'id' => '333',
            'avatar' => 'avatars/03.png',
            // 'email' => 'picerld@localhost',
            'name' => 'Picerld',
        ]);

        Employee::factory()->create([
            'id' => '444',
            'avatar' => 'avatars/01.png',
            'name' => 'Anita Nuraeni'
        ]);

        User::factory()->create([
            'id' => '111',
            'username' => 'admin@localhost',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'nip' => '111',
            'id' => '111'
        ]);

        User::factory()->create([
            'id' => '222',
            'username' => 'pengawas@localhost',
            'password' => Hash::make('password'),
            'role' => 'pengawas',
            'nip' => '222',
            'id' => '222'
        ]);

        User::factory()->create([
            'id' => '333',
            'username' => 'unit@localhost',
            'password' => Hash::make('password'),
            'role' => 'unit',
            'nip' => '333',
            'id' => '333'
        ]);

        // seeder for unit

        User::factory()->create([
            'id' => '12312312321',
            'username' => 'rpl@localhost',
            'password' => Hash::make('password'),
            'nip' => '444',
            'role' => 'unit',
        ]);

        $employees = Employee::factory(10)->create();

        Category::factory()->create([
            'name' => 'Alat Tulis Kantor',
            'aliases' => 'ATK'
        ]);

        $this->call(CategorySeeder::class);
        $this->call(SupplierSeeder::class);
        $this->call(ItemSeeder::class);
        // $this->call(SubmissionSeeder::class);
        // $this->call(SubmissionDetailSeeder::class);
        // $this->call(RequestSeeder::class);
        // $this->call(RequestDetailSeeder::class);
        // $this->call(IncomingItemSeeder::class);
        // $this->call(IncomingItemDetailSeeder::class);
        // $this->call(OutgoingItemSeeder::class);
        // $this->call(OutgoingItemDetailSeeder::class);
    }
}
