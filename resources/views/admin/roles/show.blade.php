@extends('layouts.app')

@section('title', 'Role Details')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Role: {{ $role->name }}</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Role Details</h6>
        </div>
        <div class="card-body">
            <p><strong>Name:</strong> {{ $role->name }}</p>
            <p><strong>Guard Name:</strong> {{ $role->guard_name }}</p>
            <p><strong>Created At:</strong> {{ $role->created_at ? $role->created_at->format('d M Y') : 'N/A' }}</p>

            @if($role->audits)
                <h5 class="mt-4">Audit Trail</h5>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Event</th>
                                <th>User</th>
                                <th>Old Values</th>
                                <th>New Values</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($role->audits as $audit)
                                <tr>
                                    <td>{{ $audit->event }}</td>
                                    <td>{{ $audit->user ? $audit->user->name : 'N/A' }}</td>
                                    <td>{{ json_encode($audit->old_values) }}</td>
                                    <td>{{ json_encode($audit->new_values) }}</td>
                                    <td>{{ $audit->created_at->format('d M Y H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection