@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Edit Staff</h1>

    <!-- Edit Staff Form -->
    <form id="editStaffForm" action="{{ route('staff.update', $staff->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label fw-bold">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $staff->name }}" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label fw-bold">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ $staff->email }}" required>
        </div>
        <div class="mb-3">
            <label for="position" class="form-label fw-bold">Position</label>
            <input type="text" class="form-control" id="position" name="position" value="{{ $staff->position }}" required>
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('staff.index') }}" class="btn btn-secondary">Back</a>
            <button type="submit" class="btn btn-primary">Update Staff</button>
        </div>
    </form>
</div>

<!-- ✅ Stylish Bootstrap Modal for Success Message -->
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-center p-4">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold text-success" id="successModalLabel">✔ Staff Updated!</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <i class="fas fa-check-circle text-success fa-4x mb-3"></i> <!-- ✅ Check Icon -->
                <p class="fs-5 text-muted">The staff member's details have been successfully updated.</p>
            </div>
            <div class="modal-footer border-0 d-flex justify-content-center">
                <button type="button" class="btn btn-success px-4 fw-bold" data-bs-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('editStaffForm').addEventListener('submit', function(event) {
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
                // ✅ Show Success Modal
                let successModal = new bootstrap.Modal(document.getElementById('successModal'));
                successModal.show();
            } else {
                alert('Failed to update staff details.');
            }
        })
        .catch(error => console.error('Error:', error));
    });
</script>

<!-- ✅ Load Local Bootstrap JS -->
<script src="{{ asset('assets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<!-- ✅ Load Local FontAwesome (for check icon) -->
<script src="{{ asset('assets/fontawesome/js/all.min.js') }}"></script>

@endsection
