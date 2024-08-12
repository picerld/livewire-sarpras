<?php

namespace Database\Seeders;

use App\Livewire\Layouts\Account\User;
use App\Models\Employee;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Employee::factory(10)->create();
    }
}
