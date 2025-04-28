<?php

namespace App\Imports;


use App\Models\Role;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class RolesImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Role([
            'name' => $row['name'],
            'guard_name' => $row['guard_name'],
        ]);
    }
}
