@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Staff List</h1>
    <a href="{{ route('staff.create') }}" class="btn btn-primary mb-3">Add New Staff</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Position</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($staff as $member)
            <tr>
                <td>{{ $member->name }}</td>
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
</div>
@endsection
