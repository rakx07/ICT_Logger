@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Task Logs</h1>

    <!-- Action Buttons -->
    <div class="mb-3 d-flex justify-content-between">
        <a href="{{ route('tasks.create') }}" class="btn btn-primary">Add New Task</a>
        <a href="{{ route('staff.create') }}" class="btn btn-secondary">Add New Staff</a>
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
                <td>{{ $task->staff->name }}</td>
                <td>{{ $task->description }}</td>
                <td>{{ $task->status }}</td>
                <td>{{ $task->remarks }}</td>
                <td>
                    <a href="{{ route('tasks.edit', $task) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('tasks.destroy', $task) }}" method="POST" style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $tasks->links() }}
</div>
@endsection
