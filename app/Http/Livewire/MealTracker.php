<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\MealLog;
use App\Models\FoodItem;
use App\Models\MealItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class MealTracker extends Component
{
    protected $layout = 'layouts.app';

    public $meals = [];
    public $foodItems = [];
    public $showMealForm = false;
    public $showFoodSearch = false;
    public $selectedMealType = 'breakfast';
    public $searchQuery = '';

    public $mealForm = [
        'meal_date' => '',
        'meal_type' => 'breakfast',
        'notes' => ''
    ];

    public $foodForm = [
        'food_item_id' => '',
        'quantity' => 1
    ];

    protected $rules = [
        'mealForm.meal_date' => 'required|date',
        'mealForm.meal_type' => 'required|in:breakfast,lunch,dinner,snack,other',
    ];

    public function mount(): void
    {
        $this->mealForm['meal_date'] = today()->format('Y-m-d');
        $this->loadMeals();
        $this->loadFoodItems();
    }

    public function loadMeals(): void
    {
        $this->meals = MealLog::with(['mealItems.foodItem'])
            ->where('user_id', Auth::id())
            ->where('meal_date', $this->mealForm['meal_date'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('meal_type');
    }

    public function loadFoodItems(): void
    {
        $query = FoodItem::query();

        if ($this->searchQuery) {
            $query->where('name', 'like', '%' . $this->searchQuery . '%')
                  ->orWhere('brand', 'like', '%' . $this->searchQuery . '%');
        }

        $this->foodItems = $query->limit(20)->get();
    }

    public function startMealLog(): void
    {
        $this->showMealForm = true;
        $this->mealForm['meal_type'] = $this->selectedMealType;
    }

    public function saveMealLog(): void
    {
        $this->validate();

        $mealLog = MealLog::create([
            'user_id' => Auth::id(),
            'meal_date' => $this->mealForm['meal_date'],
            'meal_type' => $this->mealForm['meal_type'],
            'notes' => $this->mealForm['notes']
        ]);

        $this->showMealForm = false;
        $this->resetMealForm();
        $this->loadMeals();

        session()->flash('message', 'Meal logged successfully!');
    }

    /**
     * Add food item to a specific meal
     *
     * @param int $mealLogId
     * @return void
     */
    public function addFoodToMeal(int $mealLogId): void
    {
        $foodItem = FoodItem::find($this->foodForm['food_item_id']);

        if ($foodItem && $mealLogId) {
            // Calculate nutrition based on quantity
            $servingRatio = $this->foodForm['quantity'] / $foodItem->serving_qty;

            $calories = $foodItem->calories * $servingRatio;
            $protein = $foodItem->protein_g * $servingRatio;
            $carbs = $foodItem->carbs_g * $servingRatio;
            $fats = $foodItem->fats_g * $servingRatio;

            MealItem::create([
                'meal_log_id' => $mealLogId,
                'food_item_id' => $foodItem->id,
                'quantity' => $this->foodForm['quantity'],
                'calories' => $calories,
                'protein_g' => $protein,
                'carbs_g' => $carbs,
                'fats_g' => $fats
            ]);

            // Update meal log total calories
            $mealLog = MealLog::find($mealLogId);
            if ($mealLog) {
                $totalCalories = $mealLog->mealItems->sum('calories') + $calories;
                $mealLog->update(['total_calories' => $totalCalories]);
            }

            $this->resetFoodForm();
            $this->showFoodSearch = false;
            $this->loadMeals();

            session()->flash('message', 'Food item added to meal!');
        }
    }

    /**
     * Remove a food item from a meal
     *
     * @param int $mealItemId
     * @return void
     */
    public function removeFoodItem(int $mealItemId): void
    {
        $mealItem = MealItem::find($mealItemId);

        if ($mealItem) {
            // Get the meal log before deletion to update totals
            $mealLog = $mealItem->mealLog;
            $mealItem->delete();

            // Recalculate total calories for the meal
            if ($mealLog) {
                $totalCalories = $mealLog->mealItems->sum('calories');
                $mealLog->update(['total_calories' => $totalCalories]);
            }

            $this->loadMeals();
            session()->flash('message', 'Food item removed from meal!');
        }
    }

    private function resetMealForm(): void
    {
        $this->mealForm = [
            'meal_date' => today()->format('Y-m-d'),
            'meal_type' => 'breakfast',
            'notes' => ''
        ];
    }

    private function resetFoodForm(): void
    {
        $this->foodForm = [
            'food_item_id' => '',
            'quantity' => 1
        ];
        $this->searchQuery = '';
    }

    public function updatedSearchQuery(): void
    {
        $this->loadFoodItems();
    }

    public function updatedMealFormMealDate(): void
    {
        $this->loadMeals();
    }

    public function render(): View
    {
        return view('livewire.meal-tracker');
    }
}
