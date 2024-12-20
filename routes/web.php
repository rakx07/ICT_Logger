<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\StaffController;

// Redirect the root URL to the task logs page
Route::get('/', function () {
    return redirect()->route('tasks.index');
});

// Resource routes for TaskController and StaffController
Route::resource('tasks', TaskController::class);
Route::resource('staff', StaffController::class);

// Specific routes for TaskController
Route::get('/tasks/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');

// Specific routes for StaffController
Route::get('/staff/{staff}/edit', [StaffController::class, 'edit'])->name('staff.edit');
Route::put('/staff/{staff}', [StaffController::class, 'update'])->name('staff.update');
Route::delete('/staff/{staff}', [StaffController::class, 'destroy'])->name('staff.destroy');
