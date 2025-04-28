<?php

namespace App\Exports;

use App\Models\Role;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class RolesExport implements FromCollection, WithHeadings, WithMapping
{
    protected $fields;

    public function __construct(array $fields)
    {
        $this->fields = $fields;
    }

    public function collection()
    {
        return Role::all();
    }

    public function headings(): array
    {
        return array_intersect(['id', 'name', 'guard_name', 'created_at'], $this->fields);
    }

    public function map($role): array
    {
        $data = [];
        if (in_array('id', $this->fields)) $data[] = $role->id;
        if (in_array('name', $this->fields)) $data[] = $role->name;
        if (in_array('guard_name', $this->fields)) $data[] = $role->guard_name;
        if (in_array('created_at', $this->fields)) $data[] = $role->created_at ? $role->created_at->format('Y-m-d') : '';
        return $data;
    }
}
