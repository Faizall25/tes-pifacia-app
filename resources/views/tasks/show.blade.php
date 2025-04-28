@extends('layouts.app')

   @section('title', 'Task Details')

   @section('content')
   <div class="container-fluid">
       <h1 class="h3 mb-4 text-gray-800">Task: {{ $task->title }}</h1>

       <div class="card shadow mb-4">
           <div class="card-header py-3">
               <h6 class="m-0 font-weight-bold text-primary">Task Details</h6>
           </div>
           <div class="card-body">
               <p><strong>Title:</strong> {{ $task->title }}</p>
               <p><strong>Description:</strong> {{ $task->description ?? 'N/A' }}</p>
               <p><strong>Completed:</strong> {{ $task->is_completed ? 'Yes' : 'No' }}</p>
               <p><strong>Metadata:</strong> {{ json_encode($task->metadata) ?? 'N/A' }}</p>
               <p><strong>Project:</strong> {{ $task->project ? $task->project->title : 'N/A' }}</p>
               <p><strong>Assigned To:</strong> {{ $task->user ? $task->user->name : 'N/A' }}</p>
               <p><strong>Created At:</strong> {{ $task->created_at ? $task->created_at->format('d M Y') : 'N/A' }}</p>

               <h5 class="mt-4">Comments</h5>
               <ul>
                   @foreach ($task->comments as $comment)
                       <li>{{ $comment->content }} (by {{ $comment->user ? $comment->user->name : 'N/A' }})</li>
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
                           @foreach ($task->audits as $audit)
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