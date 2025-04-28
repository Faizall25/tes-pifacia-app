<?php

namespace App\Imports;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $role = Role::where('name', $row['role_name'])->first();
        return new User([
            'uuid' => Str::uuid(),
            'name' => $row['name'],
            'email' => $row['email'],
            'password' => Hash::make('password'), // Default password
            'role_id' => $role ? $role->id : null,
        ]);
    }
}
