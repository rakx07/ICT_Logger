@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Add New Staff</h1>
    <form action="{{ route('staff.store') }}" method="POST">
        @csrf
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="first_name" class="form-label">First Name</label>
                <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter first name" required>
            </div>
            <div class="col-md-4">
                <label for="middle_name" class="form-label">Middle Name</label>
                <input type="text" class="form-control" id="middle_name" name="middle_name" placeholder="Enter middle name (optional)">
            </div>
            <div class="col-md-4">
                <label for="last_name" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Enter last name" required>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter email address" required>
            </div>
            <div class="col-md-6">
                <label for="position" class="form-label">Position</label>
                <input type="text" class="form-control" id="position" name="position" placeholder="Enter position" required>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="phone_number" class="form-label">Phone Number</label>
                <input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="Enter phone number (optional)">
            </div>
            <div class="col-md-6">
                <label for="address" class="form-label">Address</label>
                <textarea class="form-control" id="address" name="address" rows="2" placeholder="Enter address (optional)"></textarea>
            </div>
        </div>
        <div class="d-flex justify-content-between">
            <button type="reset" class="btn btn-secondary">Reset</button>
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</div>
@endsection
