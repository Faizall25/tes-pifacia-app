<?php

namespace App\Imports;

use App\Models\Comment;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CommentsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $task = Task::where('title', $row['task_title'])->first();
        $user = User::where('name', $row['user_name'])->first();
        return new Comment([
            'uuid' => Str::uuid(),
            'content' => $row['content'],
            'task_id' => $task ? $task->id : null,
            'user_id' => $user ? $user->id : null,
        ]);
    }
}
