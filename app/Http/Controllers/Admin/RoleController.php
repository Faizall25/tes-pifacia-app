<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Exports\RolesExport;
use App\Imports\RolesImport;
use App\Jobs\ExportExcel;
use App\Jobs\ImportExcel;
use Illuminate\Http\Request;
use App\Models\Role;
use Illuminate\Support\Facades\Queue;
use Maatwebsite\Excel\Facades\Excel;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::withTrashed()->paginate(10);
        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        $this->authorizeAdmin();
        return view('admin.roles.create');
    }

    public function store(Request $request)
    {
        $this->authorizeAdmin();
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:roles'],
            'guard_name' => ['required', 'string', 'max:255'],
        ]);

        Role::create($data);
        return redirect()->route('roles.index')->with('success', 'Role created successfully.');
    }

    public function show(Role $role)
    {
        return view('admin.roles.show', compact('role'));
    }

    public function edit(Role $role)
    {
        $this->authorizeAdmin();
        return view('admin.roles.edit', compact('role'));
    }

    public function update(Request $request, Role $role)
    {
        $this->authorizeAdmin();
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:roles,name,' . $role->id],
            'guard_name' => ['required', 'string', 'max:255'],
        ]);

        $role->update($data);
        return redirect()->route('roles.index')->with('success', 'Role updated successfully.');
    }

    public function destroy(Role $role)
    {
        $this->authorizeAdmin();
        $role->delete();
        return redirect()->route('roles.index')->with('success', 'Role deleted successfully.');
    }

    public function restore($id)
    {
        $this->authorizeAdmin();
        $role = Role::onlyTrashed()->findOrFail($id);
        $role->restore();
        return redirect()->route('roles.index')->with('success', 'Role restored successfully.');
    }

    public function export(Request $request)
    {
        $this->authorizeAdmin();
        $fields = $request->input('fields', ['id', 'name', 'guard_name', 'created_at']);
        Queue::push(new ExportExcel(new RolesExport($fields), 'roles.xlsx', 'public'));
        return redirect()->route('roles.index')->with('success', 'Export queued. Download will be available soon.');
    }

    public function import(Request $request)
    {
        $this->authorizeAdmin();
        $request->validate([
            'file' => ['required', 'file', 'mimes:xlsx,xls'],
        ]);

        $filePath = $request->file('file')->store('imports');
        Queue::push(new ImportExcel(new RolesImport(), storage_path('app/' . $filePath)));
        return redirect()->route('roles.index')->with('success', 'Import queued. Data will be processed soon.');
    }

    protected function authorizeAdmin()
    {
        if (auth()->user()->role->name !== 'Administrator') {
            abort(403, 'Unauthorized action.');
        }
    }
}
