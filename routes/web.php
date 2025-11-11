<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Livewire\Dashboard;
use App\Http\Livewire\WorkoutTracker;
use App\Http\Livewire\MealTracker;
use App\Http\Livewire\ProgressTracker;

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Redirect root to login
Route::get('/', function () {
    return redirect('/login');
});

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Test routes
Route::get('/test-simple', function () {
    return 'Basic routing test - working!';
});

Route::get('/test-view', function () {
    return view('simple-test');
});

// Protected Routes
Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/workouts', WorkoutTracker::class)->name('workouts');
    Route::get('/meals', MealTracker::class)->name('meals');
    Route::get('/progress', ProgressTracker::class)->name('progress');

    // Redirect / to dashboard for authenticated users
    Route::get('/', function () {
        return redirect('/dashboard');
    });
});
