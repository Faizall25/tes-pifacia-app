<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Exports\ProjectsExport;
use App\Imports\ProjectsImport;
use App\Jobs\ExportExcel;
use App\Jobs\ImportExcel;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Queue;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $query = Project::with('user')->when($request->search, function ($q) use ($request) {
            $q->where('title', 'like', "%{$request->search}%")
                ->orWhere('description', 'like', "%{$request->search}%");
        });

        if ($request->filter === 'active') {
            $query->where('is_active', true);
        } elseif ($request->filter === 'inactive') {
            $query->where('is_active', false);
        }

        $sort = $request->sort ?? 'created_at';
        $direction = $request->direction ?? 'desc';
        $projects = $query->orderBy($sort, $direction)->paginate(10);

        return view('projects.index', compact('projects'));
    }

    public function create()
    {
        $users = User::all();
        return view('projects.create', compact('users'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'is_active' => ['required', 'boolean'],
            'metadata' => ['nullable', 'json'],
            'attachment' => ['nullable', 'file', 'mimes:pdf', 'min:100', 'max:500'],
            'user_id' => ['required', 'exists:users,id'],
        ]);

        $data['uuid'] = Str::uuid();
        if ($request->hasFile('attachment')) {
            $data['attachment'] = $request->file('attachment')->store('projects', 'public');
        }

        Project::create($data);

        return redirect()->route('projects.index')->with('success', 'Project created successfully.');
    }

    public function show(Project $project)
    {
        $project->load('user', 'tasks');
        return view('projects.show', compact('project'));
    }

    public function edit(Project $project)
    {
        $users = User::all();
        return view('projects.edit', compact('project', 'users'));
    }

    public function update(Request $request, Project $project)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'is_active' => ['required', 'boolean'],
            'metadata' => ['nullable', 'json'],
            'attachment' => ['nullable', 'file', 'mimes:pdf', 'min:100', 'max:500'],
            'user_id' => ['required', 'exists:users,id'],
        ]);

        if ($request->hasFile('attachment')) {
            if ($project->attachment) {
                Storage::disk('public')->delete($project->attachment);
            }
            $data['attachment'] = $request->file('attachment')->store('projects', 'public');
        }

        $project->update($data);

        return redirect()->route('projects.index')->with('success', 'Project updated successfully.');
    }

    public function destroy(Project $project)
    {
        if ($project->attachment) {
            Storage::disk('public')->delete($project->attachment);
        }
        $project->delete();

        return redirect()->route('projects.index')->with('success', 'Project deleted successfully.');
    }

    public function restore($id)
    {
        $project = Project::onlyTrashed()->findOrFail($id);
        $project->restore();

        return redirect()->route('projects.index')->with('success', 'Project restored successfully.');
    }

    public function export(Request $request)
    {
        $fields = $request->input('fields', ['id', 'uuid', 'title', 'description', 'is_active', 'user_name', 'created_at']);
        Queue::push(new ExportExcel(new ProjectsExport($fields), 'projects.xlsx', 'public'));
        return redirect()->route('projects.index')->with('success', 'Export queued. Download will be available soon.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:xlsx,xls'],
        ]);

        $filePath = $request->file('file')->store('imports');
        Queue::push(new ImportExcel(new ProjectsImport(), storage_path('app/' . $filePath)));
        return redirect()->route('projects.index')->with('success', 'Import queued. Data will be processed soon.');
    }
}
