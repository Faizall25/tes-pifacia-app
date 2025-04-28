@extends('layouts.app')

@section('title', 'Projects')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Projects</h1>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Projects List</h6>
            <div>
                <a href="{{ route('projects.create') }}" class="btn btn-primary btn-sm">Add New Project</a>
                <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#exportModal">Export</button>
                <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#importModal">Import</button>
            </div>
        </div>
        <div class="card-body">
            <form method="GET" class="mb-4">
                <div class="row">
                    <div class="col-md-4">
                        <input type="text" name="search" class="form-control" placeholder="Search by title or description" value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <select name="filter" class="form-control">
                            <option value="">All</option>
                            <option value="active" {{ request('filter') === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ request('filter') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="sort" class="form-control">
                            <option value="created_at" {{ request('sort') === 'created_at' ? 'selected' : '' }}>Created At</option>
                            <option value="title" {{ request('sort') === 'title' ? 'selected' : '' }}>Title</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary">Filter</button>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Assigned To</th>
                            <th>Active</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($projects as $project)
                            <tr>
                                <td>{{ $project->id }}</td>
                                <td>{{ $project->title }}</td>
                                <td>{{ $project->user ? $project->user->name : 'N/A' }}</td>
                                <td>{{ $project->is_active ? 'Yes' : 'No' }}</td>
                                <td>{{ $project->created_at ? $project->created_at->format('d M Y') : 'N/A' }}</td>
                                <td>
                                    <a href="{{ route('projects.show', $project) }}" class="btn btn-info btn-sm">View</a>
                                    <a href="{{ route('projects.edit', $project) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('projects.destroy', $project) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                    @if($project->trashed())
                                        <form action="{{ route('projects.restore', $project->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm">Restore</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $projects->links() }}
            </div>
        </div>
    </div>

    <!-- Export Modal -->
    <div class="modal fade" id="exportModal" tabindex="-1" role="dialog" aria-labelledby="exportModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exportModalLabel">Export Projects</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="{{ route('projects.export') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <p>Select fields to export:</p>
                        <div class="form-check">
                            <input type="checkbox" name="fields[]" value="id" class="form-check-input" checked>
                            <label class="form-check-label">ID</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" name="fields[]" value="uuid" class="form-check-input" checked>
                            <label class="form-check-label">UUID</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" name="fields[]" value="title" class="form-check-input" checked>
                            <label class="form-check-label">Title</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" name="fields[]" value="description" class="form-check-input" checked>
                            <label class="form-check-label">Description</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" name="fields[]" value="is_active" class="form-check-input" checked>
                            <label class="form-check-label">Active</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" name="fields[]" value="user_name" class="form-check-input" checked>
                            <label class="form-check-label">Assigned To</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" name="fields[]" value="created_at" class="form-check-input" checked>
                            <label class="form-check-label">Created At</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Export</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Import Modal -->
    <div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importModalLabel">Import Projects</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="{{ route('projects.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="file">Upload Excel File</label>
                            <input type="file" name="file" id="file" class="form-control-file" accept=".xlsx,.xls" required>
                            @error('file')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <p>Note: Excel must include columns: title, description, is_active (Yes/No), user_name.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-info">Import</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "ordering": false
        });
    });
</script>
@endsection