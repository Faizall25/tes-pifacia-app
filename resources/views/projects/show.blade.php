@extends('layouts.app')

   @section('title', 'Project Details')

   @section('content')
   <div class="container-fluid">
       <h1 class="h3 mb-4 text-gray-800">Project: {{ $project->title }}</h1>

       <div class="card shadow mb-4">
           <div class="card-header py-3">
               <h6 class="m-0 font-weight-bold text-primary">Project Details</h6>
           </div>
           <div class="card-body">
               <p><strong>Title:</strong> {{ $project->title }}</p>
               <p><strong>Description:</strong> {{ $project->description ?? 'N/A' }}</p>
               <p><strong>Active:</strong> {{ $project->is_active ? 'Yes' : 'No' }}</p>
               <p><strong>Metadata:</strong> {{ json_encode($project->metadata) ?? 'N/A' }}</p>
               <p><strong>Attachment:</strong> @if($project->attachment) <a href="{{ Storage::url($project->attachment) }}" target="_blank">View PDF</a> @else N/A @endif</p>
               <p><strong>Assigned To:</strong> {{ $project->user ? $project->user->name : 'N/A' }}</p>
               <p><strong>Created At:</strong> {{ $project->created_at ? $project->created_at->format('d M Y') : 'N/A' }}</p>

               <h5 class="mt-4">Tasks</h5>
               <ul>
                   @foreach ($project->tasks as $task)
                       <li>{{ $task->title }} ({{ $task->is_completed ? 'Completed' : 'Incomplete' }})</li>
                   @endforeach
               </ul>

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
                           @foreach ($project->audits as $audit)
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
           </div>
       </div>
   </div>
   @endsection