@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Log New Task</h1>
    <form action="{{ route('tasks.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="staff_id">Staff</label>
            <select name="staff_id" id="staff_id" class="form-control">
                @foreach($staff as $s)
                    <option value="{{ $s->id }}">{{ $s->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="transaction_date">Transaction Date</label>
            <input type="date" name="transaction_date" id="transaction_date" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control" rows="3" required></textarea>
        </div>

        <div class="form-group">
            <label for="status">Status</label>
            <select name="status" id="status" class="form-control">
                <option value="on process">On Process</option>
                <option value="done">Done</option>
                <option value="cancelled">Cancelled</option>
            </select>
        </div>

        <div class="form-group">
            <label for="remarks">Remarks</label>
            <input type="text" name="remarks" id="remarks" class="form-control">
        </div>

        <button type="submit" class="btn btn-success">Save Task</button>
    </form>
</div>
@endsection
