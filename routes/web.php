<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\StaffController;

// Redirect the root URL to the task logs page
Route::get('/', function () {
    return redirect()->route('tasks.index');
});

// Resource routes for the TaskController
Route::resource('tasks', TaskController::class);
Route::resource('staff', StaffController::class);