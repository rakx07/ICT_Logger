<!-- resources/views/users/home.blade.php -->

@extends('layouts.app')  <!-- Extend the main layout -->

@section('content')  <!-- Define the content section -->

    <div class="container mt-4">
        <h1>Welcome to Your Home Page, {{ auth()->user()->name }}!</h1>
        <p>This is your user home page.</p>
    </div>

@endsection  <!-- End content section -->
