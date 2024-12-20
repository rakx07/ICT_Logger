<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;

// Redirect the root URL to the task logs page
Route::get('/', function () {
    return redirect()->route('tasks.index');
});

// Resource routes for TaskController and StaffController
Route::resource('tasks', TaskController::class);
Route::resource('staff', StaffController::class);

// Authentication routes
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// Password reset routes
Route::get('password/reset', [AuthController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');

// Protected routes
Route::middleware('auth')->group(function () {
    Route::get('/home', function () {
        return view('home');
    });
});
