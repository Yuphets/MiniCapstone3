<div class="px-4 py-6">
    <h1 class="text-2xl font-bold text-gray-900 mb-6">Dashboard</h1>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow-sm p-4 text-center">
            <div class="text-2xl font-bold text-green-600">{{ $stats['meals_logged'] ?? 0 }}</div>
            <div class="text-sm text-gray-600">Meals Today</div>
        </div>
        <div class="bg-white rounded-lg shadow-sm p-4 text-center">
            <div class="text-2xl font-bold text-blue-600">{{ $stats['workouts_logged'] ?? 0 }}</div>
            <div class="text-sm text-gray-600">Workouts</div>
        </div>
        <div class="bg-white rounded-lg shadow-sm p-4 text-center">
            <div class="text-2xl font-bold text-purple-600">{{ $stats['protein_consumed'] ?? 0 }}g</div>
            <div class="text-sm text-gray-600">Protein</div>
        </div>
    </div>

    <!-- Calories Card -->
    <div class="bg-white rounded-lg shadow-sm p-4 mb-4">
        <h3 class="text-lg font-semibold mb-3">Calories</h3>
        <div class="space-y-3">
            <div class="flex justify-between items-center">
                <span class="text-gray-600">Consumed</span>
                <span class="font-semibold">{{ number_format($caloriesIn) }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-gray-600">Burned</span>
                <span class="font-semibold text-red-600">{{ number_format($caloriesOut) }}</span>
            </div>
            <div class="flex justify-between items-center border-t pt-2">
                <span class="text-gray-600 font-semibold">Net Calories</span>
                <span class="font-bold {{ $netCalories >= 0 ? 'text-green-600' : 'text-red-600' }}">
                    {{ number_format($netCalories) }}
                </span>
            </div>
        </div>
    </div>

    <!-- Current Metrics -->
    <div class="bg-white rounded-lg shadow-sm p-4 mb-4">
        <h3 class="text-lg font-semibold mb-3">Current Metrics</h3>
        <div class="grid grid-cols-2 gap-4">
            <div class="text-center">
                <div class="text-lg font-bold text-gray-900">{{ $currentWeight ? number_format($currentWeight, 1) : 'N/A' }} kg</div>
                <div class="text-sm text-gray-600">Weight</div>
            </div>
            <div class="text-center">
                <div class="text-lg font-bold text-gray-900">{{ $bmi ? number_format($bmi, 1) : 'N/A' }}</div>
                <div class="text-sm text-gray-600">BMI</div>
            </div>
        </div>
    </div>

    <!-- Nutrition Summary -->
    <div class="bg-white rounded-lg shadow-sm p-4 mb-4">
        <h3 class="text-lg font-semibold mb-3">Nutrition Today</h3>
        <div class="grid grid-cols-3 gap-4 text-center">
            <div>
                <div class="text-lg font-bold text-blue-600">{{ number_format($protein) }}g</div>
                <div class="text-sm text-gray-600">Protein</div>
            </div>
            <div>
                <div class="text-lg font-bold text-yellow-600">{{ number_format($carbs) }}g</div>
                <div class="text-sm text-gray-600">Carbs</div>
            </div>
            <div>
                <div class="text-lg font-bold text-red-600">{{ number_format($fats) }}g</div>
                <div class="text-sm text-gray-600">Fats</div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-lg shadow-sm p-4">
        <h3 class="text-lg font-semibold mb-3">Quick Actions</h3>
        <div class="grid grid-cols-2 gap-3">
            <a href="{{ route('workouts') }}"
               class="bg-blue-100 text-blue-700 py-3 px-4 rounded-lg text-center font-medium hover:bg-blue-200 transition duration-200">
                Log Workout
            </a>
            <a href="{{ route('meals') }}"
               class="bg-green-100 text-green-700 py-3 px-4 rounded-lg text-center font-medium hover:bg-green-200 transition duration-200">
                Log Meal
            </a>
        </div>
    </div>
</div>
