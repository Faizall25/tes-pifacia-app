<?php

namespace App\Exports;

use App\Models\Comment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CommentsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $fields;

    public function __construct(array $fields)
    {
        $this->fields = $fields;
    }

    public function collection()
    {
        return Comment::with('task', 'user')->get();
    }

    public function headings(): array
    {
        return array_intersect(['id', 'uuid', 'content', 'task_title', 'user_name', 'created_at'], $this->fields);
    }

    public function map($comment): array
    {
        $data = [];
        if (in_array('id', $this->fields)) $data[] = $comment->id;
        if (in_array('uuid', $this->fields)) $data[] = $comment->uuid;
        if (in_array('content', $this->fields)) $data[] = $comment->content;
        if (in_array('task_title', $this->fields)) $data[] = $comment->task ? $comment->task->title : '';
        if (in_array('user_name', $this->fields)) $data[] = $comment->user ? $comment->user->name : '';
        if (in_array('created_at', $this->fields)) $data[] = $comment->created_at ? $comment->created_at->format('Y-m-d') : '';
        return $data;
    }
}
