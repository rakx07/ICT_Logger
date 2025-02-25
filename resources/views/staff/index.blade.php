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
                    <button type="button" class="btn btn-danger btn-sm delete-btn" data-id="{{ $member->id }}" data-name="{{ $member->first_name }} {{ $member->last_name }}">Delete</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination Links -->
    {{ $staff->links() }}
</div>

<!-- ✅ Delete Confirmation Modal -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-center p-4">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold text-danger" id="confirmDeleteModalLabel">⚠ Delete Staff</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <i class="fas fa-exclamation-circle text-danger fa-4x mb-3"></i> <!-- ❗ Warning Icon -->
                <p class="fs-5 text-muted">Are you sure you want to delete <span id="staffName"></span>?</p>
            </div>
            <div class="modal-footer border-0 d-flex justify-content-center">
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger px-4 fw-bold">Delete</button>
                </form>
                <button type="button" class="btn btn-secondary px-4 fw-bold" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function() {
                let staffId = this.getAttribute('data-id');
                let staffName = this.getAttribute('data-name');

                // Set the staff name in the modal
                document.getElementById('staffName').textContent = staffName;

                // Set form action dynamically
                document.getElementById('deleteForm').action = `/staff/${staffId}`;

                // Show the confirmation modal
                let deleteModal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
                deleteModal.show();
            });
        });
    });
</script>

<!-- ✅ Load Local Bootstrap JS -->
<script src="{{ asset('assets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<!-- ✅ Load Local FontAwesome (for warning icon) -->
<script src="{{ asset('assets/fontawesome/js/all.min.js') }}"></script>

@endsection
