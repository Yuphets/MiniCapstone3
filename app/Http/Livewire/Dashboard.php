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

    // Add these properties for goals
    public $calorieGoal = 2000;
    public $proteinGoal = 150;
    public $carbsGoal = 250;
    public $fatsGoal = 70;

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

        // Load nutrition data from meal logs
        $this->loadNutritionData($userId);

        // Load current metrics
        $latestMetric = BodyMetric::where('user_id', $userId)
            ->latest('measured_at')
            ->first();

        if ($latestMetric) {
            $this->currentWeight = $latestMetric->weight_kg ?? 0;
            $this->bmi = $latestMetric->bmi ?? 0;
        }
    }

    private function loadNutritionData($userId)
    {
        try {
            $mealLogs = MealLog::with(['mealItems.foodItem'])
                ->where('user_id', $userId)
                ->where('meal_date', $this->selectedDate)
                ->get();

            // Reset values
            $this->protein = 0;
            $this->carbs = 0;
            $this->fats = 0;
            $this->caloriesIn = 0;

            foreach ($mealLogs as $meal) {
                foreach ($meal->mealItems as $item) {
                    $this->protein += $item->protein_g ?? 0;
                    $this->carbs += $item->carbs_g ?? 0;
                    $this->fats += $item->fats_g ?? 0;
                    $this->caloriesIn += $item->calories ?? 0;
                }
            }

            // Update or create daily summary
            DailySummary::updateOrCreate(
                [
                    'user_id' => $userId,
                    'summary_date' => $this->selectedDate
                ],
                [
                    'calories_in' => $this->caloriesIn,
                    'calories_out' => $this->caloriesOut,
                    'net_calories' => $this->caloriesIn - $this->caloriesOut,
                    'protein_g' => $this->protein,
                    'carbs_g' => $this->carbs,
                    'fats_g' => $this->fats,
                ]
            );

        } catch (\Exception $e) {
            // If there are database issues, set defaults
            $this->protein = 0;
            $this->carbs = 0;
            $this->fats = 0;
            $this->caloriesIn = 0;
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

        return view('livewire.dashboard', compact('stats'));
    }
}
