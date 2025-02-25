<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\AdminMiddleware; // Import the Admin Middleware

// Redirect the root URL to the task logs page
Route::get('/', function () {
    return redirect()->route('tasks.index');
});

// Authentication routes
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// Password reset routes
Route::get('password/reset', [AuthController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');


//Register Control Purposes
Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('register', [AuthController::class, 'register']);



// Registration routes (Only Admin can access)
Route::middleware(['auth', AdminMiddleware::class])->group(function () {
    // Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
    // Route::post('register', [AuthController::class, 'register']);

});

// Protected routes (only accessible when logged in)
Route::middleware('auth')->group(function () {

    // Task routes: accessible to both admins and regular users
    Route::get('tasks', [TaskController::class, 'index'])->name('tasks.index');
    Route::get('tasks/create', [TaskController::class, 'create'])->name('tasks.create'); // Allowed for both roles
    Route::post('tasks', [TaskController::class, 'store'])->name('tasks.store'); // Allowed for both roles
    Route::get('tasks/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit'); // Allowed for both roles
    Route::put('tasks/{task}', [TaskController::class, 'update'])->name('tasks.update'); // Allowed for both roles
    Route::post('/tasks/{task}/update-status', [TaskController::class, 'updateStatus'])->name('tasks.update-status'); // Allowed for both roles

    // Task deletion (Only Admins can delete tasks)
    Route::delete('tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy')->middleware(AdminMiddleware::class);

    // Staff routes (Only Admins can manage users)
    Route::middleware(AdminMiddleware::class)->group(function () {
        Route::get('staff', [StaffController::class, 'index'])->name('staff.index');
        Route::get('staff/create', [StaffController::class, 'create'])->name('staff.create');
        Route::post('staff', [StaffController::class, 'store'])->name('staff.store');
        Route::get('staff/{staff}/edit', [StaffController::class, 'edit'])->name('staff.edit');
        Route::put('staff/{staff}', [StaffController::class, 'update'])->name('staff.update');
        Route::delete('staff/{staff}', [StaffController::class, 'destroy'])->name('staff.destroy');
    });

    // Home route
    Route::get('/home', function () {
        return view('users.home');
    })->name('user.home');
});
