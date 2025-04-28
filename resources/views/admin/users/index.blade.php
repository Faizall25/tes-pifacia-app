@extends('layouts.app')

   @section('title', 'Users')

   @section('content')
   <div class="container-fluid">
       <h1 class="h3 mb-4 text-gray-800">Users</h1>

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
               <h6 class="m-0 font-weight-bold text-primary">Users List</h6>
               <div>
                   <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm">Add New User</a>
                   <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#exportModal">Export</button>
                   <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#importModal">Import</button>
               </div>
           </div>
           <div class="card-body">
               <div class="table-responsive">
                   <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                       <thead>
                           <tr>
                               <th>ID</th>
                               <th>Name</th>
                               <th>Email</th>
                               <th>Role</th>
                               <th>Created At</th>
                               <th>Actions</th>
                           </tr>
                       </thead>
                       <tbody>
                           @foreach ($users as $user)
                               <tr>
                                   <td>{{ $user->id }}</td>
                                   <td>{{ $user->name }}</td>
                                   <td>{{ $user->email }}</td>
                                   <td>{{ $user->role ? $user->role->name : 'N/A' }}</td>
                                   <td>{{ $user->created_at ? $user->created_at->format('d M Y') : 'N/A' }}</td>
                                   <td>
                                       <a href="{{ route('users.show', $user) }}" class="btn btn-info btn-sm">View</a>
                                       <a href="{{ route('users.edit', $user) }}" class="btn btn-warning btn-sm">Edit</a>
                                       <form action="{{ route('users.destroy', $user) }}" method="POST" style="display:inline;">
                                           @csrf
                                           @method('DELETE')
                                           <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                                       </form>
                                   </td>
                               </tr>
                           @endforeach
                       </tbody>
                   </table>
                   {{ $users->links() }}
               </div>
           </div>
       </div>

       <!-- Export Modal -->
       <div class="modal fade" id="exportModal" tabindex="-1" role="dialog" aria-labelledby="exportModalLabel" aria-hidden="true">
           <div class="modal-dialog" role="document">
               <div class="modal-content">
                   <div class="modal-header">
                       <h5 class="modal-title" id="exportModalLabel">Export Users</h5>
                       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                       </button>
                   </div>
                   <form action="{{ route('users.export') }}" method="POST">
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
                               <input type="checkbox" name="fields[]" value="name" class="form-check-input" checked>
                               <label class="form-check-label">Name</label>
                           </div>
                           <div class="form-check">
                               <input type="checkbox" name="fields[]" value="email" class="form-check-input" checked>
                               <label class="form-check-label">Email</label>
                           </div>
                           <div class="form-check">
                               <input type="checkbox" name="fields[]" value="role_name" class="form-check-input" checked>
                               <label class="form-check-label">Role Name</label>
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
                       <h5 class="modal-title" id="importModalLabel">Import Users</h5>
                       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                       </button>
                   </div>
                   <form action="{{ route('users.import') }}" method="POST" enctype="multipart/form-data">
                       @csrf
                       <div class="modal-body">
                           <div class="form-group">
                               <label for="file">Upload Excel File</label>
                               <input type="file" name="file" id="file" class="form-control-file" accept=".xlsx,.xls" required>
                               @error('file')
                                   <small class="text-danger">{{ $message }}</small>
                               @enderror
                           </div>
                           <p>Note: Excel must include columns: name, email, role_name.</p>
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