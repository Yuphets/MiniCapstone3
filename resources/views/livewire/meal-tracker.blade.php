<div class="px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Meals</h1>
        <button wire:click="startMealLog"
                class="bg-green-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-green-700 transition duration-200">
            + Add Meal
        </button>
    </div>

    @if (session('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('message') }}
        </div>
    @endif

    <!-- Meal Form -->
    @if($showMealForm)
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <h2 class="text-lg font-semibold mb-4">Add Meal</h2>

        <form wire:submit.prevent="saveMealLog">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Meal Type</label>
                    <select wire:model="mealForm.meal_type" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="breakfast">Breakfast</option>
                        <option value="lunch">Lunch</option>
                        <option value="dinner">Dinner</option>
                        <option value="snack">Snack</option>
                        <option value="other">Other</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                    <input type="date" wire:model="mealForm.meal_date"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                <textarea wire:model="mealForm.notes" rows="2"
                          class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                          placeholder="Any notes about your meal..."></textarea>
            </div>

            <div class="flex space-x-3">
                <button type="submit"
                        class="bg-blue-600 text-white px-6 py-2 rounded-lg font-medium hover:bg-blue-700 transition duration-200">
                    Save Meal
                </button>
                <button type="button" wire:click="$set('showMealForm', false)"
                        class="bg-gray-500 text-white px-6 py-2 rounded-lg font-medium hover:bg-gray-600 transition duration-200">
                    Cancel
                </button>
            </div>
        </form>
    </div>
    @endif

    <!-- Food Search Modal -->
    @if($showFoodSearch)
    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full max-h-[90vh] overflow-y-auto">
            <div class="p-6">
                <h2 class="text-lg font-semibold mb-4">Add Food Item</h2>
                
                <!-- Search -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Search Food</label>
                    <input type="text" wire:model="searchQuery" 
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="Search for food items...">
                </div>

                <!-- Food Items List -->
                <div class="mb-4 max-h-60 overflow-y-auto">
                    @foreach($foodItems as $food)
                        <div class="flex items-center justify-between p-3 border-b border-gray-200 hover:bg-gray-50">
                            <div>
                                <p class="font-medium">{{ $food->name }}</p>
                                <p class="text-sm text-gray-600">{{ $food->calories }} cal • {{ $food->serving_qty }} {{ $food->serving_unit }}</p>
                            </div>
                            <button wire:click="$set('foodForm.food_item_id', {{ $food->id }})"
                                    class="bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700">
                                Select
                            </button>
                        </div>
                    @endforeach
                    
                    @if(count($foodItems) === 0)
                        <p class="text-gray-500 text-center py-4">No food items found.</p>
                    @endif
                </div>

                <!-- Quantity and Add Button -->
                @if($foodForm['food_item_id'])
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Quantity</label>
                        <input type="number" wire:model="foodForm.quantity" min="0.1" step="0.1"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div class="flex space-x-3">
                        <button wire:click="addFoodToMeal"
                                class="bg-green-600 text-white px-6 py-2 rounded-lg font-medium hover:bg-green-700 transition duration-200">
                            Add to Meal
                        </button>
                        <button wire:click="closeFoodSearch"
                                class="bg-gray-500 text-white px-6 py-2 rounded-lg font-medium hover:bg-gray-600 transition duration-200">
                            Cancel
                        </button>
                    </div>
                @else
                    <div class="flex justify-end">
                        <button wire:click="closeFoodSearch"
                                class="bg-gray-500 text-white px-6 py-2 rounded-lg font-medium hover:bg-gray-600 transition duration-200">
                            Close
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>
    @endif

    <!-- Meals List -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h3 class="text-lg font-semibold mb-4">Today's Meals</h3>

        @if(count($meals) > 0)
            <div class="space-y-6">
                @foreach($meals as $mealType => $mealLogs)
                    <div>
                        <h4 class="font-semibold text-lg capitalize mb-3">{{ $mealType }}</h4>
                        <div class="space-y-3">
                            @foreach($mealLogs as $meal)
                                <div class="border border-gray-200 rounded-lg p-4">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <div class="flex justify-between items-start mb-2">
                                                <p class="text-gray-600">{{ $meal->meal_date->format('M j, Y') }}</p>
                                                <button wire:click="deleteMeal({{ $meal->id }})" 
                                                        class="text-red-600 hover:text-red-800 text-sm"
                                                        onclick="return confirm('Are you sure you want to delete this entire meal?')">
                                                    Delete Meal
                                                </button>
                                            </div>
                                            
                                            @if($meal->notes)
                                                <p class="text-gray-500 mt-1">{{ $meal->notes }}</p>
                                            @endif
                                            
                                            @if($meal->mealItems->count() > 0)
                                                <div class="mt-2">
                                                    <p class="text-sm font-medium mb-1">Food Items:</p>
                                                    <ul class="text-sm text-gray-600 space-y-1">
                                                        @foreach($meal->mealItems as $item)
                                                            <li class="flex justify-between items-center">
                                                                <span>{{ $item->foodItem->name }} - {{ $item->quantity }} serving(s) • {{ number_format($item->calories) }} cal</span>
                                                                <button wire:click="removeFoodItem({{ $item->id }})" 
                                                                        class="text-red-600 hover:text-red-800 text-xs ml-2"
                                                                        onclick="return confirm('Remove this food item?')">
                                                                    Remove
                                                                </button>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @else
                                                <p class="text-gray-400 text-sm mt-2">No food items added yet.</p>
                                            @endif
                                        </div>
                                        <div class="text-right ml-4">
                                            <p class="font-semibold">{{ number_format($meal->total_calories) }} calories</p>
                                            <button wire:click="openFoodSearch({{ $meal->id }})"
                                                    class="text-blue-600 hover:text-blue-800 text-sm mt-2">
                                                + Add Food
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500 text-center py-8">No meals logged today.</p>
        @endif
    </div>
</div>