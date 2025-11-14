<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\DailySummary;
use App\Models\WorkoutLog;
use App\Models\MealLog;
use App\Models\BodyMetric;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Component
{
    public $selectedDate;
    public $caloriesIn = 0;
    public $caloriesOut = 0;
    public $netCalories = 0;
    public $protein = 0;
    public $carbs = 0;
    public $fats = 0;
    public $currentWeight = 0;
    public $bmi = 0;

    public function mount()
    {
        $this->selectedDate = today()->format('Y-m-d');
        $this->loadDashboardData();
    }

    public function loadDashboardData()
    {
        $userId = Auth::id();
        if (!$userId) {
            return;
        }

        // Load daily summary
        $summary = DailySummary::where('user_id', $userId)
            ->where('summary_date', $this->selectedDate)
            ->first();

        if ($summary) {
            $this->caloriesIn = $summary->calories_in ?? 0;
            $this->caloriesOut = $summary->calories_out ?? 0;
            $this->netCalories = $summary->net_calories ?? 0;
        }

        // Load nutrition data
        try {
            $mealLogs = MealLog::with(['mealItems.foodItem'])
                ->where('user_id', $userId)
                ->where('meal_date', $this->selectedDate)
                ->get();

            $this->protein = $mealLogs->sum(function($meal) {
                return $meal->mealItems->sum('protein_g') ?? 0;
            });

            $this->carbs = $mealLogs->sum(function($meal) {
                return $meal->mealItems->sum('carbs_g') ?? 0;
            });

            $this->fats = $mealLogs->sum(function($meal) {
                return $meal->mealItems->sum('fats_g') ?? 0;
            });

        } catch (\Exception $e) {
            $this->protein = 0;
            $this->carbs = 0;
            $this->fats = 0;
        }

        // Load current metrics
        $latestMetric = BodyMetric::where('user_id', $userId)
            ->latest('measured_at')
            ->first();

        if ($latestMetric) {
            $this->currentWeight = $latestMetric->weight_kg ?? 0;
            $this->bmi = $latestMetric->bmi ?? 0;
        }
    }

    public function updatedSelectedDate()
    {
        $this->loadDashboardData();
    }

    public function render()
    {
        $userId = Auth::id();
        $today = $this->selectedDate;
        $stats = [
            'meals_logged' => MealLog::where('user_id', $userId)
                ->where('meal_date', $today)
                ->count(),
            'workouts_logged' => WorkoutLog::where('user_id', $userId)
                ->where('activity_date', $today)
                ->count(),
            'protein_consumed' => $this->protein,
        ];

        return view('livewire.dashboard', compact('stats'))
            ->layout('layouts.app');
    }
}
