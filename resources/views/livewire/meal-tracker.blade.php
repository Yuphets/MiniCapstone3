<div class="min-h-screen bg-gray-50">
   <!-- Header - Moved to top -->
<div class="max-w-2xl mx-auto mb-8 pt-6">
    <div class="text-center">
        <h2 class="text-2xl md:text-3xl font-bold text-[#1C7C6E] mb-3">
            Meal Tracker
        </h2>
        <p class="text-base text-gray-600 max-w-md mx-auto">
            Track your daily nutrition
        </p>
    </div>
</div>

    <div class="px-4 py-6">
        <!-- Success Notification -->
        @if($showSuccessNotification)
        <div x-data="{ show: true }"
             x-show="show"
             x-transition
             x-init="setTimeout(() => show = false, 3000)"
             class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 flex justify-between items-center">
            <span>{{ $successMessage }}</span>
            <button @click="show = false" class="text-green-700 hover:text-green-900">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        @endif

        <!-- Quick Add Meal Section - Always show first -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-lg font-semibold">Quick Add Meal</h2>
                <div class="text-sm text-gray-600 font-medium">
                    {{ $formattedDate }}
                </div>
            </div>

            <!-- Meal Type Selection -->
            <div class="mb-6">
                <label class="block text-xs font-medium text-gray-700 mb-2 uppercase tracking-wide">Select Meal Type</label>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                    @foreach(['breakfast' => 'Breakfast', 'lunch' => 'Lunch', 'dinner' => 'Dinner', 'snack' => 'Snack'] as $type => $label)
                        <button
                            wire:click="$set('selectedMealType', '{{ $type }}')"
                            class="py-3 px-4 rounded-lg border-2 text-sm font-medium transition duration-200 {{ $selectedMealType === $type ? 'border-[#1C7C6E] bg-[#1C7C6E] text-white' : 'border-gray-200 bg-white text-gray-700 hover:border-[#1C7C6E]' }}"
                        >
                            {{ $label }}
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- Quick Add Food Section -->
            <div class="mb-6">
                <label class="block text-xs font-medium text-gray-700 mb-2 uppercase tracking-wide">Quick Add Food to {{ ucfirst($selectedMealType) }}</label>
                <input type="text"
                       wire:model="searchQuery"
                       wire:keydown.debounce.300ms="loadFoodItems"
                       class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-[#1C7C6E] focus:border-[#1C7C6E] mb-4"
                       placeholder="Search for food items...">

                <!-- Food Items Grid - Expanded scrollable area -->
                <div class="border border-gray-200 rounded-lg">
                    <div class="max-h-96 overflow-y-auto">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-0">
                            @forelse($foodItems as $food)
                                <div class="border-b border-r border-gray-200 p-4 hover:bg-gray-50 transition duration-150">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <div class="font-medium text-gray-900 text-sm mb-1">{{ $food->name }}</div>
                                            <div class="text-xs text-gray-500 mb-1">{{ $food->brand ?? 'Generic' }}</div>
                                            <div class="text-xs text-gray-600">
                                                {{ $food->serving_qty }} {{ $food->serving_unit }} • {{ $food->calories }} cal
                                            </div>
                                        </div>
                                        <button
                                            wire:click="openFoodDetail({{ $food->id }}, '{{ $selectedMealType }}')"
                                            class="ml-3 bg-[#1C7C6E] text-white px-4 py-2 rounded text-sm hover:bg-[#155c53] transition duration-200 whitespace-nowrap"
                                        >
                                            Add to {{ ucfirst($selectedMealType) }}
                                        </button>
                                    </div>
                                </div>
                            @empty
                                <div class="col-span-2 text-center text-gray-500 text-sm py-8">
                                    @if($searchQuery)
                                        No food items found for "{{ $searchQuery }}"
                                    @else
                                        Start typing to search for food items
                                    @endif
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Food Detail Modal -->
        @if($showFoodSearch && $selectedFood)
        <div class="fixed inset-0 bg-black bg-opacity-50 z-50" x-data="{
            servings: {{ $servings }},
            servingSize: {{ $servingSize }},
            servingUnit: '{{ $servingUnit }}',
            nutritionChart: null,
            totalCalories: {{ $selectedFood->calories }},
            protein: {{ $selectedFood->protein_g }},
            carbs: {{ $selectedFood->carbs_g }},
            fat: {{ $selectedFood->fats_g }},
            updateNutrition() {
                // Convert to numbers to avoid string multiplication
                const servingsNum = parseFloat(this.servings) || 0;
                const servingSizeNum = parseFloat(this.servingSize) || 0;

                // Update Livewire properties
                this.$wire.set('servings', servingsNum);
                this.$wire.set('servingSize', servingSizeNum);
                this.$wire.set('servingUnit', this.servingUnit);

                // Calculate updated values based on custom serving
                const baseCalories = {{ $selectedFood->calories }};
                const baseServingQty = {{ $selectedFood->serving_qty ?: 1 }};
                const baseServingUnit = '{{ $selectedFood->serving_unit }}';

                // Conversion ratios
                let conversionRatio = 1;
                if (this.servingUnit === 'oz' && baseServingUnit === 'g') {
                    conversionRatio = 28.35;
                } else if (this.servingUnit === 'g' && baseServingUnit === 'oz') {
                    conversionRatio = 0.035;
                } else if (this.servingUnit === 'ml' && baseServingUnit === 'g') {
                    conversionRatio = 1;
                } else if (this.servingUnit === 'g' && baseServingUnit === 'ml') {
                    conversionRatio = 1;
                }

                const servingRatio = (servingSizeNum * conversionRatio) / baseServingQty;

                // Update all nutrition values
                this.totalCalories = Math.round(baseCalories * servingRatio * servingsNum);
                this.protein = ({{ $selectedFood->protein_g }} * servingRatio * servingsNum).toFixed(1);
                this.carbs = ({{ $selectedFood->carbs_g }} * servingRatio * servingsNum).toFixed(1);
                this.fat = ({{ $selectedFood->fats_g }} * servingRatio * servingsNum).toFixed(1);

                // Update DOM elements
                document.getElementById('caloriesDisplay').textContent = this.totalCalories;
                document.getElementById('chartCalories').textContent = this.totalCalories;
                document.getElementById('proteinDisplay').textContent = this.protein + 'g';
                document.getElementById('carbsDisplay').textContent = this.carbs + 'g';
                document.getElementById('fatDisplay').textContent = this.fat + 'g';

                // Update doughnut chart with macro breakdown
                this.updateChart();
            },
            updateChart() {
                if (this.nutritionChart) {
                    this.nutritionChart.destroy();
                }

                const ctx = document.getElementById('nutritionChart');
                if (!ctx) return;

                // Calculate total macros for percentage calculation
                const totalMacros = parseFloat(this.protein) + parseFloat(this.carbs) + parseFloat(this.fat);

                // If no macros data, show empty chart
                if (totalMacros === 0) {
                    this.nutritionChart = new Chart(ctx, {
                        type: 'doughnut',
                        data: {
                            datasets: [{
                                data: [100],
                                backgroundColor: ['#E5E7EB'],
                                borderWidth: 0,
                                cutout: '70%'
                            }]
                        },
                        options: {
                            plugins: {
                                legend: { display: false },
                                tooltip: { enabled: false }
                            },
                            rotation: -90,
                            circumference: 360,
                            responsive: true,
                            maintainAspectRatio: false
                        }
                    });
                    return;
                }

                // Calculate percentages for each macro
                const proteinPercent = (parseFloat(this.protein) / totalMacros) * 100;
                const carbsPercent = (parseFloat(this.carbs) / totalMacros) * 100;
                const fatPercent = (parseFloat(this.fat) / totalMacros) * 100;

                // MyFitnessPal style colors
                const macroColors = ['#3B82F6', '#10B981', '#F59E0B']; // Blue for protein, Green for carbs, Yellow for fat

                this.nutritionChart = new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        datasets: [{
                            data: [proteinPercent, carbsPercent, fatPercent],
                            backgroundColor: macroColors,
                            borderWidth: 0,
                            cutout: '70%'
                        }]
                    },
                    options: {
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const label = context.label || '';
                                        const value = context.parsed;
                                        const macroGrams = [this.protein, this.carbs, this.fat][context.dataIndex];
                                        return `${label}: ${value.toFixed(1)}% (${macroGrams}g)`;
                                    }.bind(this)
                                }
                            }
                        },
                        rotation: -90,
                        circumference: 360,
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '70%'
                    }
                });
            },
            init() {
                // Initialize chart when modal opens
                this.$nextTick(() => {
                    this.updateChart();
                });
            }
        }" x-init="init()">
            <div class="min-h-screen flex items-center justify-center p-4">
                <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
                    <!-- Header -->
                    <div class="bg-white border-b border-gray-200 px-4 py-4">
                        <div class="flex items-center justify-between">
                            <button wire:click="closeFoodSearch" class="text-gray-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                </svg>
                            </button>
                            <h1 class="text-lg font-semibold text-gray-900">Add Food</h1>
                            <div class="w-6"></div>
                        </div>
                    </div>

                    <!-- Content - No scrolling -->
                    <div>
                        <!-- Food Header -->
                        <div class="p-6 border-b border-gray-200">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <h2 class="font-semibold text-gray-900 text-lg">{{ $selectedFood->name }}</h2>
                                    <p class="text-sm text-gray-600 mt-1">
                                        {{ $selectedFood->brand ?? 'Generic' }}
                                    </p>
                                </div>
                                <div class="text-right">
                                    <div class="text-xl font-bold text-gray-900" id="caloriesDisplay">
                                        {{ number_format($selectedFood->calories * $servings) }}
                                    </div>
                                    <div class="text-xs text-gray-500">calories</div>
                                </div>
                            </div>
                        </div>

                        <!-- Serving Selection -->
                        <div class="p-6 border-b border-gray-200">
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Number of Servings</label>
                                    <input type="number"
                                           x-model="servings"
                                           min="0.1"
                                           step="0.1"
                                           class="w-full border border-gray-300 rounded-lg px-4 py-3 text-lg text-center focus:outline-none focus:ring-2 focus:ring-[#1C7C6E] focus:border-[#1C7C6E]"
                                           @input="updateNutrition()">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Serving Size</label>
                                    <div class="flex space-x-2">
                                        <input type="number"
                                               x-model="servingSize"
                                               min="0.1"
                                               step="0.1"
                                               class="flex-1 border border-gray-300 rounded-lg px-4 py-3 text-center focus:outline-none focus:ring-2 focus:ring-[#1C7C6E] focus:border-[#1C7C6E]"
                                               @input="updateNutrition()">
                                        <select x-model="servingUnit"
                                                @change="updateNutrition()"
                                                class="border border-gray-300 rounded-lg px-3 py-3 focus:outline-none focus:ring-2 focus:ring-[#1C7C6E] focus:border-[#1C7C6E]">
                                            <option value="g">g</option>
                                            <option value="oz">oz</option>
                                            <option value="ml">ml</option>
                                            <option value="cup">cup</option>
                                            <option value="tbsp">tbsp</option>
                                            <option value="tsp">tsp</option>
                                            <option value="piece">piece</option>
                                            <option value="slice">slice</option>
                                        </select>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-2 text-center">
                                        Base: {{ $selectedFood->serving_qty }} {{ $selectedFood->serving_unit }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Nutrition Doughnut Chart and Breakdown -->
                        <div class="p-6 border-b border-gray-200">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-sm font-medium text-gray-900">Macronutrients</h3>
                                <div class="text-xs text-gray-500" x-text="`Per ${servings} serving(s)`"></div>
                            </div>



                            <!-- Macros Breakdown with Colors Matching Chart -->
                            <div class="space-y-3">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="w-3 h-3 bg-[#3B82F6] rounded-full mr-2"></div>
                                        <span class="text-sm font-medium text-gray-900">Protein</span>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-sm font-medium text-gray-900" id="proteinDisplay">
                                            {{ number_format($selectedFood->protein_g * $servings, 1) }}g
                                        </div>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="w-3 h-3 bg-[#10B981] rounded-full mr-2"></div>
                                        <span class="text-sm font-medium text-gray-900">Carbs</span>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-sm font-medium text-gray-900" id="carbsDisplay">
                                            {{ number_format($selectedFood->carbs_g * $servings, 1) }}g
                                        </div>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="w-3 h-3 bg-[#F59E0B] rounded-full mr-2"></div>
                                        <span class="text-sm font-medium text-gray-900">Fat</span>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-sm font-medium text-gray-900" id="fatDisplay">
                                            {{ number_format($selectedFood->fats_g * $servings, 1) }}g
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Add Button -->
                    <div class="p-6 bg-white border-t border-gray-200">
                        <button wire:click="addFoodToMeal"
                                class="w-full bg-[#1C7C6E] text-white py-4 rounded-lg font-semibold text-lg hover:bg-[#155c53] transition duration-200">
                            Add to {{ ucfirst($selectedMealType) }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
