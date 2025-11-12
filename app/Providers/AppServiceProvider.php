<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use App\Http\Livewire\WorkoutTracker;
use App\Http\Livewire\MealTracker;

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
        Livewire::component('workout-tracker', WorkoutTracker::class);
        Livewire::component('meal-tracker', MealTracker::class);
    }
}
