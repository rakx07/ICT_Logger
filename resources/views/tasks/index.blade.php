@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Task Logs</h1>
    <a href="{{ route('tasks.create') }}" class="btn btn-primary mb-3">Log New Task</a>

    <table class="table table-bordered">
        <thead>
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
