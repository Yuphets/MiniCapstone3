<div class="px-4 py-6">
    <h1 class="text-2xl font-bold text-gray-900 mb-6">Progress Tracker</h1>

    <!-- Body Metrics Form -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <h2 class="text-lg font-semibold mb-4">Update Body Metrics</h2>

        @if (session('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('message') }}
            </div>
        @endif

        <form wire:submit.prevent="saveBodyMetric">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Weight (kg)</label>
                    <input type="number" step="0.1" wire:model="weight"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('weight') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Body Fat %</label>
                    <input type="number" step="0.1" wire:model="bodyFat"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Waist (cm)</label>
                    <input type="number" step="0.1" wire:model="waist"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <button type="submit"
                    class="bg-blue-600 text-white px-6 py-2 rounded-lg font-medium hover:bg-blue-700 transition duration-200">
                Save Metrics
            </button>
        </form>
    </div>

    <!-- Current Metrics Display -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <h2 class="text-lg font-semibold mb-4">Current Metrics</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="text-center p-4 bg-gray-50 rounded-lg">
                <div class="text-2xl font-bold text-gray-900">{{ $weight ? number_format($weight, 1) : 'N/A' }}</div>
                <div class="text-sm text-gray-600">Weight (kg)</div>
            </div>
            <div class="text-center p-4 bg-gray-50 rounded-lg">
                <div class="text-2xl font-bold text-gray-900">
                    @if($weight && Auth::user()->height_cm)
                        {{ number_format($weight / ((Auth::user()->height_cm / 100) ** 2), 1) }}
                    @else
                        N/A
                    @endif
                </div>
                <div class="text-sm text-gray-600">BMI</div>
            </div>
            <div class="text-center p-4 bg-gray-50 rounded-lg">
                <div class="text-2xl font-bold text-gray-900">{{ $bodyFat ? number_format($bodyFat, 1) : 'N/A' }}</div>
                <div class="text-sm text-gray-600">Body Fat %</div>
            </div>
            <div class="text-center p-4 bg-gray-50 rounded-lg">
                <div class="text-2xl font-bold text-gray-900">{{ $waist ? number_format($waist, 1) : 'N/A' }}</div>
                <div class="text-sm text-gray-600">Waist (cm)</div>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-semibold mb-4">Goals</h3>
            @if(count($goals) > 0)
                @foreach($goals as $goal)
                    <div class="border-b border-gray-200 py-3">
                        <div class="flex justify-between items-center">
                            <span class="font-medium">{{ ucfirst(str_replace('_', ' ', $goal->goal_type)) }}</span>
                            <span class="text-sm text-gray-600">{{ $goal->target_value }} {{ $goal->unit }}</span>
                        </div>
                        <div class="text-sm text-gray-500">
                            {{ $goal->start_date->format('M j') }} - {{ $goal->end_date->format('M j, Y') }}
                        </div>
                    </div>
                @endforeach
            @else
                <p class="text-gray-500 text-center py-4">No goals set yet.</p>
            @endif
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-semibold mb-4">Recent Achievements</h3>
            @if(count($achievements) > 0)
                @foreach($achievements->take(3) as $achievement)
                    <div class="border-b border-gray-200 py-3">
                        <div class="font-medium">{{ $achievement->title }}</div>
                        <div class="text-sm text-gray-500">{{ $achievement->achieved_at->format('M j, Y') }}</div>
                    </div>
                @endforeach
            @else
                <p class="text-gray-500 text-center py-4">No achievements yet.</p>
            @endif
        </div>
    </div>
</div>
