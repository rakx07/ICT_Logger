@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Staff List</h1>

    <!-- Add New Staff Button -->
    <div class="mb-3 d-flex justify-content-between">
        <a href="{{ route('staff.create') }}" class="btn btn-primary">Add New Staff</a>
    </div>

    <!-- Staff Table -->
    <table class="table table-hover table-bordered">
        <thead class="table-dark">
            <tr>
                <th>First Name</th>
                <th>Middle Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Position</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($staff as $member)
            <tr>
                <td>{{ $member->first_name }}</td>
                <td>{{ $member->middle_name }}</td>
                <td>{{ $member->last_name }}</td>
                <td>{{ $member->email }}</td>
                <td>{{ $member->position }}</td>
                <td>
                    <a href="{{ route('staff.edit', $member->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('staff.destroy', $member->id) }}" method="POST" style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination Links -->
    {{ $staff->links() }}
</div>
@endsection