@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Task Logs</h1>

    <!-- Action Buttons -->
    <div class="mb-3 d-flex justify-content-between">
        <a href="{{ route('tasks.create') }}" class="btn btn-primary">Add New Task</a>
    </div>

    <!-- Task Logs Table -->
    <table class="table table-hover table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Date</th>
                <th>Staff</th>
                <th>Description</th>
                <th>Status</th>
                <th>Remarks</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tasks as $task)
            <tr>
                <td>{{ $task->transaction_date }}</td>
                <td>{{ $task->staff->full_name ?? 'N/A' }}</td> <!-- Use full_name accessor -->
                <td>{{ $task->description }}</td>
                <td>{{ $task->status }}</td>
                <td>{{ $task->remarks }}</td>
                <td>
                    <a href="{{ route('tasks.edit', $task) }}" class="btn btn-warning btn-sm">Edit</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination Links -->
    {{ $tasks->links() }}
</div>
@endsection
