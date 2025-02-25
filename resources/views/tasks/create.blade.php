@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Log New Task</h1>

    <!-- Task Form -->
    <form id="taskForm" action="{{ route('tasks.store') }}" method="POST">
        @csrf
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="staff_id" class="form-label fw-bold">Staff</label>
                <select name="staff_id" id="staff_id" class="form-select" required>
                    <option value="" disabled selected>Select Staff</option>
                    @foreach($staff as $s)
                        <option value="{{ $s->id }}">{{ $s->first_name }} {{ $s->last_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label for="transaction_date" class="form-label fw-bold">Transaction Date</label>
                <input type="date" name="transaction_date" id="transaction_date" class="form-control" value="{{ now()->toDateString() }}" required>
            </div>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label fw-bold">Description</label>
            <textarea name="description" id="description" class="form-control" rows="3" placeholder="Enter task description..." required></textarea>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="status" class="form-label fw-bold">Status</label>
                <select name="status" id="status" class="form-select" required>
                    <option value="on process">On Process</option>
                    <option value="done">Done</option>
                    <option value="cancelled">Cancelled</option>
                </select>
            </div>
            <div class="col-md-6">
                <label for="remarks" class="form-label fw-bold">Remarks</label>
                <input type="text" name="remarks" id="remarks" class="form-control" placeholder="Optional remarks">
            </div>
        </div>

        <div class="d-flex justify-content-between">
            <button type="reset" class="btn btn-secondary">Reset</button>
            <button type="submit" class="btn btn-primary">Log Task</button>
        </div>
    </form>
</div>

<!-- ✅ Stylish Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-center p-4">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold text-success" id="successModalLabel">✔ Task Added!</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <i class="fas fa-check-circle text-success fa-4x mb-3"></i> <!-- ✅ Check Icon -->
                <p class="fs-5 text-muted">The task has been successfully added.</p>
            </div>
            <div class="modal-footer border-0 d-flex justify-content-center">
                <button type="button" class="btn btn-success px-4 fw-bold" id="successModalOk">OK</button>
            </div>
        </div>
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
                // ✅ Show Success Modal
                let successModal = new bootstrap.Modal(document.getElementById('successModal'));
                successModal.show();

                // ✅ Redirect to Task Logs after clicking OK
                document.getElementById('successModalOk').addEventListener('click', function() {
                    window.location.href = "{{ route('tasks.index') }}";
                });

                // ✅ Reset the Form
                document.getElementById('taskForm').reset();
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
