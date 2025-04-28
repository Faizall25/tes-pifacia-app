<?php

namespace App\Imports;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TasksImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $project = Project::where('title', $row['project_title'])->first();
        $user = User::where('name', $row['user_name'])->first();
        return new Task([
            'uuid' => Str::uuid(),
            'title' => $row['title'],
            'description' => $row['description'],
            'is_completed' => $row['is_completed'] === 'Yes' ? 1 : 0,
            'project_id' => $project ? $project->id : null,
            'user_id' => $user ? $user->id : null,
        ]);
    }
}
