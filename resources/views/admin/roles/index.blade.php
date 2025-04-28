@extends('layouts.app')

@section('title', 'Roles')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Roles</h1>

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
            <h6 class="m-0 font-weight-bold text-primary">Roles List</h6>
            @if(auth()->user()->role->name === 'Administrator')
                <div>
                    <a href="{{ route('roles.create') }}" class="btn btn-primary btn-sm">Add New Role</a>
                    <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#exportModal">Export</button>
                    <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#importModal">Import</button>
                </div>
            @endif
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Guard Name</th>
                            <th>Created At</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $role)
                            <tr>
                                <td>{{ $role->id }}</td>
                                <td>{{ $role->name }}</td>
                                <td>{{ $role->guard_name }}</td>
                                <td>{{ $role->created_at ? $role->created_at->format('d M Y') : 'N/A' }}</td>
                                <td>{{ $role->trashed() ? 'Deleted' : 'Active' }}</td>
                                <td>
                                    <a href="{{ route('roles.show', $role) }}" class="btn btn-info btn-sm">View</a>
                                    @if(auth()->user()->role->name === 'Administrator')
                                        @if(!$role->trashed())
                                            <a href="{{ route('roles.edit', $role) }}" class="btn btn-warning btn-sm">Edit</a>
                                            <form action="{{ route('roles.destroy', $role) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                                            </form>
                                        @else
                                            <form action="{{ route('roles.restore', $role->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm">Restore</button>
                                            </form>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $roles->links() }}
            </div>
        </div>
    </div>

    <!-- Export Modal -->
    <div class="modal fade" id="exportModal" tabindex="-1" role="dialog" aria-labelledby="exportModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exportModalLabel">Export Roles</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="{{ route('roles.export') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <p>Select fields to export:</p>
                        <div class="form-check">
                            <input type="checkbox" name="fields[]" value="id" class="form-check-input" checked>
                            <label class="form-check-label">ID</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" name="fields[]" value="name" class="form-check-input" checked>
                            <label class="form-check-label">Name</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" name="fields[]" value="guard_name" class="form-check-input" checked>
                            <label class="form-check-label">Guard Name</label>
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
                    <h5 class="modal-title" id="importModalLabel">Import Roles</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="{{ route('roles.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="file">Upload Excel File</label>
                            <input type="file" name="file" id="file" class="form-control-file" accept=".xlsx,.xls" required>
                            @error('file')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
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