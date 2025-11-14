<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\MealLog;
use App\Models\MealItem;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class FoodDiary extends Component
{
    public $selectedDate;
    public $meals = [];
    public $nutritionTotals = [
        'calories' => 0,
        'protein' => 0,
        'carbs' => 0,
        'fat' => 0
    ];

    public $message = '';
    public $messageType = '';

    public function mount()
    {
        $this->selectedDate = today()->format('Y-m-d');
        $this->loadDiaryData();
    }

    public function loadDiaryData()
    {
        // Load meals for selected date with proper eager loading
        $mealLogs = MealLog::with(['mealItems.foodItem'])
            ->where('user_id', Auth::id())
            ->where('meal_date', $this->selectedDate)
            ->get();

        // Group by meal_type manually to avoid collection method issues
        $groupedMeals = [];
        foreach ($mealLogs as $meal) {
            if (!isset($groupedMeals[$meal->meal_type])) {
                $groupedMeals[$meal->meal_type] = [];
            }
            $groupedMeals[$meal->meal_type][] = $meal;
        }

        $this->meals = $groupedMeals;
        $this->calculateNutritionTotals();
    }

    public function calculateNutritionTotals()
    {
        $this->nutritionTotals = [
            'calories' => 0,
            'protein' => 0,
            'carbs' => 0,
            'fat' => 0
        ];

        foreach ($this->meals as $mealType => $mealLogs) {
            foreach ($mealLogs as $meal) {
                foreach ($meal->mealItems as $mealItem) {
                    $this->nutritionTotals['calories'] += $mealItem->calories;
                    $this->nutritionTotals['protein'] += $mealItem->protein_g;
                    $this->nutritionTotals['carbs'] += $mealItem->carbs_g;
                    $this->nutritionTotals['fat'] += $mealItem->fats_g;
                }
            }
        }

        // Round to whole numbers
        $this->nutritionTotals['calories'] = round($this->nutritionTotals['calories']);
        $this->nutritionTotals['protein'] = round($this->nutritionTotals['protein']);
        $this->nutritionTotals['carbs'] = round($this->nutritionTotals['carbs']);
        $this->nutritionTotals['fat'] = round($this->nutritionTotals['fat']);
    }

    public function updatedSelectedDate()
    {
        $this->loadDiaryData();
    }

    public function previousDay()
    {
        $this->selectedDate = Carbon::parse($this->selectedDate)->subDay()->format('Y-m-d');
        $this->loadDiaryData();
    }

    public function nextDay()
    {
        $this->selectedDate = Carbon::parse($this->selectedDate)->addDay()->format('Y-m-d');
        $this->loadDiaryData();
    }

    public function removeFoodItem($mealItemId)
    {
        try {
            $mealItem = MealItem::with('mealLog')->find($mealItemId);

            if ($mealItem && $mealItem->mealLog && $mealItem->mealLog->user_id === Auth::id()) {
                // Store the meal log ID before deletion
                $mealLogId = $mealItem->mealLog->id;

                // Delete the meal item
                $mealItem->delete();

                // Recalculate the meal log total calories
                $remainingItems = MealItem::where('meal_log_id', $mealLogId)->get();
                $totalCalories = $remainingItems->sum('calories');

                // Update the meal log
                MealLog::where('id', $mealLogId)->update(['total_calories' => $totalCalories]);

                // If no items left, delete the meal log
                if ($remainingItems->count() === 0) {
                    MealLog::where('id', $mealLogId)->delete();
                }

                // Reload the data without full page refresh
                $this->loadDiaryData();

                // Show success message using session flash
                session()->flash('message', 'Food item removed successfully!');
                session()->flash('messageType', 'success');

                // Emit event for JavaScript if needed
                $this->emit('foodItemRemoved');
            }
        } catch (\Exception $e) {
            session()->flash('message', 'Error removing food item: ' . $e->getMessage());
            session()->flash('messageType', 'error');
        }
    }

    public function getRemainingCalories()
    {
        $dailyGoal = 2000; // You can make this dynamic later
        return max(0, $dailyGoal - $this->nutritionTotals['calories']);
    }

    public function getCaloriesProgressPercentage()
    {
        $dailyGoal = 2000;
        if ($dailyGoal <= 0) return 0;
        return min(100, ($this->nutritionTotals['calories'] / $dailyGoal) * 100);
    }

    public function render()
    {
        return view('livewire.food-diary');
    }
}
