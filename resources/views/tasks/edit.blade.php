@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Edit Task</h1>

    <!-- Task Form -->
    <form id="editTaskForm" action="{{ route('tasks.update', $task->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="staff_id" class="form-label fw-bold">Staff</label>
                <select name="staff_id" id="staff_id" class="form-select" required>
                    <option value="" disabled>Select Staff</option>
                    @foreach($staff as $s)
                        <option value="{{ $s->id }}" {{ $task->staff_id == $s->id ? 'selected' : '' }}>
                            {{ $s->first_name }} {{ $s->last_name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label for="transaction_date" class="form-label fw-bold">Transaction Date</label>
                <input type="date" name="transaction_date" id="transaction_date" class="form-control" value="{{ $task->transaction_date }}" required>
            </div>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label fw-bold">Description</label>
            <textarea name="description" id="description" class="form-control" rows="3" required>{{ $task->description }}</textarea>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="status" class="form-label fw-bold">Status</label>
                <select name="status" id="status" class="form-select" required>
                    <option value="on process" {{ $task->status == 'on process' ? 'selected' : '' }}>On Process</option>
                    <option value="done" {{ $task->status == 'done' ? 'selected' : '' }}>Done</option>
                    <option value="cancelled" {{ $task->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>
            <div class="col-md-6">
                <label for="remarks" class="form-label fw-bold">Remarks</label>
                <input type="text" name="remarks" id="remarks" class="form-control" value="{{ $task->remarks }}" placeholder="Optional remarks">
            </div>
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Back</a>
            <button type="submit" class="btn btn-primary">Update Task</button>
        </div>
    </form>
</div>

<script>
    document.getElementById('editTaskForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent default form submission

        let form = this;
        let formData = new FormData(form);

        fetch(form.action, {
            method: 'POST', // Laravel supports method spoofing via `_method`
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'X-Requested-With': 'XMLHttpRequest' // Let Laravel know it's an AJAX request
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Task updated successfully!');
                window.location.href = "{{ route('tasks.index') }}"; // Redirect after success
            } else {
                alert('Failed to update task.');
            }
        })
        .catch(error => console.error('Error:', error));
    });
</script>
@endsection
