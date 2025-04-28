<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Comment extends Model implements Auditable
{
    use SoftDeletes, \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'uuid',
        'content',
        'metadata',
        'task_id',
        'user_id',
    ];

    protected $casts = [
        'metadata' => 'array',
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getAuditFields()
    {
        return [
            'content',
            'metadata',
            'task_id',
            'task_title' => fn($model) => $model->task ? $model->task->title : null,
        ];
    }
}
