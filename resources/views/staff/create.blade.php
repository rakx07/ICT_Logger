@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Add New Staff</h1>

    <!-- Staff Form -->
    <form id="staffForm" action="{{ route('staff.store') }}" method="POST">
        @csrf
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="first_name" class="form-label fw-bold">First Name</label>
                <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter first name" required>
            </div>
            <div class="col-md-4">
                <label for="middle_name" class="form-label fw-bold">Middle Name</label>
                <input type="text" class="form-control" id="middle_name" name="middle_name" placeholder="Enter middle name (optional)">
            </div>
            <div class="col-md-4">
                <label for="last_name" class="form-label fw-bold">Last Name</label>
                <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Enter last name" required>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="email" class="form-label fw-bold">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter email address" required>
            </div>
            <div class="col-md-6">
                <label for="position" class="form-label fw-bold">Position</label>
                <input type="text" class="form-control" id="position" name="position" placeholder="Enter position" required>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="phone_number" class="form-label fw-bold">Phone Number</label>
                <input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="Enter phone number (optional)" pattern="\d+" title="Please enter only numbers">
            </div>
            <div class="col-md-6">
                <label for="address" class="form-label fw-bold">Address</label>
                <textarea class="form-control" id="address" name="address" rows="2" placeholder="Enter address (optional)"></textarea>
            </div>
        </div>
        <div class="d-flex justify-content-between">
            <button type="reset" class="btn btn-secondary">Reset</button>
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</div>

<!-- ✅ Stylish Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-center p-4">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold text-success" id="successModalLabel">✔ Staff Added!</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <i class="fas fa-check-circle text-success fa-4x mb-3"></i> <!-- ✅ Check Icon -->
                <p class="fs-5 text-muted">The staff member has been successfully added.</p>
            </div>
            <div class="modal-footer border-0 d-flex justify-content-center">
                <button type="button" class="btn btn-success px-4 fw-bold" data-bs-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>

<!-- Staff List Table -->
<div class="mt-5">
    <h2 class="mb-3">Staff List</h2>
    @if($staff->isEmpty())
        <p>No staff available. Add new staff above.</p>
    @else
        <table class="table table-hover table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>First Name</th>
                    <th>Middle Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Position</th>
                    <th>Phone Number</th>
                    <th>Address</th>
                </tr>
            </thead>
            <tbody id="staffTableBody">
                @foreach($staff as $member)
                <tr>
                    <td>{{ $member->first_name }}</td>
                    <td>{{ $member->middle_name }}</td>
                    <td>{{ $member->last_name }}</td>
                    <td>{{ $member->email }}</td>
                    <td>{{ $member->position }}</td>
                    <td>{{ $member->phone_number }}</td>
                    <td>{{ $member->address }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

<script>
    document.getElementById('staffForm').addEventListener('submit', function(event) {
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
                // ✅ Show Success Modal
                let successModal = new bootstrap.Modal(document.getElementById('successModal'));
                successModal.show();

                // ✅ Add New Staff to the Table
                const tableBody = document.getElementById('staffTableBody');
                const newRow = document.createElement('tr');

                newRow.innerHTML = `
                    <td>${data.staff.first_name}</td>
                    <td>${data.staff.middle_name || ''}</td>
                    <td>${data.staff.last_name}</td>
                    <td>${data.staff.email}</td>
                    <td>${data.staff.position}</td>
                    <td>${data.staff.phone_number || ''}</td>
                    <td>${data.staff.address || ''}</td>
                `;

                tableBody.prepend(newRow);

                // ✅ Reset the Form
                document.getElementById('staffForm').reset();
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
