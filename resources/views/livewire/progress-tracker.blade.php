<div class="min-h-screen bg-gray-50 p-4 md:p-6">
   <!-- Header Section -->
<div class="max-w-2xl mx-auto mb-8 pt-6">
    <div class="text-center">
        <h2 class="text-2xl md:text-3xl font-bold text-[#1C7C6E] mb-3">
            Progress Tracker
        </h2>
        <p class="text-base text-gray-600 max-w-md mx-auto">
            Your fitness trends over time
        </p>
    </div>
</div>

    @if (session('message'))
        <div class="max-w-6xl mx-auto mb-6">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
                {{ session('message') }}
            </div>
        </div>
    @endif

    <div class="max-w-6xl mx-auto space-y-6 md:space-y-8">
        <!-- Chart Section -->
        <div class="bg-white rounded-2xl md:rounded-3xl shadow-lg p-4 md:p-6 border border-[#B6E0D9]">
            <div class="bg-gradient-to-r from-[#E0F3F0] to-[#B6E0D9] rounded-2xl p-4 md:p-6 shadow-inner border border-[#B6E0D9]">
                <canvas id="progressChart" class="w-full h-48 md:h-56 lg:h-64" wire:ignore></canvas>
            </div>
        </div>

        <!-- Statistics Section -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 md:gap-4">
            <!-- Weight -->
            <div class="bg-[#B6E0D9] hover:bg-[#99c9bb] hover:scale-105 transform transition-all duration-300 p-3 md:p-4 rounded-xl shadow-sm border border-[#B6E0D9] flex flex-col items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 md:w-6 md:h-6 text-[#1C7C6E] mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M12 20a8 8 0 100-16 8 8 0 000 16z" />
                </svg>
                <p class="text-xs md:text-sm text-gray-600">Weight</p>
                <h3 class="font-bold text-[#1C7C6E] text-base md:text-lg">
                    {{ $weight ? number_format($weight, 1) : 'N/A' }}<span class="text-sm">kg</span>
                </h3>
            </div>

            <!-- BMI -->
            <div class="bg-white hover:bg-[#E0F3F0] hover:scale-105 transform transition-all duration-300 p-3 md:p-4 rounded-xl shadow-sm border border-[#B6E0D9] flex flex-col items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 md:w-6 md:h-6 text-blue-500 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-6a2 2 0 012-2h2a2 2 0 012 2v6m-6 0h6" />
                </svg>
                <p class="text-xs md:text-sm text-gray-600">BMI</p>
                <h3 class="font-bold text-[#1C7C6E] text-base md:text-lg">
                    {{ $bmi ? number_format($bmi, 1) : 'N/A' }}
                </h3>
                @if($bmi)
                    @php
                        $bmiCategory = '';
                        $bmiColor = 'gray';
                        if ($bmi < 18.5) {
                            $bmiCategory = 'Underweight';
                            $bmiColor = 'yellow';
                        } elseif ($bmi >= 18.5 && $bmi < 25) {
                            $bmiCategory = 'Healthy Weight';
                            $bmiColor = 'green';
                        } elseif ($bmi >= 25 && $bmi < 30) {
                            $bmiCategory = 'Overweight';
                            $bmiColor = 'orange';
                        } else {
                            $bmiCategory = 'Obese';
                            $bmiColor = 'red';
                        }
                    @endphp
                    <div class="mt-1 px-2 py-1 rounded-full text-xs font-medium
                        @if($bmiColor === 'green') bg-green-100 text-green-800
                        @elseif($bmiColor === 'yellow') bg-yellow-100 text-yellow-800
                        @elseif($bmiColor === 'orange') bg-orange-100 text-orange-800
                        @elseif($bmiColor === 'red') bg-red-100 text-red-800
                        @else bg-gray-100 text-gray-800 @endif">
                        {{ $bmiCategory }}
                    </div>
                @endif
            </div>

            <!-- Body Fat -->
            <div class="bg-[#E0F3F0] hover:bg-[#B6E0D9] hover:scale-105 transform transition-all duration-300 p-3 md:p-4 rounded-xl shadow-sm border border-[#B6E0D9] flex flex-col items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 md:w-6 md:h-6 text-yellow-500 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6 1a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="text-xs md:text-sm text-gray-600">Body Fat</p>
                <h3 class="font-bold text-[#1C7C6E] text-base md:text-lg">
                    {{ $bodyFat ? number_format($bodyFat, 1) : 'N/A' }}<span class="text-sm">%</span>
                </h3>
            </div>

            <!-- Waist -->
            <div class="bg-white hover:bg-[#E0F3F0] hover:scale-105 transform transition-all duration-300 p-3 md:p-4 rounded-xl shadow-sm border border-[#B6E0D9] flex flex-col items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 md:w-6 md:h-6 text-purple-500 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <p class="text-xs md:text-sm text-gray-600">Waist</p>
                <h3 class="font-bold text-[#1C7C6E] text-base md:text-lg">
                    {{ $waist ? number_format($waist, 1) : 'N/A' }}<span class="text-sm">cm</span>
                </h3>
            </div>
        </div>

        <!-- Body Metrics Form -->
        <div class="bg-white rounded-2xl md:rounded-3xl shadow-lg p-4 md:p-6 border border-[#B6E0D9]">
            <h2 class="text-lg md:text-xl font-semibold text-[#1C7C6E] mb-4 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 md:w-6 md:h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Update Body Metrics
            </h2>

            <form wire:submit.prevent="saveBodyMetric" class="space-y-4 md:space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3 md:gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Weight (kg)</label>
                        <input type="number" step="0.1" wire:model="weight"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 md:py-3 focus:outline-none focus:ring-2 focus:ring-[#1C7C6E] focus:border-transparent transition duration-200"
                               placeholder="Enter weight">
                        @error('weight')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Body Fat %</label>
                        <input type="number" step="0.1" wire:model="bodyFat"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 md:py-3 focus:outline-none focus:ring-2 focus:ring-[#1C7C6E] focus:border-transparent transition duration-200"
                               placeholder="Enter body fat %">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Waist (cm)</label>
                        <input type="number" step="0.1" wire:model="waist"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 md:py-3 focus:outline-none focus:ring-2 focus:ring-[#1C7C6E] focus:border-transparent transition duration-200"
                               placeholder="Enter waist measurement">
                    </div>
                </div>

                <button type="submit" id="saveMetricsBtn"
                        class="bg-[#1C7C6E] hover:bg-[#155c53] text-white font-semibold py-2 md:py-3 px-6 md:px-8 rounded-lg transition-all duration-300 transform hover:scale-105 flex items-center gap-2 w-full md:w-auto justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 md:w-5 md:h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span id="buttonText">Save Metrics</span>
                </button>
            </form>
        </div>

        <!-- Goals and Achievements Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 md:gap-6">
            <!-- Goals Card -->
            <div class="bg-white rounded-2xl md:rounded-3xl shadow-lg p-4 md:p-6 border border-[#B6E0D9]">
                <h3 class="text-lg md:text-xl font-semibold text-[#1C7C6E] mb-4 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 md:w-6 md:h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Goals
                </h3>

                @if(count($goals) > 0)
                    <div class="space-y-3">
                        @foreach($goals as $goal)
                            <div class="border border-[#E0F3F0] rounded-xl p-3 md:p-4 hover:bg-[#F9FDFC] transition duration-200">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <span class="font-medium text-gray-800">
                                            {{ ucfirst(str_replace('_', ' ', $goal->goal_type)) }}
                                        </span>
                                        <div class="text-sm text-gray-500 mt-1">
                                            {{ $goal->start_date->format('M j') }} - {{ $goal->end_date->format('M j, Y') }}
                                        </div>
                                    </div>
                                    <span class="text-sm font-semibold text-[#1C7C6E] bg-[#E0F3F0] px-2 py-1 rounded-full">
                                        {{ $goal->target_value }} {{ $goal->unit }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-6 md:py-8">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 md:w-16 md:h-16 text-gray-300 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="text-gray-500">No goals set yet.</p>
                        <p class="text-sm text-gray-400 mt-1">Set your first fitness goal to get started!</p>
                    </div>
                @endif
            </div>

            <!-- Achievements Card -->
            <div class="bg-white rounded-2xl md:rounded-3xl shadow-lg p-4 md:p-6 border border-[#B6E0D9]">
                <h3 class="text-lg md:text-xl font-semibold text-[#1C7C6E] mb-4 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 md:w-6 md:h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Recent Achievements
                </h3>

                @if(count($achievements) > 0)
                    <div class="space-y-3">
                        @foreach($achievements->take(3) as $achievement)
                            <div class="border border-[#E0F3F0] rounded-xl p-3 md:p-4 hover:bg-[#F9FDFC] transition duration-200">
                                <div class="font-medium text-gray-800">{{ $achievement->title }}</div>
                                <div class="text-sm text-gray-500 mt-1 flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    {{ $achievement->achieved_at->format('M j, Y') }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-6 md:py-8">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 md:w-16 md:h-16 text-gray-300 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="text-gray-500">No achievements yet.</p>
                        <p class="text-sm text-gray-400 mt-1">Keep working towards your goals!</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Chart.js Script -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        let progressChart = null;

        function initializeChart() {
            const ctx = document.getElementById('progressChart');
            if (ctx) {
                // Destroy existing chart if it exists
                if (progressChart) {
                    progressChart.destroy();
                }

                // Get actual weight data from Livewire component
                const weightData = @json($weightHistory->pluck('weight_kg'));
                const labels = @json($weightHistory->pluck('measured_at')->map(function($date) {
                    return \Carbon\Carbon::parse($date)->format('M j');
                }));

                // If no data, show placeholder
                const chartData = weightData.length > 0 ? weightData : [0];
                const chartLabels = labels.length > 0 ? labels : ['No data'];

                progressChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: chartLabels,
                        datasets: [{
                            label: 'Weight (kg)',
                            data: chartData,
                            borderColor: '#1C7C6E',
                            borderWidth: 3,
                            pointBackgroundColor: '#1C7C6E',
                            pointBorderColor: '#ffffff',
                            pointBorderWidth: 2,
                            pointRadius: 5,
                            pointHoverRadius: 7,
                            tension: 0.4,
                            fill: false
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                backgroundColor: '#1C7C6E',
                                titleColor: '#ffffff',
                                bodyColor: '#ffffff',
                                borderColor: '#155c53',
                                borderWidth: 1
                            }
                        },
                        scales: {
                            y: {
                                display: true,
                                grid: {
                                    color: 'rgba(182, 224, 217, 0.3)'
                                },
                                ticks: {
                                    color: '#1C7C6E'
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    color: '#1C7C6E'
                                }
                            }
                        },
                        interaction: {
                            intersect: false,
                            mode: 'index'
                        }
                    }
                });
            }
        }

        // Initialize chart when page loads
        document.addEventListener('DOMContentLoaded', function() {
            initializeChart();
        });

        // Re-initialize chart after Livewire updates
        document.addEventListener('livewire:load', function() {
            initializeChart();
        });

        document.addEventListener('livewire:update', function() {
            setTimeout(initializeChart, 100);
        });

        // Save Metrics Button Animation
        const saveMetricsBtn = document.getElementById('saveMetricsBtn');

        if (saveMetricsBtn) {
            saveMetricsBtn.addEventListener('click', function() {
                // Change button to saved state
                const originalText = saveMetricsBtn.innerHTML;
                saveMetricsBtn.classList.remove('bg-[#1C7C6E]', 'hover:bg-[#155c53]');
                saveMetricsBtn.classList.add('bg-green-500', 'hover:bg-green-600');
                saveMetricsBtn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 md:w-5 md:h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg><span class="flex items-center gap-2">Saved!</span>';

                // Add bounce animation
                saveMetricsBtn.classList.add('animate-bounce');

                // Revert back to original state after 3 seconds
                setTimeout(() => {
                    saveMetricsBtn.classList.remove('bg-green-500', 'hover:bg-green-600', 'animate-bounce');
                    saveMetricsBtn.classList.add('bg-[#1C7C6E]', 'hover:bg-[#155c53]');
                    saveMetricsBtn.innerHTML = originalText;
                }, 3000);
            });
        }
    </script>

    <!-- Responsive Styles -->
    <style>
        @media (max-width: 640px) {
            .grid-cols-2 {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 480px) {
            .grid-cols-2 {
                grid-template-columns: 1fr;
                gap: 0.5rem;
            }
        }

        /* Smooth transitions for all interactive elements */
        .transform {
            transition: all 0.3s ease-in-out;
        }

        /* Focus styles for better accessibility */
        input:focus {
            box-shadow: 0 0 0 3px rgba(28, 124, 110, 0.1);
        }

        /* Bounce animation for the save button */
        @keyframes bounce {
            0%, 20%, 60%, 100% {
                transform: translateY(0);
            }
            40% {
                transform: translateY(-10px);
            }
            80% {
                transform: translateY(-5px);
            }
        }
        .animate-bounce {
            animation: bounce 0.5s;
        }
    </style>
</div>
