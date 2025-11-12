<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Livewire\Dashboard;
use App\Http\Livewire\WorkoutTracker;
use App\Http\Livewire\MealTracker;
use App\Http\Livewire\ProgressTracker;
use Illuminate\Support\Facades\Auth;

// Single route for home that handles both cases
Route::get('/', function () {
    if (Auth::check()) {
        return redirect('/dashboard');
    }
    return view('welcome');
})->name('home');

Route::get('/workouts', function () {
    return view('your-workouts-view'); // Make sure this view exists
})->middleware(['auth']); // or whatever middleware you're using
// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Protected Routes
Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/workouts', WorkoutTracker::class)->name('workouts');
    Route::get('/meals', MealTracker::class)->name('meals');
    Route::get('/progress', ProgressTracker::class)->name('progress');
});