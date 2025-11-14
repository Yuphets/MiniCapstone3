<div class="min-h-screen bg-gray-50 pb-20">
    <!-- Header - Matching Progress Tracker exactly -->
    <div class="max-w-6xl mx-auto mb-6 md:mb-8 pt-4">
        <h2 class="text-2xl md:text-3xl font-bold text-[#1C7C6E] mb-1 flex items-center justify-center md:justify-start gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 md:w-7 md:h-7 text-[#1C7C6E]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
            </svg>
            Food Diary
        </h2>
        <p class="text-gray-500 text-center md:text-left">Track your daily nutrition journey</p>
    </div>

    <!-- Flash Messages -->
    @if ($message)
        <div class="mb-4 rounded text-sm px-4 py-3
            @if($messageType === 'error')
                bg-red-100 border border-red-400 text-red-700
            @else
                bg-green-100 border border-green-400 text-green-700
            @endif"
            x-data="{ show: true }"
            x-show="show"
            x-init="setTimeout(() => { show = false; $wire.set('message', ''); }, 5000)"
            x-transition>
            {{ $message }}
        </div>
    @endif

    <!-- Main Content -->
    <div class="px-4">
        <!-- Date Selector -->
        <div class="flex items-center justify-between mb-4">
            <button wire:click="previousDay"
                    wire:loading.attr="disabled"
                    class="text-gray-600 p-2 hover:bg-gray-100 rounded-lg transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </button>

            <div class="text-center font-medium text-gray-900 relative">
                {{ \Carbon\Carbon::parse($selectedDate)->format('M j, Y') }}
                <input type="date"
                       wire:model="selectedDate"
                       class="absolute opacity-0 w-full h-full top-0 left-0 cursor-pointer"
                       wire:change="$refresh">
            </div>

            <button wire:click="nextDay"
                    wire:loading.attr="disabled"
                    class="text-gray-600 p-2 hover:bg-gray-100 rounded-lg transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>
        </div>
    </div>

    <!-- Loading Indicator -->
    <div wire:loading class="fixed top-0 left-0 right-0 bg-blue-500 text-white py-2 text-center z-50">
        Loading...
    </div>

    <!-- Nutrition Summary -->
    <div class="bg-white border-b border-gray-200">
        <div class="px-4 py-4">
            <div class="grid grid-cols-4 gap-4 text-center">
                <div>
                    <div class="text-2xl font-bold text-gray-900">{{ $nutritionTotals['calories'] }}</div>
                    <div class="text-xs text-gray-500">Calories</div>
                </div>
                <div>
                    <div class="text-2xl font-bold text-gray-900">{{ $nutritionTotals['carbs'] }}g</div>
                    <div class="text-xs text-gray-500">Carbs</div>
                </div>
                <div>
                    <div class="text-2xl font-bold text-gray-900">{{ $nutritionTotals['protein'] }}g</div>
                    <div class="text-xs text-gray-500">Protein</div>
                </div>
                <div>
                    <div class="text-2xl font-bold text-gray-900">{{ $nutritionTotals['fat'] }}g</div>
                    <div class="text-xs text-gray-500">Fat</div>
                </div>
            </div>

            <!-- Remaining Calories -->
            <div class="mt-4 bg-blue-50 rounded-lg p-3">
                <div class="flex justify-between items-center">
                    <span class="text-sm font-medium text-blue-900">Remaining</span>
                    <span class="text-lg font-bold text-blue-900">{{ $this->getRemainingCalories() }}</span>
                </div>
                <div class="w-full bg-blue-200 rounded-full h-2 mt-2">
                    <div class="bg-blue-600 h-2 rounded-full transition-all duration-300"
                         style="width: {{ $this->getCaloriesProgressPercentage() }}%"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Meal Sections -->
    <div class="space-y-1" wire:loading.remove>
        @foreach(['breakfast' => 'Breakfast', 'lunch' => 'Lunch', 'dinner' => 'Dinner', 'snack' => 'Snacks'] as $mealType => $mealName)
        <div class="bg-white border-b border-gray-200">
            <!-- Meal Header -->
            <div class="px-4 py-3 border-b border-gray-100">
                <div class="flex justify-between items-center">
                    <h3 class="font-semibold text-gray-900">{{ $mealName }}</h3>
                    <span class="text-sm text-gray-500">
                        @php
                            $mealCalories = 0;
                            if(isset($meals[$mealType])) {
                                foreach($meals[$mealType] as $meal) {
                                    $mealCalories += $meal->total_calories;
                                }
                            }
                            echo number_format($mealCalories);
                        @endphp cal
                    </span>
                </div>
            </div>

            <!-- Food Items -->
            <div class="px-4">
                @if(isset($meals[$mealType]) && count($meals[$mealType]) > 0)
                    @foreach($meals[$mealType] as $meal)
                        @foreach($meal->mealItems as $item)
                        <div class="py-3 border-b border-gray-100 last:border-b-0 transition-all duration-300"
                             wire:key="meal-item-{{ $item->id }}-{{ $selectedDate }}">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <div class="font-medium text-gray-900 text-sm">{{ $item->foodItem->name }}</div>
                                    <div class="text-xs text-gray-500 mt-1">
                                        {{ $item->quantity }} x {{ $item->foodItem->serving_qty }}{{ $item->foodItem->serving_unit }}
                                        @if($item->foodItem->brand)
                                            • {{ $item->foodItem->brand }}
                                        @endif
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="font-semibold text-gray-900">{{ number_format($item->calories) }}</div>
                                    <div class="text-xs text-gray-500">calories</div>
                                </div>
                            </div>

                            <!-- Nutrition Details -->
                            <div class="flex justify-between items-center mt-2 text-xs text-gray-500">
                                <span>P: {{ number_format($item->protein_g) }}g</span>
                                <span>C: {{ number_format($item->carbs_g) }}g</span>
                                <span>F: {{ number_format($item->fats_g) }}g</span>
                                <button wire:click="removeFoodItem({{ $item->id }})"
                                        wire:loading.attr="disabled"
                                        onclick="return confirm('Are you sure you want to remove this food item?')"
                                        class="text-red-500 hover:text-red-700 text-xs transition">
                                    <span wire:loading.remove wire:target="removeFoodItem({{ $item->id }})">Remove</span>
                                    <span wire:loading wire:target="removeFoodItem({{ $item->id }})">Removing...</span>
                                </button>
                            </div>
                        </div>
                        @endforeach
                    @endforeach
                @else
                    <div class="py-8 text-center">
                        <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-2">
                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                        </div>
                        <p class="text-gray-500 text-sm">No foods logged</p>
                        <a href="{{ route('meals') }}"
                           class="text-green-600 text-sm font-medium mt-1 inline-block hover:text-green-700">
                            Add Food
                        </a>
                    </div>
                @endif
            </div>
        </div>
        @endforeach
    </div>

    <!-- Loading State for Meals -->
    <div wire:loading class="space-y-1">
        @foreach(['breakfast' => 'Breakfast', 'lunch' => 'Lunch', 'dinner' => 'Dinner', 'snack' => 'Snacks'] as $mealType => $mealName)
        <div class="bg-white border-b border-gray-200 animate-pulse">
            <div class="px-4 py-3 border-b border-gray-100">
                <div class="flex justify-between items-center">
                    <div class="h-4 bg-gray-200 rounded w-24"></div>
                    <div class="h-3 bg-gray-200 rounded w-12"></div>
                </div>
            </div>
            <div class="px-4 py-6">
                <div class="h-3 bg-gray-200 rounded w-full mb-2"></div>
                <div class="h-3 bg-gray-200 rounded w-3/4"></div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<script>
document.addEventListener('livewire:load', function () {
    // Listen for food added events from quick add modal
    Livewire.on('foodAdded', () => {
        // The component will automatically refresh due to the listener
        console.log('Food added, refreshing diary...');
    });
});
</script>
