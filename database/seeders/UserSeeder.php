<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan roles sudah ada dulu
        $adminRoleId = \App\Models\Role::where('name', 'Administrator')->first()->id;
        $managementRoleId = \App\Models\Role::where('name', 'Management')->first()->id;
        $userRoleId = \App\Models\Role::where('name', 'User')->first()->id;

        // Admin User
        User::create([
            'uuid' => Str::uuid(),
            'name' => 'Admin Super',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'), // password
            'role_id' => $adminRoleId,
        ]);

        // Management User
        User::create([
            'uuid' => Str::uuid(),
            'name' => 'Manajer Utama',
            'email' => 'management@gmail.com',
            'password' => Hash::make('password'), // password
            'role_id' => $managementRoleId,
        ]);

        // User Biasa
        User::create([
            'uuid' => Str::uuid(),
            'name' => 'User Biasa',
            'email' => 'user@gmail.com',
            'password' => Hash::make('password'), // password
            'role_id' => $userRoleId,
        ]);
    }
}
