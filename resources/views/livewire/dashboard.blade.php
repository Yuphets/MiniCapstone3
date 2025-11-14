<div>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-2xl font-bold text-gray-900 mb-6">Dashboard</h1>

            <!-- Stats Overview -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-medium text-gray-900">Meals Logged Today</h3>
                    <p class="text-2xl font-bold text-primary">{{ $stats['meals_logged'] ?? 0 }}</p>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-medium text-gray-900">Workouts Logged Today</h3>
                    <p class="text-2xl font-bold text-primary">{{ $stats['workouts_logged'] ?? 0 }}</p>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-medium text-gray-900">Protein Consumed</h3>
                    <p class="text-2xl font-bold text-primary">{{ $stats['protein_consumed'] ?? 0 }}g</p>
                </div>
            </div>

            <!-- Date Selector -->
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <label for="selectedDate" class="block text-sm font-medium text-gray-700 mb-2">
                    Select Date
                </label>
                <input type="date"
                       wire:model="selectedDate"
                       class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary">
            </div>

            <!-- Nutrition Overview -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Calories</h3>
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span>Calories In:</span>
                            <span class="font-medium">{{ $caloriesIn }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Calories Out:</span>
                            <span class="font-medium">{{ $caloriesOut }}</span>
                        </div>
                        <div class="flex justify-between border-t pt-2">
                            <span class="font-medium">Net Calories:</span>
                            <span class="font-medium {{ $netCalories < 0 ? 'text-green-600' : 'text-red-600' }}">
                                {{ $netCalories }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Macronutrients</h3>
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span>Protein:</span>
                            <span class="font-medium">{{ $protein }}g</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Carbs:</span>
                            <span class="font-medium">{{ $carbs }}g</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Fats:</span>
                            <span class="font-medium">{{ $fats }}g</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Current Metrics -->
            <div class="bg-white rounded-lg shadow p-6 mt-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Current Metrics</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="flex justify-between">
                        <span>Current Weight:</span>
                        <span class="font-medium">{{ $currentWeight }} kg</span>
                    </div>
                    <div class="flex justify-between">
                        <span>BMI:</span>
                        <span class="font-medium">{{ $bmi }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
