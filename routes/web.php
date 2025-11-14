<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Livewire\Dashboard;
use App\Http\Livewire\WorkoutTracker;
use App\Http\Livewire\MealTracker;
use App\Http\Livewire\ProgressTracker;
use Illuminate\Support\Facades\Auth;

// Home route
Route::get('/', function () {
    if (Auth::check()) {
        if (Auth::user()->is_admin) {
            return redirect('/admin/dashboard');
        }
        return redirect('/dashboard');
    }
    return view('welcome');
})->name('home');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Protected Routes - Regular Users
Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/workouts', WorkoutTracker::class)->name('workouts');
    Route::get('/meals', MealTracker::class)->name('meals');
    Route::get('/progress', ProgressTracker::class)->name('progress');
});

// Admin Routes - WITHOUT the problematic admin middleware
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/activity-logs', [AdminController::class, 'activityLogs'])->name('activity-logs');
    Route::get('/exercise-data', [AdminController::class, 'exerciseData'])->name('exercise-data');
    Route::get('/nutrition-data', [AdminController::class, 'nutritionData'])->name('nutrition-data');
    Route::get('/reports', [AdminController::class, 'generateReports'])->name('reports');

    // User management
    Route::get('/users/{id}/manage', [AdminController::class, 'manageUser'])->name('users.manage');
    Route::post('/users/{id}/manage', [AdminController::class, 'manageUser']);
    Route::delete('/users/{id}', [AdminController::class, 'deleteUser'])->name('users.delete');

    // Activity management
    Route::get('/activities/create', [AdminController::class, 'createActivity'])->name('activities.create');
    Route::post('/activities/create', [AdminController::class, 'createActivity']);
    Route::delete('/activities/{id}', [AdminController::class, 'deleteActivity'])->name('activities.delete');

    // Food item management
    Route::get('/food-items/create', [AdminController::class, 'createFoodItem'])->name('food-items.create');
    Route::post('/food-items/create', [AdminController::class, 'createFoodItem']);
    Route::delete('/food-items/{id}', [AdminController::class, 'deleteFoodItem'])->name('food-items.delete');
});
