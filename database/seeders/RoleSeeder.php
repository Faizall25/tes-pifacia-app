<?php

namespace Database\Seeders;

use App\Models\Role; // <<< INI HARUS ADA
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::insert([
            ['name' => 'Administrator', 'guard_name' => 'web'],
            ['name' => 'Management', 'guard_name' => 'web'],
            ['name' => 'User', 'guard_name' => 'web'],
        ]);
    }
}
