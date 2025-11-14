<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\MealLog;
use App\Models\FoodItem;
use App\Models\MealItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Carbon\Carbon;

class MealTracker extends Component
{
    public $meals = [];
    public $foodItems = [];
    public $showMealForm = false;
    public $showFoodSearch = false;
    public $selectedMealType = 'breakfast';
    public $searchQuery = '';
    public $selectedMealForFood = null;
    public $selectedFood = null;
    public $servings = 1;
    public $servingSize = 1;
    public $servingUnit = 'g';
    public $formattedDate = '';
    public $showSuccessNotification = false;
    public $successMessage = '';

    public $mealForm = [
        'meal_date' => '',
        'meal_type' => 'breakfast',
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
        $this->updateFormattedDate();
        $this->loadMeals();
        $this->loadFoodItems();
    }

    public function updateFormattedDate(): void
    {
        $this->formattedDate = Carbon::parse($this->mealForm['meal_date'])->format('l F j Y');
    }

    public function loadMeals(): void
    {
        $meals = MealLog::with(['mealItems.foodItem'])
            ->where('user_id', Auth::id())
            ->where('meal_date', $this->mealForm['meal_date'])
            ->orderBy('created_at', 'desc')
            ->get();

        $groupedMeals = [];
        foreach ($meals as $meal) {
            $groupedMeals[$meal->meal_type][] = $meal;
        }

        $this->meals = $groupedMeals;
    }

    public function loadFoodItems(): void
    {
        if (empty($this->searchQuery)) {
            $this->foodItems = FoodItem::orderBy('name')
                ->limit(50)
                ->get();
        } else {
            $this->foodItems = FoodItem::where('name', 'like', '%' . $this->searchQuery . '%')
                ->orWhere('brand', 'like', '%' . $this->searchQuery . '%')
                ->orderBy('name')
                ->limit(50)
                ->get();
        }
    }

    public function updatedSearchQuery(): void
    {
        $this->loadFoodItems();
        $this->selectedFood = null;
    }

    public function openFoodDetail(int $foodId, string $mealType): void
    {
        $this->selectedFood = FoodItem::find($foodId);
        $this->selectedMealType = $mealType;
        $this->servings = 1;
        $this->servingSize = $this->selectedFood->serving_qty ?? 1;
        $this->servingUnit = $this->selectedFood->serving_unit ?? 'g';
        $this->showFoodSearch = true;
    }

    public function selectFood($foodId): void
    {
        $this->selectedFood = FoodItem::find($foodId);
        $this->servings = 1;
    }

    public function addFoodToMeal(): void
    {
        if ($this->selectedFood) {
            // First create or find the meal log for the selected meal type and date
            $mealLog = MealLog::firstOrCreate(
                [
                    'user_id' => Auth::id(),
                    'meal_date' => today()->format('Y-m-d'),
                    'meal_type' => $this->selectedMealType,
                ],
                [
                    'total_calories' => 0
                ]
            );

            // Convert string inputs to float numbers
            $baseServingQty = floatval($this->selectedFood->serving_qty ?: 1);
            $customServingQty = floatval($this->servingSize);
            $servings = floatval($this->servings);

            // Convert between units if needed (simplified conversion)
            $conversionRatio = 1.0;
            if ($this->servingUnit === 'oz' && $this->selectedFood->serving_unit === 'g') {
                $conversionRatio = 28.35; // 1 oz = 28.35g
            } elseif ($this->servingUnit === 'g' && $this->selectedFood->serving_unit === 'oz') {
                $conversionRatio = 0.035; // 1g = 0.035 oz
            } elseif ($this->servingUnit === 'ml' && $this->selectedFood->serving_unit === 'g') {
                $conversionRatio = 1.0; // Rough estimate for water-based foods
            } elseif ($this->servingUnit === 'g' && $this->selectedFood->serving_unit === 'ml') {
                $conversionRatio = 1.0; // Rough estimate for water-based foods
            }

            $servingRatio = ($customServingQty * $conversionRatio) / $baseServingQty;

            $calories = floatval($this->selectedFood->calories) * $servingRatio * $servings;
            $protein = floatval($this->selectedFood->protein_g) * $servingRatio * $servings;
            $carbs = floatval($this->selectedFood->carbs_g) * $servingRatio * $servings;
            $fats = floatval($this->selectedFood->fats_g) * $servingRatio * $servings;

            // Add the food item to the meal
            MealItem::create([
                'meal_log_id' => $mealLog->id,
                'food_item_id' => $this->selectedFood->id,
                'quantity' => $servings,
                'serving_size' => $customServingQty,
                'serving_unit' => $this->servingUnit,
                'calories' => $calories,
                'protein_g' => $protein,
                'carbs_g' => $carbs,
                'fats_g' => $fats
            ]);

            // Update the meal's total calories
            $totalCalories = $mealLog->mealItems->sum('calories');
            $mealLog->update(['total_calories' => $totalCalories]);

            $this->closeFoodSearch();
            $this->loadMeals();

            // Show success notification
            if ($this->selectedFood) {
                $this->showSuccessNotification($this->selectedFood->name . ' added to ' . $this->selectedMealType . '!');
                session()->flash('message', $this->selectedFood->name . ' added to ' . $this->selectedMealType . '!');
            } else {
                $this->showSuccessNotification('Food added to ' . $this->selectedMealType . '!');
                session()->flash('message', 'Food added to ' . $this->selectedMealType . '!');
            }

            // Emit event to refresh dashboard
            $this->dispatch('mealUpdated');
        }
    }

    // Remove food item method
    public function removeFoodItem(int $mealItemId): void
    {
        $mealItem = MealItem::find($mealItemId);

        if ($mealItem) {
            $mealLog = $mealItem->mealLog;
            $mealItem->delete();

            if ($mealLog) {
                $totalCalories = $mealLog->mealItems->sum('calories');
                $mealLog->update(['total_calories' => $totalCalories]);
            }

            $this->loadMeals();

            // Show success notification
            $this->showSuccessNotification('Food item removed from meal!');

            // Emit event to refresh dashboard
            $this->dispatch('mealUpdated');

            session()->flash('message', 'Food item removed from meal!');
        }
    }

    // Delete meal method
    public function deleteMeal(int $mealId): void
    {
        $meal = MealLog::find($mealId);

        if ($meal) {
            $meal->mealItems()->delete();
            $meal->delete();

            $this->loadMeals();

            // Show success notification
            $this->showSuccessNotification('Meal deleted successfully!');

            // Emit event to refresh dashboard
            $this->dispatch('mealUpdated');

            session()->flash('message', 'Meal deleted successfully!');
        }
    }

    // New method to show success notification
    public function showSuccessNotification(string $message): void
    {
        $this->showSuccessNotification = true;
        $this->successMessage = $message;
    }

    public function getMacrosProperty()
    {
        if (!$this->selectedFood) {
            return null;
        }

        $total = floatval($this->selectedFood->protein_g) + floatval($this->selectedFood->carbs_g) + floatval($this->selectedFood->fats_g);

        if ($total == 0) {
            return [
                'protein' => ['percent' => 0, 'grams' => 0],
                'carbs' => ['percent' => 0, 'grams' => 0],
                'fat' => ['percent' => 0, 'grams' => 0]
            ];
        }

        return [
            'protein' => [
                'percent' => round((floatval($this->selectedFood->protein_g) / $total) * 100),
                'grams' => floatval($this->selectedFood->protein_g)
            ],
            'carbs' => [
                'percent' => round((floatval($this->selectedFood->carbs_g) / $total) * 100),
                'grams' => floatval($this->selectedFood->carbs_g)
            ],
            'fat' => [
                'percent' => round((floatval($this->selectedFood->fats_g) / $total) * 100),
                'grams' => floatval($this->selectedFood->fats_g)
            ]
        ];
    }

    public function getCalculatedNutritionProperty()
    {
        if (!$this->selectedFood) {
            return null;
        }

        // Convert string inputs to float numbers
        $baseServingQty = floatval($this->selectedFood->serving_qty ?: 1);
        $customServingQty = floatval($this->servingSize);
        $servings = floatval($this->servings);

        // Convert between units if needed
        $conversionRatio = 1.0;
        if ($this->servingUnit === 'oz' && $this->selectedFood->serving_unit === 'g') {
            $conversionRatio = 28.35;
        } elseif ($this->servingUnit === 'g' && $this->selectedFood->serving_unit === 'oz') {
            $conversionRatio = 0.035;
        } elseif ($this->servingUnit === 'ml' && $this->selectedFood->serving_unit === 'g') {
            $conversionRatio = 1.0;
        } elseif ($this->servingUnit === 'g' && $this->selectedFood->serving_unit === 'ml') {
            $conversionRatio = 1.0;
        }

        $servingRatio = ($customServingQty * $conversionRatio) / $baseServingQty;

        return [
            'calories' => floatval($this->selectedFood->calories) * $servingRatio * $servings,
            'protein' => floatval($this->selectedFood->protein_g) * $servingRatio * $servings,
            'carbs' => floatval($this->selectedFood->carbs_g) * $servingRatio * $servings,
            'fats' => floatval($this->selectedFood->fats_g) * $servingRatio * $servings,
        ];
    }

    public function closeFoodSearch(): void
    {
        $this->showFoodSearch = false;
        $this->selectedFood = null;
        $this->servings = 1;
        $this->servingSize = 1;
        $this->servingUnit = 'g';
        // Don't clear search query here - keep the search results visible
    }

    public function render(): View
    {
        return view('livewire.meal-tracker');
    }
}
