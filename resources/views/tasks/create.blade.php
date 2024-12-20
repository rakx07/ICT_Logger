@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Log New Task</h1>

    <!-- Task Form -->
    <form id="taskForm" action="{{ route('tasks.store') }}" method="POST">
        @csrf
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="staff_id" class="form-label">Staff</label>
                <select name="staff_id" id="staff_id" class="form-select" required>
                    <option value="" disabled selected>Select Staff</option>
                    @foreach($staff as $s)
                        <option value="{{ $s->id }}">{{ $s->first_name }} {{ $s->last_name }}</option>
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
                <select name="status" id="status" class="form-select" required>
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
            <button type="submit" class="btn btn-primary">Log Task</button>
        </div>
    </form>

    <!-- Success Modal -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successModalLabel">Task Added</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    The task has been added successfully.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Task Table -->
    <div class="mt-5">
        <h2 class="mb-3">Task Logs</h2>
        <table class="table table-hover table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Staff</th>
                    <th>Transaction Date</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Remarks</th>
                </tr>
            </thead>
            <tbody id="taskTableBody">
                @foreach($tasks as $task)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $task->staff->first_name }} {{ $task->staff->last_name }}</td>
                    <td>{{ $task->transaction_date }}</td>
                    <td>{{ $task->description }}</td>
                    <td>{{ $task->status }}</td>
                    <td>{{ $task->remarks }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    document.getElementById('taskForm').addEventListener('submit', function(event) {
        event.preventDefault();

        const formData = new FormData(this);

        fetch(this.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const tableBody = document.getElementById('taskTableBody');
                const newRow = document.createElement('tr');

                newRow.innerHTML = `
                    <td>${data.task.id}</td>
                    <td>${data.task.staff.first_name} ${data.task.staff.last_name}</td>
                    <td>${data.task.transaction_date}</td>
                    <td>${data.task.description}</td>
                    <td>${data.task.status}</td>
                    <td>${data.task.remarks || ''}</td>
                `;

                tableBody.prepend(newRow);

                const successModal = new bootstrap.Modal(document.getElementById('successModal'));
                successModal.show();

                this.reset();
            }
        })
        .catch(error => console.error('Error:', error));
    });
</script>
@endsection
