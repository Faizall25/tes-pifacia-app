<?php

namespace App\Exports;

use App\Models\Task;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TasksExport implements FromCollection, WithHeadings, WithMapping
{
    protected $fields;

    public function __construct(array $fields)
    {
        $this->fields = $fields;
    }

    public function collection()
    {
        return Task::with('project', 'user')->get();
    }

    public function headings(): array
    {
        return array_intersect(['id', 'uuid', 'title', 'description', 'is_completed', 'project_title', 'user_name', 'created_at'], $this->fields);
    }

    public function map($task): array
    {
        $data = [];
        if (in_array('id', $this->fields)) $data[] = $task->id;
        if (in_array('uuid', $this->fields)) $data[] = $task->uuid;
        if (in_array('title', $this->fields)) $data[] = $task->title;
        if (in_array('description', $this->fields)) $data[] = $task->description;
        if (in_array('is_completed', $this->fields)) $data[] = $task->is_completed ? 'Yes' : 'No';
        if (in_array('project_title', $this->fields)) $data[] = $task->project ? $task->project->title : '';
        if (in_array('user_name', $this->fields)) $data[] = $task->user ? $task->user->name : '';
        if (in_array('created_at', $this->fields)) $data[] = $task->created_at ? $task->created_at->format('Y-m-d') : '';
        return $data;
    }
}
