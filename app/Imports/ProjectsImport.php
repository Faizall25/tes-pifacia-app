<?php

namespace App\Imports;

use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProjectsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $user = User::where('name', $row['user_name'])->first();
        return new Project([
            'uuid' => Str::uuid(),
            'title' => $row['title'],
            'description' => $row['description'],
            'is_active' => $row['is_active'] === 'Yes' ? 1 : 0,
            'user_id' => $user ? $user->id : null,
        ]);
    }
}
