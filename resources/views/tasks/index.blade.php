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
                <td>
                    <select class="form-select status-dropdown" data-task-id="{{ $task->id }}">
                        <option value="on process" {{ $task->status == 'on process' ? 'selected' : '' }}>On Process</option>
                        <option value="done" {{ $task->status == 'done' ? 'selected' : '' }}>Done</option>
                        <option value="cancelled" {{ $task->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </td>
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.status-dropdown').forEach(function(select) {
            select.addEventListener('change', function() {
                let taskId = this.getAttribute('data-task-id');
                let newStatus = this.value;

                fetch(`/tasks/${taskId}/update-status`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ status: newStatus })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Status updated successfully!');
                    } else {
                        alert('Failed to update status.');
                    }
                })
                .catch(error => console.error('Error:', error));
            });
        });
    });
</script>
@endsection
