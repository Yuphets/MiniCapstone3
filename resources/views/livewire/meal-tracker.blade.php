<div class="px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Meals</h1>
        <button wire:click="startMealLog"
                class="bg-green-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-green-700 transition duration-200">
            + Add Meal
        </button>
    </div>

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
                                        <div>
                                            <p class="text-gray-600">{{ $meal->meal_date->format('M j, Y') }}</p>
                                            @if($meal->notes)
                                                <p class="text-gray-500 mt-1">{{ $meal->notes }}</p>
                                            @endif
                                            @if($meal->mealItems->count() > 0)
                                                <div class="mt-2">
                                                    <p class="text-sm font-medium">Food Items:</p>
                                                    <ul class="text-sm text-gray-600">
                                                        @foreach($meal->mealItems as $item)
                                                            <li>{{ $item->foodItem->name }} - {{ $item->quantity }} serving(s)</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="text-right">
                                            <p class="font-semibold">{{ number_format($meal->total_calories) }} calories</p>
                                            <button wire:click="$set('showFoodSearch', true)"
                                                    class="text-blue-600 hover:text-blue-800 text-sm mt-2">
                                                Add Food
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
