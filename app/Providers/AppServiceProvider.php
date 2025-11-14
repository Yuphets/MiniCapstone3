<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register Livewire components
        Livewire::component('dashboard', \App\Http\Livewire\Dashboard::class);
        Livewire::component('workout-tracker', \App\Http\Livewire\WorkoutTracker::class);
        Livewire::component('meal-tracker', \App\Http\Livewire\MealTracker::class);
        Livewire::component('progress-tracker', \App\Http\Livewire\ProgressTracker::class);
    }
}
