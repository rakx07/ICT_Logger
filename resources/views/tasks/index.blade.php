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
                <td>{{ $task->staff->full_name ?? 'N/A' }}</td>
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

    <!-- Pagination Links with Fixed Icons -->
    <div class="d-flex justify-content-center">
        <style>
            .pagination .page-link {
                display: flex;
                align-items: center;
                justify-content: center;
                width: 32px; /* Adjust size as needed */
                height: 32px;
                font-size: 16px;
                padding: 5px;
            }
            .pagination-icon {
                font-size: 16px !important; /* Adjust for FontAwesome icons */
            }
        </style>
        {{ $tasks->links('pagination::bootstrap-4') }}
    </div>
</div>

<!-- ✅ Stylish Bootstrap Modal for Success Message -->
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-center p-4">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold text-success" id="successModalLabel">✔ Task Updated!</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <i class="fas fa-check-circle text-success fa-2x mb-3"></i> <!-- ✅ Smaller Check Icon -->
                <p class="fs-5 text-muted">The task status has been successfully updated.</p>
            </div>
            <div class="modal-footer border-0 d-flex justify-content-center">
                <button type="button" class="btn btn-success px-4 fw-bold" data-bs-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
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
                        let successModal = new bootstrap.Modal(document.getElementById('successModal'));
                        successModal.show();
                        // ✅ Reload page to reflect latest updates
                        successModal._element.addEventListener('hidden.bs.modal', function () {
                            location.reload();
                        });
                    } else {
                        alert('Failed to update status.');
                    }
                })
                .catch(error => console.error('Error:', error));
            });
        });
    });
</script>

<!-- ✅ Load Local Bootstrap JS -->
<script src="{{ asset('assets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<!-- ✅ Load Local FontAwesome (for check icon) -->
<script src="{{ asset('assets/fontawesome/js/all.min.js') }}"></script>
@endsection
