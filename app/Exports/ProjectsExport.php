<?php

namespace App\Exports;

use App\Models\Project;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProjectsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $fields;

    public function __construct(array $fields)
    {
        $this->fields = $fields;
    }

    public function collection()
    {
        return Project::with('user')->get();
    }

    public function headings(): array
    {
        return array_intersect(['id', 'uuid', 'title', 'description', 'is_active', 'user_name', 'created_at'], $this->fields);
    }

    public function map($project): array
    {
        $data = [];
        if (in_array('id', $this->fields)) $data[] = $project->id;
        if (in_array('uuid', $this->fields)) $data[] = $project->uuid;
        if (in_array('title', $this->fields)) $data[] = $project->title;
        if (in_array('description', $this->fields)) $data[] = $project->description;
        if (in_array('is_active', $this->fields)) $data[] = $project->is_active ? 'Yes' : 'No';
        if (in_array('user_name', $this->fields)) $data[] = $project->user ? $project->user->name : '';
        if (in_array('created_at', $this->fields)) $data[] = $project->created_at ? $project->created_at->format('Y-m-d') : '';
        return $data;
    }
}
