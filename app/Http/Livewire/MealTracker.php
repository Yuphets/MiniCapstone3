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
    public $meals = [];
    public $foodItems = [];
    public $showMealForm = false;
    public $showFoodSearch = false;
    public $selectedMealType = 'breakfast';
    public $searchQuery = '';
    public $selectedMealForFood = null;
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
        $meals = MealLog::with(['mealItems.foodItem'])
            ->where('user_id', Auth::id())
            ->where('meal_date', $this->mealForm['meal_date'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Convert to array but keep the Eloquent models for relationships
        $groupedMeals = [];
        foreach ($meals as $meal) {
            $groupedMeals[$meal->meal_type][] = $meal;
        }

        $this->meals = $groupedMeals;
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
     * Show food search modal for a specific meal
     *
     * @param int $mealId
     * @return void
     */
    public function openFoodSearch(int $mealId): void
    {
        \Log::info("openFoodSearch called with mealId: " . $mealId);
        $this->selectedMealForFood = $mealId;
        $this->showFoodSearch = true;
        $this->loadFoodItems();
    }

    /**
     * Add food item to a specific meal
     *
     * @return void
     */
    public function addFoodToMeal(): void
    {
        $foodItem = FoodItem::find($this->foodForm['food_item_id']);
        if ($foodItem && $this->selectedMealForFood) {
            // Calculate nutrition based on quantity
            $servingRatio = $this->foodForm['quantity'] / ($foodItem->serving_qty ?: 1);
            $calories = $foodItem->calories * $servingRatio;
            $protein = $foodItem->protein_g * $servingRatio;
            $carbs = $foodItem->carbs_g * $servingRatio;
            $fats = $foodItem->fats_g * $servingRatio;

            MealItem::create([
                'meal_log_id' => $this->selectedMealForFood,
                'food_item_id' => $foodItem->id,
                'quantity' => $this->foodForm['quantity'],
                'calories' => $calories,
                'protein_g' => $protein,
                'carbs_g' => $carbs,
                'fats_g' => $fats
            ]);

            // Update meal log total calories
            $mealLog = MealLog::find($this->selectedMealForFood);
            if ($mealLog) {
                $totalCalories = $mealLog->mealItems->sum('calories') + $calories;
                $mealLog->update(['total_calories' => $totalCalories]);
            }

            $this->resetFoodForm();
            $this->showFoodSearch = false;
            $this->selectedMealForFood = null;
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

    /**
     * Delete an entire meal
     *
     * @param int $mealId
     * @return void
     */
    public function deleteMeal(int $mealId): void
    {
        $meal = MealLog::find($mealId);
        if ($meal) {
            // Delete all associated meal items first
            $meal->mealItems()->delete();
            // Then delete the meal
            $meal->delete();
            $this->loadMeals();
            session()->flash('message', 'Meal deleted successfully!');
        }
    }

    public function closeFoodSearch(): void
    {
        $this->showFoodSearch = false;
        $this->selectedMealForFood = null;
        $this->resetFoodForm();
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
        return view('livewire.meal-tracker')
            ->layout('layouts.app');
    }
}
