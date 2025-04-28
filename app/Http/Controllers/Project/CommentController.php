<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Exports\CommentsExport;
use App\Imports\CommentsImport;
use App\Jobs\ExportExcel;
use App\Jobs\ImportExcel;
use App\Models\Comment;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Queue;

class CommentController extends Controller
{
    public function index(Request $request)
    {
        $query = Comment::with('task', 'user')->when($request->search, function ($q) use ($request) {
            $q->where('content', 'like', "%{$request->search}%");
        });

        $sort = $request->sort ?? 'created_at';
        $direction = $request->direction ?? 'desc';
        $comments = $query->orderBy($sort, $direction)->paginate(10);

        return view('comments.index', compact('comments'));
    }

    public function create()
    {
        $tasks = Task::all();
        return view('comments.create', compact('tasks'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'content' => ['required', 'string'],
            'metadata' => ['nullable', 'json'],
            'task_id' => ['required', 'exists:tasks,id'],
        ]);

        $data['uuid'] = Str::uuid();
        $data['user_id'] = auth()->id();
        Comment::create($data);

        return redirect()->route('comments.index')->with('success', 'Comment created successfully.');
    }

    public function show(Comment $comment)
    {
        $comment->load('task', 'user');
        return view('comments.show', compact('comment'));
    }

    public function edit(Comment $comment)
    {
        $tasks = Task::all();
        return view('comments.edit', compact('comment', 'tasks'));
    }

    public function update(Request $request, Comment $comment)
    {
        $data = $request->validate([
            'content' => ['required', 'string'],
            'metadata' => ['nullable', 'json'],
            'task_id' => ['required', 'exists:tasks,id'],
        ]);

        $comment->update($data);

        return redirect()->route('comments.index')->with('success', 'Comment updated successfully.');
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();

        return redirect()->route('comments.index')->with('success', 'Comment deleted successfully.');
    }

    public function restore($id)
    {
        $comment = Comment::onlyTrashed()->findOrFail($id);
        $comment->restore();

        return redirect()->route('comments.index')->with('success', 'Comment restored successfully.');
    }

    public function export(Request $request)
    {
        $fields = $request->input('fields', ['id', 'uuid', 'content', 'task_title', 'user_name', 'created_at']);
        Queue::push(new ExportExcel(new CommentsExport($fields), 'comments.xlsx', 'public'));
        return redirect()->route('comments.index')->with('success', 'Export queued. Download will be available soon.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:xlsx,xls'],
        ]);

        $filePath = $request->file('file')->store('imports');
        Queue::push(new ImportExcel(new CommentsImport(), storage_path('app/' . $filePath)));
        return redirect()->route('comments.index')->with('success', 'Import queued. Data will be processed soon.');
    }
}
