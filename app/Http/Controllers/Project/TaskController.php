<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Exports\TasksExport;
use App\Imports\TasksImport;
use App\Jobs\ExportExcel;
use App\Jobs\ImportExcel;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Queue;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $query = Task::with('project', 'user')->when($request->search, function ($q) use ($request) {
            $q->where('title', 'like', "%{$request->search}%")
                ->orWhere('description', 'like', "%{$request->search}%");
        });

        if ($request->filter === 'completed') {
            $query->where('is_completed', true);
        } elseif ($request->filter === 'incomplete') {
            $query->where('is_completed', false);
        }

        $sort = $request->sort ?? 'created_at';
        $direction = $request->direction ?? 'desc';
        $tasks = $query->orderBy($sort, $direction)->paginate(10);

        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        $projects = Project::all();
        $users = User::all();
        return view('tasks.create', compact('projects', 'users'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'is_completed' => ['required', 'boolean'],
            'metadata' => ['nullable', 'json'],
            'project_id' => ['required', 'exists:projects,id'],
            'user_id' => ['required', 'exists:users,id'],
        ]);

        $data['uuid'] = Str::uuid();
        Task::create($data);

        return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
    }

    public function show(Task $task)
    {
        $task->load('project', 'user', 'comments');
        return view('tasks.show', compact('task'));
    }

    public function edit(Task $task)
    {
        $projects = Project::all();
        $users = User::all();
        return view('tasks.edit', compact('task', 'projects', 'users'));
    }

    public function update(Request $request, Task $task)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'is_completed' => ['required', 'boolean'],
            'metadata' => ['nullable', 'json'],
            'project_id' => ['required', 'exists:projects,id'],
            'user_id' => ['required', 'exists:users,id'],
        ]);

        $task->update($data);

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
    }

    public function restore($id)
    {
        $task = Task::onlyTrashed()->findOrFail($id);
        $task->restore();

        return redirect()->route('tasks.index')->with('success', 'Task restored successfully.');
    }

    public function export(Request $request)
    {
        $fields = $request->input('fields', ['id', 'uuid', 'title', 'description', 'is_completed', 'project_title', 'user_name', 'created_at']);
        Queue::push(new ExportExcel(new TasksExport($fields), 'tasks.xlsx', 'public'));
        return redirect()->route('tasks.index')->with('success', 'Export queued. Download will be available soon.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:xlsx,xls'],
        ]);

        $filePath = $request->file('file')->store('imports');
        Queue::push(new ImportExcel(new TasksImport(), storage_path('app/' . $filePath)));
        return redirect()->route('tasks.index')->with('success', 'Import queued. Data will be processed soon.');
    }
}
