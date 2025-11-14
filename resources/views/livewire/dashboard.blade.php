<div class="min-h-screen bg-gray-50">

    <!-- Mobile Content -->
    <div class="md:hidden">
        <!-- ===== MOBILE HEADER - Compact Version ===== -->
        <header class="w-full max-w-6xl mx-auto flex items-center justify-between px-4 py-3 bg-white shadow-sm border-b">
            <!-- Left: Profile with Greeting -->
            <div class="flex items-center space-x-3">
                <img src="/images/jastin.jpg" alt="Profile" class="w-10 h-10 md:w-12 md:h-12 rounded-full object-cover shadow-md border-2">
                <div class="flex flex-col">
                    <span class="text-xs text-gray-500">Welcome back,</span>
                    <h2 class="text-sm font-bold text-gray-900">{{ auth()->user()->username }}</h2>
                </div>
            </div>

            <!-- Center: Logo -->
            <div class="flex-1 flex justify-center relative">
                <img src="/images/nutriquest-logo sm.png" alt="NutriQuest Logo" class="h-10 md:h-12 lg:h-16 object-contain drop-shadow-md">
            </div>

            <!-- Right: Logout Button -->
            <div class="flex items-center">
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit"
                            class="flex items-center space-x-1 text-gray-600 hover:text-red-600 transition duration-200 p-2 rounded-lg hover:bg-red-50 group"
                            title="Logout">
                        <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span class="text-xs font-medium hidden sm:inline">Logout</span>
                    </button>
                </form>
            </div>
        </header>

        <!-- Mobile Navigation -->
        <nav class="bg-white border-t border-gray-200 fixed bottom-0 left-0 right-0">
            <div class="flex justify-around items-center h-16">
                <a href="{{ route('dashboard') }}" class="flex flex-col items-center justify-center px-3 py-2 {{ request()->routeIs('dashboard') ? 'text-primary' : 'text-gray-500' }} hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span class="text-xs mt-1">Dashboard</span>
                </a>
                <a href="{{ route('workouts') }}" class="flex flex-col items-center justify-center px-3 py-2 {{ request()->routeIs('workouts') ? 'text-primary' : 'text-gray-500' }} hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    <span class="text-xs mt-1">Workouts</span>
                </a>
                <a href="{{ route('meals') }}" class="flex flex-col items-center justify-center px-3 py-2 {{ request()->routeIs('meals') ? 'text-primary' : 'text-gray-500' }} hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="text-xs mt-1">Meals</span>
                </a>
                <a href="{{ route('diary') }}" class="flex flex-col items-center justify-center px-3 py-2 {{ request()->routeIs('diary') ? 'text-primary' : 'text-gray-500' }} hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <span class="text-xs mt-1">Diary</span>
                </a>
                <a href="{{ route('progress') }}" class="flex flex-col items-center justify-center px-3 py-2 {{ request()->routeIs('progress') ? 'text-primary' : 'text-gray-500' }} hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    <span class="text-xs mt-1">Progress</span>
                </a>
            </div>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="flex flex-col items-center p-4 space-y-4 overflow-x-hidden pb-20 md:pb-4">
        <!-- === LOGGING PROGRESS CARD === -->
        <a href="{{ route('diary') }}" class="block w-full max-w-sm lg:max-w-md">
            <div class="carousel-card relative bg-white rounded-2xl shadow-sm p-4 md:p-6 flex flex-col items-center w-full snap-start flex-shrink-0 cursor-pointer">
                <h2 class="text-lg md:text-xl font-semibold text-center text-gray-700 mb-2">Logging Progress</h2>
                <p class="text-center font-semibold text-green-600 text-base md:text-lg mb-3">
                    @if(($stats['meals_logged'] ?? 0) >= 3)
                        Crushing it!
                    @elseif(($stats['meals_logged'] ?? 0) >= 1)
                        Good start!
                    @else
                        Let's get started!
                    @endif
                </p>

                <div class="w-32 h-32 md:w-36 md:h-36 lg:w-40 lg:h-40 relative">
                    <canvas id="curvedProgressArc"></canvas>
                    <div class="absolute inset-0 flex flex-col items-center justify-center">
                        <span class="text-lg md:text-xl font-bold text-gray-800">{{ $stats['meals_logged'] ?? 0 }} / 4 Meals</span>
                        <span class="text-sm text-gray-500 mt-0.5">Logged</span>
                    </div>
                </div>

                <p class="text-xs md:text-sm text-center mt-4 text-gray-600 leading-snug">
                    You've logged <span class="font-bold">{{ $stats['meals_logged'] ?? 0 }} meals</span> and
                    <span class="font-bold">{{ $stats['protein_consumed'] ?? 0 }}g of protein</span>.
                </p>
            </div>
        </a>

        <!-- === CAROUSEL CONTAINER === -->
        <div class="carousel-container relative w-full max-w-6xl">
            <div id="cardCarousel" class="carousel flex overflow-x-auto gap-4 p-4 scroll-smooth snap-x snap-mandatory">
                <!-- MACRO CARD -->
                <div class="carousel-card relative bg-white rounded-2xl shadow-sm p-4 md:p-6 flex flex-col items-center w-full max-w-sm lg:max-w-md snap-start flex-shrink-0 cursor-pointer"
                     onclick="openMacroModal()">
                    <h2 class="text-lg md:text-xl font-semibold mb-4 md:mb-6 text-center">MACRO</h2>
                    <div class="flex justify-around w-full gap-2 md:gap-4">
                        <!-- CARBS -->
                        <div class="flex flex-col items-center relative">
                            <p class="text-sm md:text-base font-semibold mb-2 md:mb-3" style="color: #3B82F6;">Carbs</p>
                            <div class="relative flex items-center justify-center">
                                <canvas id="carbsChart" class="w-20 h-20 md:w-24 md:h-24 lg:w-28 lg:h-28"></canvas>
                                <div class="absolute flex flex-col items-center justify-center">
                                    <p class="text-base md:text-lg font-bold text-gray-800 leading-tight" id="carbsRemaining">{{ max(0, $carbsGoal - $carbs) }}</p>
                                    <p class="text-xs text-gray-500 mt-0.5">Remaining</p>
                                </div>
                            </div>
                            <p class="text-xs text-gray-600 mt-1">Goal: <span id="carbsGoalText">{{ $carbsGoal }}</span>g</p>
                        </div>
                        <!-- FATS -->
                        <div class="flex flex-col items-center relative">
                            <p class="text-sm md:text-base font-semibold mb-2 md:mb-3" style="color: #F59E0B;">Fats</p>
                            <div class="relative flex items-center justify-center">
                                <canvas id="fatsChart" class="w-20 h-20 md:w-24 md:h-24 lg:w-28 lg:h-28"></canvas>
                                <div class="absolute flex flex-col items-center justify-center">
                                    <p class="text-base md:text-lg font-bold text-gray-800 leading-tight" id="fatsRemaining">{{ max(0, $fatsGoal - $fats) }}</p>
                                    <p class="text-xs text-gray-500 mt-0.5">Remaining</p>
                                </div>
                            </div>
                            <p class="text-xs text-gray-600 mt-1">Goal: <span id="fatsGoalText">{{ $fatsGoal }}</span>g</p>
                        </div>
                        <!-- PROTEIN -->
                        <div class="flex flex-col items-center relative">
                            <p class="text-sm md:text-base font-semibold mb-2 md:mb-3" style="color: #10B981;">Protein</p>
                            <div class="relative flex items-center justify-center">
                                <canvas id="proteinChart" class="w-20 h-20 md:w-24 md:h-24 lg:w-28 lg:h-28"></canvas>
                                <div class="absolute flex flex-col items-center justify-center">
                                    <p class="text-base md:text-lg font-bold text-gray-800 leading-tight" id="proteinRemaining">{{ max(0, $proteinGoal - $protein) }}</p>
                                    <p class="text-xs text-gray-500 mt-0.5">Remaining</p>
                                </div>
                            </div>
                            <p class="text-xs text-gray-600 mt-1">Goal: <span id="proteinGoalText">{{ $proteinGoal }}</span>g</p>
                        </div>
                    </div>
                </div>

               <!-- CALORIE GOAL CARD -->
                <div class="carousel-card relative bg-white rounded-2xl shadow-sm p-4 md:p-6 flex flex-col items-center w-full max-w-sm lg:max-w-md snap-start flex-shrink-0 cursor-pointer"
                     onclick="openCalorieModal()">
                    <h2 class="text-lg md:text-xl font-semibold mb-4 md:mb-6 text-center">Calorie Goal</h2>
                    <div class="relative w-32 h-32 md:w-36 md:h-36 lg:w-40 lg:h-40 flex items-center justify-center">
                        <canvas id="calorieChart" class="w-full h-full"></canvas>
                        <div class="absolute inset-0 flex flex-col items-center justify-center text-center">
                            <span id="caloriesRemainingText" class="text-lg md:text-xl font-bold text-gray-800 leading-none">{{ max(0, $calorieGoal - $caloriesIn) }}</span>
                            <span class="text-sm text-gray-500 mt-1">Remaining</span>
                        </div>
                    </div>
                    <div class="flex justify-between mt-4 w-full text-xs md:text-sm px-2 md:px-4">
                        <span>Goal: <strong id="calorieGoalText">{{ $calorieGoal }}</strong> kcal</span>
                        <span>Consumed: <strong id="caloriesConsumedFooter">{{ $caloriesIn }}</strong> kcal</span>
                    </div>
                </div>
            </div>

            <!-- DOT INDICATORS -->
            <div id="carouselDots" class="flex justify-center mt-4 space-x-2">
                <span class="dot w-2.5 h-2.5 bg-gray-300 rounded-full"></span>
                <span class="dot w-2.5 h-2.5 bg-gray-300 rounded-full"></span>
            </div>
        </div>

        <!-- === BOTTOM CARDS CONTAINER === -->
        <div class="w-full max-w-6xl mx-auto flex flex-col md:flex-row gap-4 p-4">
            <!-- === Steps Card === -->
            <div x-data="{ open: false, dontTrack: false }" class="flex-1">
                <div
                    @click="open = true"
                    class="bg-white rounded-2xl shadow-md p-4 md:p-6 flex flex-col justify-center cursor-pointer h-32 md:h-40">

                    <div class="text-center">
                        <p class="text-gray-800 font-semibold text-lg md:text-xl mb-1">Steps</p>
                        <p class="text-gray-500 text-sm md:text-base">Connect to track steps</p>
                    </div>
                </div>

                <!-- Steps Modal -->
                <div
                    x-show="open"
                    x-transition
                    class="fixed inset-0 bg-black/30 flex items-center justify-center z-50 p-4">
                    <div
                        @click.away="open = false"
                        class="bg-white rounded-2xl p-6 w-full max-w-sm md:max-w-md shadow-lg space-y-4">

                        <h2 class="text-lg md:text-xl font-semibold text-gray-800 text-center">Track Steps</h2>

                        <button
                            class="w-full flex items-center justify-center gap-2 bg-blue-500 text-white px-4 py-3 rounded-xl hover:bg-blue-600 transition text-sm md:text-base">
                            <span class="text-xl font-bold">+</span> Add Device
                        </button>

                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" x-model="dontTrack" class="w-4 h-4 md:w-5 md:h-5 rounded border-gray-300">
                            <span class="text-gray-700 text-sm md:text-base">Don't track steps</span>
                        </label>

                        <button @click="open = false" class="w-full text-center text-gray-500 hover:text-gray-700 text-sm md:text-base">Cancel</button>
                    </div>
                </div>
            </div>

            <!-- === Exercise Card === -->
            <div x-data="{ open: false }" class="flex-1 relative">
                <div
                    class="bg-white rounded-2xl shadow-md p-4 md:p-6 flex flex-col justify-center cursor-pointer h-32 md:h-40">

                    <!-- Header with Exercise text and + icon -->
                    <div class="flex items-center justify-between mb-2">
                        <p @click="window.location.href='{{ route('workouts') }}'" class="text-gray-800 font-semibold text-lg md:text-xl m-0 cursor-pointer">Exercise</p>
                        <button @click.stop="open = true" class="text-2xl md:text-3xl font-extrabold text-gray-800 leading-none">+</button>
                    </div>

                    <!-- Card details -->
                    <div class="text-center">
                        <p @click="window.location.href='{{ route('workouts') }}'" class="text-gray-500 text-sm md:text-base mb-1 cursor-pointer">{{ $caloriesOut }} kcal</p>
                        <p @click="window.location.href='{{ route('workouts') }}'" class="text-gray-400 text-xs md:text-sm cursor-pointer">{{ $stats['workouts_logged'] ?? 0 }} workouts logged</p>
                    </div>
                </div>

                <!-- Exercise Modal -->
                <div
                    x-show="open"
                    x-transition
                    class="fixed inset-0 bg-black/30 flex items-center justify-center z-50 p-4">
                    <div
                        @click.away="open = false"
                        class="bg-white rounded-2xl p-6 w-full max-w-sm md:max-w-md shadow-lg space-y-4">

                        <h2 class="text-lg md:text-xl font-semibold text-gray-800 text-center">Exercises</h2>

                        <!-- Exercise Choices -->
                        <div class="flex flex-col gap-3">
                            <a href="{{ route('workouts') }}" class="flex items-center gap-2 cursor-pointer hover:bg-gray-50 p-2 md:p-3 rounded">
                                <input type="radio" name="exerciseType" value="cardiovascular" class="w-4 h-4 md:w-5 md:h-5 text-green-500">
                                <span class="text-gray-800 font-medium text-sm md:text-base">Cardiovascular</span>
                            </a>
                            <a href="{{ route('workouts') }}" class="flex items-center gap-2 cursor-pointer hover:bg-gray-50 p-2 md:p-3 rounded">
                                <input type="radio" name="exerciseType" value="strength" class="w-4 h-4 md:w-5 md:h-5 text-yellow-500">
                                <span class="text-gray-800 font-medium text-sm md:text-base">Strength</span>
                            </a>
                        </div>

                        <button @click="open = false" class="w-full text-center text-gray-500 hover:text-gray-700 text-sm md:text-base">Cancel</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- === QUICK ACTIONS (Desktop Only) === -->
        <div class="hidden lg:block w-full max-w-6xl mx-auto p-4">
            <div class="bg-white rounded-2xl shadow-sm p-4 md:p-6">
                <h3 class="text-lg md:text-xl font-semibold mb-4 text-center">Quick Actions</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 md:gap-4">
                    <a href="{{ route('workouts') }}"
                       class="bg-blue-100 text-blue-700 py-3 px-4 rounded-xl text-center font-medium hover:bg-blue-200 transition duration-200 flex items-center justify-center gap-2 text-sm md:text-base">
                        <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                        Log Workout
                    </a>
                    <a href="{{ route('meals') }}"
                       class="bg-green-100 text-green-700 py-3 px-4 rounded-xl text-center font-medium hover:bg-green-200 transition duration-200 flex items-center justify-center gap-2 text-sm md:text-base">
                        <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Log Meal
                    </a>
                </div>
            </div>
        </div>

        <!-- === DESKTOP STATS GRID (Hidden on mobile) === -->
        <div class="hidden lg:block w-full max-w-6xl mx-auto p-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="bg-white rounded-2xl shadow-sm p-6 text-center">
                    <div class="text-2xl font-bold text-green-600">{{ $stats['meals_logged'] ?? 0 }}</div>
                    <div class="text-sm text-gray-600">Meals Today</div>
                </div>
                <div class="bg-white rounded-2xl shadow-sm p-6 text-center">
                    <div class="text-2xl font-bold text-blue-600">{{ $stats['workouts_logged'] ?? 0 }}</div>
                    <div class="text-sm text-gray-600">Workouts</div>
                </div>
                <div class="bg-white rounded-2xl shadow-sm p-6 text-center">
                    <div class="text-2xl font-bold text-purple-600">{{ $stats['protein_consumed'] ?? 0 }}g</div>
                    <div class="text-sm text-gray-600">Protein</div>
                </div>
            </div>
        </div>
    </div>

    <!-- === MODALS === -->
    <!-- Macro Goals Modal -->
    <div id="macroModal" class="fixed inset-0 bg-black/30 flex items-center justify-center z-50 p-4 hidden">
        <div class="bg-white rounded-2xl p-6 w-full max-w-sm md:max-w-md shadow-lg space-y-4">
            <h2 class="text-lg md:text-xl font-semibold text-gray-800 text-center">Edit Macro Goals</h2>

            <div class="space-y-3">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Protein (g)</label>
                    <input type="number" id="macroProteinInput" value="{{ $proteinGoal }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Carbs (g)</label>
                    <input type="number" id="macroCarbsInput" value="{{ $carbsGoal }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Fats (g)</label>
                    <input type="number" id="macroFatsInput" value="{{ $fatsGoal }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500">
                </div>
            </div>

            <div class="flex gap-3 pt-2">
                <button
                    onclick="closeMacroModal()"
                    class="flex-1 text-center text-gray-500 hover:text-gray-700 py-2 rounded-lg border border-gray-300 hover:border-gray-400 transition duration-200">
                    Cancel
                </button>
                <button
                    onclick="saveMacroGoals()"
                    id="macroSaveButton"
                    class="flex-1 bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 transition duration-200 font-medium flex items-center justify-center gap-2">
                    <span>Save</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Calorie Goal Modal -->
    <div id="calorieModal" class="fixed inset-0 bg-black/30 flex items-center justify-center z-50 p-4 hidden">
        <div class="bg-white rounded-2xl p-6 w-full max-w-sm md:max-w-md shadow-lg space-y-4">
            <h2 class="text-lg md:text-xl font-semibold text-gray-800 text-center">Edit Calorie Goal</h2>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Daily Calorie Goal (kcal)</label>
                <input type="number" id="calorieGoalInput" value="{{ $calorieGoal }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
            </div>

            <div class="flex gap-3 pt-2">
                <button
                    onclick="closeCalorieModal()"
                    class="flex-1 text-center text-gray-500 hover:text-gray-700 py-2 rounded-lg border border-gray-300 hover:border-gray-400 transition duration-200">
                    Cancel
                </button>
                <button
                    onclick="saveCalorieGoal()"
                    id="calorieSaveButton"
                    class="flex-1 bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 transition duration-200 font-medium flex items-center justify-center gap-2">
                    <span>Save</span>
                </button>
            </div>
        </div>
    </div>

    <!-- ===== SCRIPTS ===== -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Store chart instances so we can update them
        let progressChart, carbsChartInstance, fatsChartInstance, proteinChartInstance, calorieChartInstance;
        let chartsInitialized = false;

        // Modal functions
        function openMacroModal() {
            document.getElementById('macroModal').classList.remove('hidden');
        }

        function closeMacroModal() {
            document.getElementById('macroModal').classList.add('hidden');
        }

        function openCalorieModal() {
            document.getElementById('calorieModal').classList.remove('hidden');
        }

        function closeCalorieModal() {
            document.getElementById('calorieModal').classList.add('hidden');
        }

        // Save functions - Using localStorage for persistence
        function saveMacroGoals() {
            const proteinGoal = parseInt(document.getElementById('macroProteinInput').value) || 0;
            const carbsGoal = parseInt(document.getElementById('macroCarbsInput').value) || 0;
            const fatsGoal = parseInt(document.getElementById('macroFatsInput').value) || 0;

            const saveButton = document.getElementById('macroSaveButton');

            // Show saving state
            saveButton.innerHTML = '<svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg><span>Saving...</span>';
            saveButton.disabled = true;

            // Save to localStorage for persistence
            localStorage.setItem('macroGoals', JSON.stringify({
                protein: proteinGoal,
                carbs: carbsGoal,
                fats: fatsGoal
            }));

            // Update UI immediately
            updateMacroTexts(proteinGoal, carbsGoal, fatsGoal);

            // Close modal and reset button after delay
            setTimeout(() => {
                closeMacroModal();
                saveButton.innerHTML = '<span>Save</span>';
                saveButton.disabled = false;
            }, 600);
        }

        function saveCalorieGoal() {
            const calorieGoal = parseInt(document.getElementById('calorieGoalInput').value) || 0;

            const saveButton = document.getElementById('calorieSaveButton');

            // Show saving state
            saveButton.innerHTML = '<svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg><span>Saving...</span>';
            saveButton.disabled = true;

            // Save to localStorage for persistence
            localStorage.setItem('calorieGoal', calorieGoal.toString());

            // Update UI immediately
            updateCalorieText(calorieGoal);

            // Close modal and reset button after delay
            setTimeout(() => {
                closeCalorieModal();
                saveButton.innerHTML = '<span>Save</span>';
                saveButton.disabled = false;
            }, 600);
        }

        // Load saved goals from localStorage
        function loadSavedGoals() {
            // Load macro goals
            const savedMacroGoals = localStorage.getItem('macroGoals');
            if (savedMacroGoals) {
                const goals = JSON.parse(savedMacroGoals);
                updateMacroTexts(goals.protein, goals.carbs, goals.fats);

                // Update modal inputs
                document.getElementById('macroProteinInput').value = goals.protein;
                document.getElementById('macroCarbsInput').value = goals.carbs;
                document.getElementById('macroFatsInput').value = goals.fats;
            }

            // Load calorie goal
            const savedCalorieGoal = localStorage.getItem('calorieGoal');
            if (savedCalorieGoal) {
                const calorieGoal = parseInt(savedCalorieGoal);
                updateCalorieText(calorieGoal);

                // Update modal input
                document.getElementById('calorieGoalInput').value = calorieGoal;
            }
        }

        function initializeCharts() {
            if (chartsInitialized) {
                return; // Don't reinitialize charts
            }

            // Load any saved goals first
            loadSavedGoals();

            // Calculate progress percentages with actual data from Livewire
            const mealsProgress = {{ $stats['meals_logged'] ?? 0 }} / 5 * 100;

            // Use saved goals or default values
            const savedMacroGoals = localStorage.getItem('macroGoals');
            const savedCalorieGoal = localStorage.getItem('calorieGoal');

            const proteinGoal = savedMacroGoals ? JSON.parse(savedMacroGoals).protein : {{ $proteinGoal }};
            const carbsGoal = savedMacroGoals ? JSON.parse(savedMacroGoals).carbs : {{ $carbsGoal }};
            const fatsGoal = savedMacroGoals ? JSON.parse(savedMacroGoals).fats : {{ $fatsGoal }};
            const calorieGoal = savedCalorieGoal ? parseInt(savedCalorieGoal) : {{ $calorieGoal }};

            const carbsProgress = {{ $carbs }} / carbsGoal * 100;
            const fatsProgress = {{ $fats }} / fatsGoal * 100;
            const proteinProgress = {{ $protein }} / proteinGoal * 100;
            const calorieProgress = {{ $caloriesIn }} / calorieGoal * 100;

            // Common chart configuration for equal sizing
            const commonChartConfig = {
                type: "doughnut",
                options: {
                    plugins: {
                        legend: { display: false }
                    },
                    rotation: -90,
                    circumference: 360,
                    responsive: true,
                    maintainAspectRatio: true,
                    cutout: '70%',
                    elements: {
                        arc: {
                            borderWidth: 0
                        }
                    }
                }
            };

            // Logging Progress Arc (different style)
            try {
                progressChart = new Chart(document.getElementById("curvedProgressArc"), {
                    type: "doughnut",
                    data: {
                        datasets: [{
                            data: [mealsProgress, 100 - mealsProgress],
                            backgroundColor: ["#1C7C6E", "#F1F5F9"],
                            borderWidth: 0,
                            cutout: "85%"
                        }]
                    },
                    options: {
                        rotation: 270,
                        circumference: 180,
                        plugins: {
                            legend: { display: false },
                            tooltip: { enabled: false }
                        },
                        responsive: true,
                        maintainAspectRatio: false
                    }
                });
            } catch (e) {
                console.log('Progress chart already initialized');
            }

            // Macro charts - all same size and style
            try {
                carbsChartInstance = new Chart(document.getElementById("carbsChart"), {
                    ...commonChartConfig,
                    data: {
                        datasets: [{
                            data: [Math.min(carbsProgress, 100), 100 - Math.min(carbsProgress, 100)],
                            backgroundColor: ["#3B82F6", "#F3F4F6"],
                            borderWidth: 0
                        }]
                    }
                });
            } catch (e) {
                console.log('Carbs chart already initialized');
            }

            try {
                fatsChartInstance = new Chart(document.getElementById("fatsChart"), {
                    ...commonChartConfig,
                    data: {
                        datasets: [{
                            data: [Math.min(fatsProgress, 100), 100 - Math.min(fatsProgress, 100)],
                            backgroundColor: ["#F59E0B", "#F3F4F6"],
                            borderWidth: 0
                        }]
                    }
                });
            } catch (e) {
                console.log('Fats chart already initialized');
            }

            try {
                proteinChartInstance = new Chart(document.getElementById("proteinChart"), {
                    ...commonChartConfig,
                    data: {
                        datasets: [{
                            data: [Math.min(proteinProgress, 100), 100 - Math.min(proteinProgress, 100)],
                            backgroundColor: ["#10B981", "#F3F4F6"],
                            borderWidth: 0
                        }]
                    }
                });
            } catch (e) {
                console.log('Protein chart already initialized');
            }

            try {
                calorieChartInstance = new Chart(document.getElementById("calorieChart"), {
                    ...commonChartConfig,
                    data: {
                        datasets: [{
                            data: [Math.min(calorieProgress, 100), 100 - Math.min(calorieProgress, 100)],
                            backgroundColor: ["#1C7C6E", "#F3F4F6"],
                            borderWidth: 0
                        }]
                    }
                });
            } catch (e) {
                console.log('Calorie chart already initialized');
            }

            chartsInitialized = true;

            // Update calorie text
            updateCalorieText(calorieGoal);
            updateMacroTexts(proteinGoal, carbsGoal, fatsGoal);
        }

        // Function to update macro texts
        function updateMacroTexts(proteinGoal, carbsGoal, fatsGoal) {
            // Update goal texts
            document.getElementById('proteinGoalText').textContent = proteinGoal;
            document.getElementById('carbsGoalText').textContent = carbsGoal;
            document.getElementById('fatsGoalText').textContent = fatsGoal;

            // Update remaining values
            document.getElementById('proteinRemaining').textContent = Math.max(0, proteinGoal - {{ $protein }});
            document.getElementById('carbsRemaining').textContent = Math.max(0, carbsGoal - {{ $carbs }});
            document.getElementById('fatsRemaining').textContent = Math.max(0, fatsGoal - {{ $fats }});

            // Update charts
            updateMacroCharts(proteinGoal, carbsGoal, fatsGoal);
        }

        // Function to update calorie text
        function updateCalorieText(calorieGoal) {
            document.getElementById('calorieGoalText').textContent = calorieGoal;
            document.getElementById('caloriesRemainingText').textContent = Math.max(0, calorieGoal - {{ $caloriesIn }});
            document.getElementById('caloriesConsumedFooter').textContent = {{ $caloriesIn }};

            // Update calorie chart
            updateCalorieChart(calorieGoal);
        }

        // Function to update macro charts
        function updateMacroCharts(proteinGoal, carbsGoal, fatsGoal) {
            if (!carbsChartInstance || !fatsChartInstance || !proteinChartInstance) {
                return;
            }

            const carbsProgress = {{ $carbs }} / carbsGoal * 100;
            const fatsProgress = {{ $fats }} / fatsGoal * 100;
            const proteinProgress = {{ $protein }} / proteinGoal * 100;

            carbsChartInstance.data.datasets[0].data = [Math.min(carbsProgress, 100), 100 - Math.min(carbsProgress, 100)];
            fatsChartInstance.data.datasets[0].data = [Math.min(fatsProgress, 100), 100 - Math.min(fatsProgress, 100)];
            proteinChartInstance.data.datasets[0].data = [Math.min(proteinProgress, 100), 100 - Math.min(proteinProgress, 100)];

            carbsChartInstance.update('none');
            fatsChartInstance.update('none');
            proteinChartInstance.update('none');
        }

        // Function to update calorie chart
        function updateCalorieChart(calorieGoal) {
            if (!calorieChartInstance) {
                return;
            }

            const calorieProgress = {{ $caloriesIn }} / calorieGoal * 100;
            calorieChartInstance.data.datasets[0].data = [Math.min(calorieProgress, 100), 100 - Math.min(calorieProgress, 100)];
            calorieChartInstance.update('none');
        }

        // Initialize charts when page loads
        document.addEventListener('DOMContentLoaded', function() {
            initializeCharts();
        });

        // Carousel animation + dots
        const carousel = document.getElementById('cardCarousel');
        const cards = carousel.querySelectorAll('.carousel-card');
        const dots = document.querySelectorAll('#carouselDots .dot');

        function updateActiveCard() {
            const carouselCenter = carousel.scrollLeft + carousel.offsetWidth / 2;
            cards.forEach((card, index) => {
                const cardCenter = card.offsetLeft + card.offsetWidth / 2;
                const distance = Math.abs(carouselCenter - cardCenter);
                const scale = Math.max(0.9, 1 - distance / 800);
                card.style.transform = `scale(${scale})`;
                if (distance < card.offsetWidth / 2) {
                    dots.forEach(dot => dot.classList.remove('active'));
                    dots[index].classList.add('active');
                }
            });
        }

        if (carousel) {
            carousel.addEventListener('scroll', updateActiveCard);
            window.addEventListener('resize', updateActiveCard);
            updateActiveCard();
        }

        // Close modals when clicking outside
        document.addEventListener('click', function(event) {
            const macroModal = document.getElementById('macroModal');
            const calorieModal = document.getElementById('calorieModal');

            if (event.target === macroModal) {
                closeMacroModal();
            }
            if (event.target === calorieModal) {
                closeCalorieModal();
            }
        });
    </script>

    <style>
        .carousel {
            scroll-snap-type: x mandatory;
            -webkit-overflow-scrolling: touch;
            overflow-x: auto;
            gap: 1rem;
            padding: 1rem 0;
        }
        .carousel::-webkit-scrollbar {
            display: none;
        }
        .carousel-card {
            scroll-snap-align: start;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border-radius: 1rem;
        }
        canvas {
            width: 100% !important;
            height: 100% !important;
        }
        .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background-color: #D1D5DB;
            transition: all 0.3s ease;
        }
        .dot.active {
            width: 8px;
            height: 8px;
            background-color: #1C7C6E;
        }

        /* Ensure all doughnut charts have the same size */
        #carbsChart, #fatsChart, #proteinChart, #calorieChart {
            width: 100% !important;
            height: 100% !important;
            max-width: 120px;
            max-height: 120px;
        }

        @media (min-width: 768px) {
            #carbsChart, #fatsChart, #proteinChart, #calorieChart {
                max-width: 140px;
                max-height: 140px;
            }
        }

        @media (min-width: 1024px) {
            #carbsChart, #fatsChart, #proteinChart, #calorieChart {
                max-width: 160px;
                max-height: 160px;
            }
        }
    </style>
</div>
