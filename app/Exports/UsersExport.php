<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UsersExport implements FromCollection, WithHeadings, WithMapping
{
    protected $fields;

    public function __construct(array $fields)
    {
        $this->fields = $fields;
    }

    public function collection()
    {
        return User::with('role')->get();
    }

    public function headings(): array
    {
        return array_intersect(['id', 'uuid', 'name', 'email', 'role_name', 'created_at'], $this->fields);
    }

    public function map($user): array
    {
        $data = [];
        if (in_array('id', $this->fields)) $data[] = $user->id;
        if (in_array('uuid', $this->fields)) $data[] = $user->uuid;
        if (in_array('name', $this->fields)) $data[] = $user->name;
        if (in_array('email', $this->fields)) $data[] = $user->email;
        if (in_array('role_name', $this->fields)) $data[] = $user->role ? $user->role->name : '';
        if (in_array('created_at', $this->fields)) $data[] = $user->created_at ? $user->created_at->format('Y-m-d') : '';
        return $data;
    }
}
