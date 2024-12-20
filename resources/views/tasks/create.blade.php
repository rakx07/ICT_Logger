@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Log New Task</h1>
    <form action="{{ route('tasks.store') }}" method="POST">
        @csrf
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="staff_id" class="form-label">Staff</label>
                <select name="staff_id" id="staff_id" class="form-select" required>
                    <option value="" disabled selected>Select Staff</option>
                    @foreach($staff as $s)
                        <option value="{{ $s->id }}">{{ $s->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label for="transaction_date" class="form-label">Transaction Date</label>
                <input type="date" name="transaction_date" id="transaction_date" class="form-control" value="{{ now()->toDateString() }}" required>
            </div>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" class="form-control" rows="3" placeholder="Enter task description..." required></textarea>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="status" class="form-label">Status</label>
                <select name="status" id="status" class="form-select">
                    <option value="on process">On Process</option>
                    <option value="done">Done</option>
                    <option value="cancelled">Cancelled</option>
                </select>
            </div>
            <div class="col-md-6">
                <label for="remarks" class="form-label">Remarks</label>
                <input type="text" name="remarks" id="remarks" class="form-control" placeholder="Optional remarks">
            </div>
        </div>

        <div class="d-flex justify-content-between">
            <button type="reset" class="btn btn-secondary">Reset</button>
            <button type="submit" class="btn btn-success">Save Task</button>
        </div>
    </form>
</div>
@endsection
