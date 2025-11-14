<script src="https://cdn.tailwindcss.com"></script>
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
    /* Custom styles to handle chart height on smaller screens and ensure smooth carousel behavior */
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
    /* Add smooth transition to the scroll indicator dot */
    .dot.active {
        background-color: #3b82f6; /* Blue-500 equivalent */
        width: 10px;
    }
</style>

<div class="min-h-screen bg-gray-100 font-sans">

    <!-- Assume the following variables are defined in your backend/framework context (e.g., Blade in Laravel): -->
    <!-- $stats: array containing meals_logged, protein_consumed, workouts_logged -->
    <!-- $carbs, $fats, $protein: current consumed macros -->
    <!-- $carbsGoal, $fatsGoal, $proteinGoal: daily macro goals -->
    <!-- $caloriesIn: current calories consumed -->
    <!-- $calorieGoal: daily calorie goal -->
    <!-- auth()->user()->username: The current user's name -->
    <!-- route('...'): Your application's route helper -->

    <!-- ========================================================================= -->
    <!--                               MOBILE LAYOUT (md:hidden)                   -->
    <!-- ========================================================================= -->

    <div class="md:hidden">
        <!-- ===== MOBILE HEADER - Compact Version ===== -->


        <!-- Mobile Navigation (Fixed Bottom) -->
        <nav class="bg-white border-t border-gray-200 fixed bottom-0 left-0 right-0 z-40">
            <div class="flex justify-around items-center h-16">
                <!-- Links using Mock Route Names -->
                <a href="#" class="flex flex-col items-center justify-center px-3 py-2 text-indigo-600 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    <span class="text-xs mt-1">Dashboard</span>
                </a>
                <a href="#" class="flex flex-col items-center justify-center px-3 py-2 text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    <span class="text-xs mt-1">Workouts</span>
                </a>
                <a href="#" class="flex flex-col items-center justify-center px-3 py-2 text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span class="text-xs mt-1">Meals</span>
                </a>
                <a href="#" class="flex flex-col items-center justify-center px-3 py-2 text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    <span class="text-xs mt-1">Diary</span>
                </a>
                <a href="#" class="flex flex-col items-center justify-center px-3 py-2 text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    <span class="text-xs mt-1">Progress</span>
                </a>
            </div>
        </nav>

        <!-- Main Content for Mobile -->
        <div class="flex flex-col items-center p-4 space-y-4 overflow-x-hidden pb-20">
            <!-- === LOGGING PROGRESS CARD (Mobile Version) === -->
            <a href="#" class="block w-full max-w-sm lg:max-w-md">
                <div class="carousel-card relative bg-white rounded-2xl shadow-sm p-4 flex flex-col items-center w-full snap-start flex-shrink-0 cursor-pointer">
                    <h2 class="text-lg font-semibold text-center text-gray-700 mb-2">Logging Progress</h2>
                    <p class="text-center font-semibold text-green-600 text-base mb-3">Crushing it!</p>
                    <div class="w-32 h-32 relative">
                        <canvas id="curvedProgressArc"></canvas>
                        <div class="absolute inset-0 flex flex-col items-center justify-center">
                            <span class="text-lg font-bold text-gray-800">3 / 4 Meals</span>
                            <span class="text-sm text-gray-500 mt-0.5">Logged</span>
                        </div>
                    </div>
                    <p class="text-xs text-center mt-4 text-gray-600 leading-snug">
                        You've logged <span class="font-bold">3 meals</span> and
                        <span class="font-bold">120g of protein</span>.
                    </p>
                </div>
            </a>
            <!-- === CAROUSEL CONTAINER (Mobile Only) === -->
            <div class="carousel-container relative w-full max-w-6xl">
                <div id="cardCarousel" class="carousel flex overflow-x-auto gap-4 p-4 scroll-smooth snap-x snap-mandatory">
                    <!-- MACRO CARD (Mobile Version) -->
                    <div class="carousel-card relative bg-white rounded-2xl shadow-sm p-4 flex flex-col items-center w-full max-w-sm snap-start flex-shrink-0 cursor-pointer"
                        onclick="openMacroModal()">
                        <h2 class="text-lg font-semibold mb-4 text-center">MACRO</h2>
                        <div class="flex justify-around w-full gap-2">
                            <!-- CARBS -->
                            <div class="flex flex-col items-center relative">
                                <p class="text-sm font-semibold mb-2" style="color: #3B82F6;">Carbs</p>
                                <div class="relative flex items-center justify-center">
                                    <canvas id="carbsChart" class="w-20 h-20"></canvas>
                                    <div class="absolute flex flex-col items-center justify-center">
                                        <p class="text-base font-bold text-gray-800 leading-tight" id="carbsRemaining">150</p>
                                        <p class="text-xs text-gray-500 mt-0.5">Remaining</p>
                                    </div>
                                </div>
                                <p class="text-xs text-gray-600 mt-1">Goal: <span id="carbsGoalText">200</span>g</p>
                            </div>
                            <!-- FATS -->
                            <div class="flex flex-col items-center relative">
                                <p class="text-sm font-semibold mb-2" style="color: #F59E0B;">Fats</p>
                                <div class="relative flex items-center justify-center">
                                    <canvas id="fatsChart" class="w-20 h-20"></canvas>
                                    <div class="absolute flex flex-col items-center justify-center">
                                        <p class="text-base font-bold text-gray-800 leading-tight" id="fatsRemaining">45</p>
                                        <p class="text-xs text-gray-500 mt-0.5">Remaining</p>
                                    </div>
                                </div>
                                <p class="text-xs text-gray-600 mt-1">Goal: <span id="fatsGoalText">60</span>g</p>
                            </div>
                            <!-- PROTEIN -->
                            <div class="flex flex-col items-center relative">
                                <p class="text-sm font-semibold mb-2" style="color: #10B981;">Protein</p>
                                <div class="relative flex items-center justify-center">
                                    <canvas id="proteinChart" class="w-20 h-20"></canvas>
                                    <div class="absolute flex flex-col items-center justify-center">
                                        <p class="text-base font-bold text-gray-800 leading-tight" id="proteinRemaining">100</p>
                                        <p class="text-xs text-gray-500 mt-0.5">Remaining</p>
                                    </div>
                                </div>
                                <p class="text-xs text-gray-600 mt-1">Goal: <span id="proteinGoalText">150</span>g</p>
                            </div>
                        </div>
                    </div>
                    <!-- CALORIE GOAL CARD (Mobile Version) -->
                    <div class="carousel-card relative bg-white rounded-2xl shadow-sm p-4 flex flex-col items-center w-full max-w-sm snap-start flex-shrink-0 cursor-pointer"
                        onclick="openCalorieModal()">
                        <h2 class="text-lg font-semibold mb-4 text-center">Calorie Goal</h2>
                        <div class="relative w-32 h-32 flex items-center justify-center">
                            <canvas id="calorieChart" class="w-full h-full"></canvas>
                            <div class="absolute inset-0 flex flex-col items-center justify-center text-center">
                                <span id="caloriesRemainingText" class="text-lg font-bold text-gray-800 leading-none">1500</span>
                                <span class="text-sm text-gray-500 mt-1">Remaining</span>
                            </div>
                        </div>
                        <div class="flex justify-between mt-4 w-full text-xs px-2">
                            <span>Goal: <strong id="calorieGoalText">2000</strong> kcal</span>
                            <span>Consumed: <strong id="caloriesConsumedFooter">500</strong> kcal</span>
                        </div>
                    </div>
                </div>
                <!-- DOT INDICATORS -->
                <div id="carouselDots" class="flex justify-center mt-4 space-x-2">
                    <span class="dot w-2.5 h-2.5 bg-gray-300 rounded-full active"></span>
                    <span class="dot w-2.5 h-2.5 bg-gray-300 rounded-full"></span>
                </div>
            </div>
            <!-- === BOTTOM CARDS CONTAINER (Steps & Exercise) === -->
            <div class="w-full max-w-6xl mx-auto flex gap-4 p-4">
                <!-- === Steps Card (Mobile Version) === -->
                <div x-data="{ open: false, dontTrack: false }" class="flex-1">
                    <div
                        @click="open = true"
                        class="bg-white rounded-2xl shadow-md p-4 flex flex-col justify-center cursor-pointer h-32">
                        <div class="text-center">
                            <p class="text-gray-800 font-semibold text-lg mb-1">Steps</p>
                            <p class="text-gray-500 text-sm">Connect to track steps</p>
                        </div>
                    </div>
                    <!-- Steps Modal (Mobile) -->
                    <div x-show="open" x-transition class="fixed inset-0 bg-black/30 flex items-center justify-center z-50 p-4">
                        <div @click.away="open = false" class="bg-white rounded-2xl p-6 w-full max-w-sm shadow-lg space-y-4">
                            <h2 class="text-lg font-semibold text-gray-800 text-center">Track Steps</h2>
                            <button
                                class="w-full flex items-center justify-center gap-2 bg-blue-500 text-white px-4 py-3 rounded-xl hover:bg-blue-600 transition text-sm">
                                <span class="text-xl font-bold">+</span> Add Device
                            </button>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" x-model="dontTrack" class="w-4 h-4 rounded border-gray-300">
                                <span class="text-gray-700 text-sm">Don't track steps</span>
                            </label>
                            <button @click="open = false" class="w-full text-center text-gray-500 hover:text-gray-700 text-sm">Cancel</button>
                        </div>
                    </div>
                </div>
                <!-- === Exercise Card (Mobile Version) === -->
                <div x-data="{ open: false }" class="flex-1 relative">
                    <div
                        class="bg-white rounded-2xl shadow-md p-4 flex flex-col justify-center cursor-pointer h-32">
                        <!-- Header with Exercise text and + icon -->
                        <div class="flex items-center justify-between mb-2">
                            <p @click="window.location.href='#'" class="text-gray-800 font-semibold text-lg m-0 cursor-pointer">Exercise</p>
                            <button @click.stop="open = true" class="text-2xl font-extrabold text-gray-800 leading-none">+</button>
                        </div>
                        <!-- Card details -->
                        <div class="text-center">
                            <p @click="window.location.href='#'" class="text-gray-500 text-sm mb-1 cursor-pointer">300 kcal</p>
                            <p @click="window.location.href='#'" class="text-gray-400 text-xs cursor-pointer">1 workout logged</p>
                        </div>
                    </div>
                    <!-- Exercise Modal (Mobile) -->
                    <div x-show="open" x-transition class="fixed inset-0 bg-black/30 flex items-center justify-center z-50 p-4">
                        <div @click.away="open = false" class="bg-white rounded-2xl p-6 w-full max-w-sm shadow-lg space-y-4">
                            <h2 class="text-lg font-semibold text-gray-800 text-center">Exercises</h2>
                            <!-- Exercise Choices -->
                            <div class="flex flex-col gap-3">
                                <a href="#" class="flex items-center gap-2 cursor-pointer hover:bg-gray-50 p-2 rounded">
                                    <input type="radio" name="exerciseType" value="cardiovascular" class="w-4 h-4 text-green-500">
                                    <span class="text-gray-800 font-medium text-sm">Cardiovascular</span>
                                </a>
                                <a href="#" class="flex items-center gap-2 cursor-pointer hover:bg-gray-50 p-2 rounded">
                                    <input type="radio" name="exerciseType" value="strength" class="w-4 h-4 text-yellow-500">
                                    <span class="text-gray-800 font-medium text-sm">Strength</span>
                                </a>
                            </div>
                            <button @click="open = false" class="w-full text-center text-gray-500 hover:text-gray-700 text-sm">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- ========================================================================= -->
    <!--                               DESKTOP LAYOUT (hidden md:flex)             -->
    <!-- ========================================================================= -->

    <div class="hidden md:flex min-h-screen bg-gray-100">



        <!-- ===== MAIN CONTENT AREA ===== -->
        <div class="flex-1 flex flex-col overflow-hidden">



            <!-- ===== DASHBOARD CARDS/WIDGETS AREA - SCROLLABLE CONTENT ===== -->
            <main class="flex-1 overflow-y-auto bg-gray-100 p-6 lg:p-8 z-0">

                <!-- DESKTOP STATS GRID (Simple Counters) -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-white rounded-2xl shadow-lg p-6 text-center border-t-4 border-green-500">
                        <div class="text-4xl font-extrabold text-green-600">3</div>
                        <div class="text-sm text-gray-600 mt-1">Meals Logged Today</div>
                    </div>
                    <div class="bg-white rounded-2xl shadow-lg p-6 text-center border-t-4 border-blue-500">
                        <div class="text-4xl font-extrabold text-blue-600">1</div>
                        <div class="text-sm text-gray-600 mt-1">Workouts Logged</div>
                    </div>
                    <div class="bg-white rounded-2xl shadow-lg p-6 text-center border-t-4 border-purple-500">
                        <div class="text-4xl font-extrabold text-purple-600">120g</div>
                        <div class="text-sm text-gray-600 mt-1">Protein Consumed</div>
                    </div>
                </div>

                <!-- MAIN METRICS GRID (4-Column Layout) -->
                <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-4 gap-6">

                    <!-- 1. LOGGING PROGRESS CARD (Desktop Grid Item) -->
                    <a href="#" class="block">
                        <div class="bg-white rounded-2xl shadow-xl p-6 flex flex-col items-center h-full hover:shadow-2xl transition duration-300">
                            <h2 class="text-xl font-bold text-center text-gray-800 mb-3">Logging Progress</h2>
                            <p class="text-center font-semibold text-green-600 text-lg mb-4">Crushing it!</p>
                            <div class="w-36 h-36 relative">
                                <canvas id="curvedProgressArcDesktop"></canvas>
                                <div class="absolute inset-0 flex flex-col items-center justify-center">
                                    <span class="text-xl font-bold text-gray-800">3 / 4 Meals</span>
                                    <span class="text-sm text-gray-500 mt-0.5">Logged</span>
                                </div>
                            </div>
                            <p class="text-sm text-center mt-4 text-gray-600 leading-snug">
                                Log your meals to track your nutrition and hit your daily goals.
                            </p>
                        </div>
                    </a>

                    <!-- 2. MACRO CARD (Desktop Grid Item) -->
                    <div class="bg-white rounded-2xl shadow-xl p-6 flex flex-col items-center h-full cursor-pointer hover:shadow-2xl transition duration-300"
                        onclick="openMacroModal()">
                        <h2 class="text-xl font-bold mb-6 text-center">MACRO</h2>
                        <div class="flex justify-around w-full gap-4">
                            <!-- CARBS -->
                            <div class="flex flex-col items-center relative">
                                <p class="text-base font-semibold mb-3" style="color: #3B82F6;">Carbs</p>
                                <div class="relative w-24 h-24 flex items-center justify-center">
                                    <canvas id="carbsChartDesktop"></canvas>
                                    <div class="absolute flex flex-col items-center justify-center">
                                        <p class="text-lg font-bold text-gray-800 leading-tight" id="carbsRemainingDesktop">150</p>
                                        <p class="text-xs text-gray-500 mt-0.5">Remaining</p>
                                    </div>
                                </div>
                                <p class="text-xs text-gray-600 mt-1">Goal: <span id="carbsGoalTextDesktop">200</span>g</p>
                            </div>
                            <!-- FATS -->
                            <div class="flex flex-col items-center relative">
                                <p class="text-base font-semibold mb-3" style="color: #F59E0B;">Fats</p>
                                <div class="relative w-24 h-24 flex items-center justify-center">
                                    <canvas id="fatsChartDesktop"></canvas>
                                    <div class="absolute flex flex-col items-center justify-center">
                                        <p class="text-lg font-bold text-gray-800 leading-tight" id="fatsRemainingDesktop">45</p>
                                        <p class="text-xs text-gray-500 mt-0.5">Remaining</p>
                                    </div>
                                </div>
                                <p class="text-xs text-gray-600 mt-1">Goal: <span id="fatsGoalTextDesktop">60</span>g</p>
                            </div>
                            <!-- PROTEIN -->
                            <div class="flex flex-col items-center relative">
                                <p class="text-base font-semibold mb-3" style="color: #10B981;">Protein</p>
                                <div class="relative w-24 h-24 flex items-center justify-center">
                                    <canvas id="proteinChartDesktop"></canvas>
                                    <div class="absolute flex flex-col items-center justify-center">
                                        <p class="text-lg font-bold text-gray-800 leading-tight" id="proteinRemainingDesktop">100</p>
                                        <p class="text-xs text-gray-500 mt-0.5">Remaining</p>
                                    </div>
                                </div>
                                <p class="text-xs text-gray-600 mt-1">Goal: <span id="proteinGoalTextDesktop">150</span>g</p>
                            </div>
                        </div>
                    </div>

                    <!-- 3. CALORIE GOAL CARD (Desktop Grid Item) -->
                    <div class="bg-white rounded-2xl shadow-xl p-6 flex flex-col items-center h-full cursor-pointer hover:shadow-2xl transition duration-300"
                        onclick="openCalorieModal()">
                        <h2 class="text-xl font-bold mb-6 text-center">Calorie Goal</h2>
                        <div class="relative w-36 h-36 flex items-center justify-center">
                            <canvas id="calorieChartDesktop" class="w-full h-full"></canvas>
                            <div class="absolute inset-0 flex flex-col items-center justify-center text-center">
                                <span id="caloriesRemainingTextDesktop" class="text-xl font-bold text-gray-800 leading-none">1500</span>
                                <span class="text-sm text-gray-500 mt-1">Remaining</span>
                            </div>
                        </div>
                        <div class="flex justify-between mt-6 w-full text-base px-2">
                            <span>Goal: <strong id="calorieGoalTextDesktop">2000</strong> kcal</span>
                            <span>Consumed: <strong id="caloriesConsumedFooterDesktop">500</strong> kcal</span>
                        </div>
                    </div>

                    <!-- 4. QUICK ACTIONS & STEP TRACKER (Combined) -->
                    <div class="space-y-6">
                        <!-- QUICK ACTIONS -->
                        <div class="bg-white rounded-2xl shadow-xl p-6 h-full">
                            <h3 class="text-xl font-bold mb-4 text-center text-gray-800">Quick Log</h3>
                            <div class="grid grid-cols-2 gap-4">
                                <a href="#"
                                    class="bg-indigo-600 text-white py-3 px-4 rounded-xl text-center font-semibold hover:bg-indigo-700 transition duration-200 flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Meal
                                </a>
                                <a href="#"
                                    class="bg-green-600 text-white py-3 px-4 rounded-xl text-center font-semibold hover:bg-green-700 transition duration-200 flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                    </svg>
                                    Workout
                                </a>
                            </div>
                        </div>

                        <!-- STEPS CARD (Reusing x-data logic) -->
                        <div x-data="{ open: false, dontTrack: false }" class="bg-white rounded-2xl shadow-xl p-6 h-full cursor-pointer hover:shadow-2xl transition duration-300">
                            <div @click="open = true" class="flex flex-col justify-center h-full">
                                <div class="text-center">
                                    <p class="text-gray-800 font-bold text-xl mb-1">Steps</p>
                                    <p class="text-gray-500 text-sm">Connect to track steps</p>
                                </div>
                            </div>
                            <!-- Steps Modal for Desktop (Hidden by default) -->
                            <div x-show="open" x-transition class="fixed inset-0 bg-black/30 flex items-center justify-center z-50 p-4">
                                <div @click.away="open = false" class="bg-white rounded-2xl p-6 w-full max-w-sm shadow-lg space-y-4">
                                    <h2 class="text-lg font-semibold text-gray-800 text-center">Track Steps</h2>
                                    <button class="w-full flex items-center justify-center gap-2 bg-blue-500 text-white px-4 py-3 rounded-xl hover:bg-blue-600 transition text-sm">
                                        <span class="text-xl font-bold">+</span> Add Device
                                    </button>
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="checkbox" x-model="dontTrack" class="w-4 h-4 rounded border-gray-300">
                                        <span class="text-gray-700 text-sm">Don't track steps</span>
                                    </label>
                                    <button @click="open = false" class="w-full text-center text-gray-500 hover:text-gray-700 text-sm">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- EXERCISE CARD (Larger Widget) -->
                <div x-data="{ open: false }" class="mt-8 bg-white rounded-2xl shadow-xl p-6 hover:shadow-2xl transition duration-300 relative">
                    <div class="flex items-center justify-between mb-4">
                        <p @click="window.location.href='#'" class="text-2xl font-bold text-gray-800 m-0 cursor-pointer">Exercise Overview</p>
                        <button @click.stop="open = true" class="text-3xl font-extrabold text-indigo-600 hover:text-indigo-700 transition leading-none p-2 rounded-full hover:bg-indigo-50">+</button>
                    </div>

                    <div class="flex justify-around items-center py-4">
                        <div class="text-center">
                            <p class="text-4xl font-extrabold text-blue-600">300</p>
                            <p class="text-lg text-gray-500 mt-1">Calories Burned</p>
                        </div>
                         <div class="text-center">
                            <p class="text-4xl font-extrabold text-green-600">1</p>
                            <p class="text-lg text-gray-500 mt-1">Workouts Logged</p>
                        </div>
                    </div>
                    <!-- Exercise Modal for Desktop (Hidden by default) -->
                    <div x-show="open" x-transition class="fixed inset-0 bg-black/30 flex items-center justify-center z-50 p-4">
                        <div @click.away="open = false" class="bg-white rounded-2xl p-6 w-full max-w-sm shadow-lg space-y-4">
                            <h2 class="text-lg font-semibold text-gray-800 text-center">Exercises</h2>
                            <div class="flex flex-col gap-3">
                                <a href="#" class="flex items-center gap-2 cursor-pointer hover:bg-gray-50 p-2 rounded">
                                    <input type="radio" name="exerciseType" value="cardiovascular" class="w-4 h-4 text-green-500">
                                    <span class="text-gray-800 font-medium text-sm">Cardiovascular</span>
                                </a>
                                <a href="#" class="flex items-center gap-2 cursor-pointer hover:bg-gray-50 p-2 rounded">
                                    <input type="radio" name="exerciseType" value="strength" class="w-4 h-4 text-yellow-500">
                                    <span class="text-gray-800 font-medium text-sm">Strength</span>
                                </a>
                            </div>
                            <button @click="open = false" class="w-full text-center text-gray-500 hover:text-gray-700 text-sm">Cancel</button>
                        </div>
                    </div>
                </div>

                <!-- PLACEHOLDER FOR LARGE CHART/TABLE - Content Removed to Prevent Blocking -->


            </main>
        </div>
    </div>

    <!-- ========================================================================= -->
    <!--                               MODALS (Shared)                             -->
    <!-- ========================================================================= -->

    <!-- Macro Goals Modal -->
    <div id="macroModal" class="fixed inset-0 bg-black/30 flex items-center justify-center z-50 p-4 hidden">
        <div class="bg-white rounded-2xl p-6 w-full max-w-sm md:max-w-md shadow-lg space-y-4">
            <h2 class="text-lg md:text-xl font-semibold text-gray-800 text-center">Edit Macro Goals</h2>
            <div class="space-y-3">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Protein (g)</label>
                    <input type="number" id="macroProteinInput" value="150" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Carbs (g)</label>
                    <input type="number" id="macroCarbsInput" value="200" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Fats (g)</label>
                    <input type="number" id="macroFatsInput" value="60" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500">
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
                <input type="number" id="calorieGoalInput" value="2000" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
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
    <script>
        // Mock data initialization
        let goals = {
            protein: 150, carbs: 200, fats: 60, calorie: 2000
        };
        let consumed = {
            protein: 50, carbs: 50, fats: 15, calorie: 500, meals: 3
        };

        let charts = {};

        // Modal Functions
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

        // Helper function to update text elements across mobile/desktop
        function updateText(prefix, macro, remaining, goal) {
            const elements = [
                { id: `${prefix}Remaining`, value: remaining },
                { id: `${prefix}GoalText`, value: goal },
                { id: `${prefix}RemainingDesktop`, value: remaining },
                { id: `${prefix}GoalTextDesktop`, value: goal },
            ];

            elements.forEach(el => {
                const domEl = document.getElementById(el.id);
                if (domEl) {
                    domEl.textContent = el.value;
                }
            });
        }

        // Save Macro Goals (Mock Update)
        function saveMacroGoals() {
            goals.protein = parseInt(document.getElementById('macroProteinInput').value) || 0;
            goals.carbs = parseInt(document.getElementById('macroCarbsInput').value) || 0;
            goals.fats = parseInt(document.getElementById('macroFatsInput').value) || 0;
            updateAllCharts();
            closeMacroModal();
        }

        // Save Calorie Goal (Mock Update)
        function saveCalorieGoal() {
            goals.calorie = parseInt(document.getElementById('calorieGoalInput').value) || 0;
            updateAllCharts();
            closeCalorieModal();
        }

        // Chart Initialization Logic
        function initChart(ctxId, dataConsumed, dataGoal, color) {
            const ctx = document.getElementById(ctxId);
            if (!ctx) return null;

            const remaining = Math.max(0, dataGoal - dataConsumed);
            const consumedPct = Math.min(100, (dataConsumed / dataGoal) * 100);

            const data = {
                datasets: [{
                    data: [consumedPct, 100 - consumedPct],
                    backgroundColor: [color, '#e5e7eb'],
                    borderWidth: 0,
                    borderRadius: 5,
                }]
            };

            return new Chart(ctx, {
                type: 'doughnut',
                data: data,
                options: {
                    rotation: -90,
                    circumference: 180,
                    cutout: '80%',
                    plugins: {
                        legend: { display: false },
                        tooltip: { enabled: false },
                    },
                    responsive: true,
                    maintainAspectRatio: false,
                }
            });
        }

        // Radial Progress Chart Initialization
        function initProgressChart(ctxId) {
            const ctx = document.getElementById(ctxId);
            if (!ctx) return null;

            const mealsLogged = consumed.meals;
            const maxMeals = 4;
            const percentage = Math.min(100, (mealsLogged / maxMeals) * 100);

            const data = {
                datasets: [{
                    data: [percentage, 100 - percentage],
                    backgroundColor: ['#10B981', '#e5e7eb'],
                    borderWidth: 0,
                    borderRadius: 10,
                }]
            };

            return new Chart(ctx, {
                type: 'doughnut',
                data: data,
                options: {
                    cutout: '80%',
                    plugins: { legend: { display: false }, tooltip: { enabled: false } },
                    responsive: true,
                    maintainAspectRatio: false,
                }
            });
        }

        // Calorie Chart Initialization
        function initCalorieChart(ctxId) {
            const ctx = document.getElementById(ctxId);
            if (!ctx) return null;

            const remaining = Math.max(0, goals.calorie - consumed.calorie);
            const consumedPct = Math.min(100, (consumed.calorie / goals.calorie) * 100);

            const data = {
                datasets: [{
                    data: [consumedPct, 100 - consumedPct],
                    backgroundColor: ['#f97316', '#e5e7eb'],
                    borderWidth: 0,
                    borderRadius: 10,
                }]
            };

            return new Chart(ctx, {
                type: 'doughnut',
                data: data,
                options: {
                    cutout: '80%',
                    plugins: { legend: { display: false }, tooltip: { enabled: false } },
                    responsive: true,
                    maintainAspectRatio: false,
                }
            });
        }

        // Update Charts (Generic function to handle both mobile and desktop)
        function updateChartData(chartInstance, consumed, goal) {
            if (chartInstance) {
                const consumedPct = Math.min(100, (consumed / goal) * 100);
                chartInstance.data.datasets[0].data = [consumedPct, 100 - consumedPct];
                chartInstance.update();
            }
        }

        function updateAllCharts() {
            // Update Text (Mobile & Desktop)
            updateText('protein', 'Protein', Math.max(0, goals.protein - consumed.protein), goals.protein);
            updateText('carbs', 'Carbs', Math.max(0, goals.carbs - consumed.carbs), goals.carbs);
            updateText('fats', 'Fats', Math.max(0, goals.fats - consumed.fats), goals.fats);

            // Update Calorie Text
            updateText('caloriesRemainingText', 'Calorie', Math.max(0, goals.calorie - consumed.calorie), goals.calorie);
            updateText('caloriesConsumedFooter', 'Calorie', consumed.calorie, goals.calorie);

            // Update Charts
            updateChartData(charts.proteinChart, consumed.protein, goals.protein);
            updateChartData(charts.carbsChart, consumed.carbs, goals.carbs);
            updateChartData(charts.fatsChart, consumed.fats, goals.fats);
            updateChartData(charts.calorieChart, consumed.calorie, goals.calorie);

            updateChartData(charts.proteinChartDesktop, consumed.protein, goals.protein);
            updateChartData(charts.carbsChartDesktop, consumed.carbs, goals.carbs);
            updateChartData(charts.fatsChartDesktop, consumed.fats, goals.fats);
            updateChartData(charts.calorieChartDesktop, consumed.calorie, goals.calorie);

            // Progress chart is static for this example
            charts.progressChart?.update();
            charts.progressChartDesktop?.update();
        }

        // Initialize all charts on load
        function initializeCharts() {
            // Mobile Charts
            charts.progressChart = initProgressChart('curvedProgressArc');
            charts.carbsChart = initChart('carbsChart', consumed.carbs, goals.carbs, '#3B82F6');
            charts.fatsChart = initChart('fatsChart', consumed.fats, goals.fats, '#F59E0B');
            charts.proteinChart = initChart('proteinChart', consumed.protein, goals.protein, '#10B981');
            charts.calorieChart = initCalorieChart('calorieChart');

            // Desktop Charts
            charts.progressChartDesktop = initProgressChart('curvedProgressArcDesktop');
            charts.carbsChartDesktop = initChart('carbsChartDesktop', consumed.carbs, goals.carbs, '#3B82F6');
            charts.fatsChartDesktop = initChart('fatsChartDesktop', consumed.fats, goals.fats, '#F59E0B');
            charts.proteinChartDesktop = initChart('proteinChartDesktop', consumed.protein, goals.protein, '#10B981');
            charts.calorieChartDesktop = initCalorieChart('calorieChartDesktop');

            updateAllCharts();
        }

        // Carousel Logic (Mobile Only)
        document.addEventListener('DOMContentLoaded', () => {
            initializeCharts();
            const carousel = document.getElementById('cardCarousel');
            const dots = document.querySelectorAll('.dot');

            if (carousel && dots.length > 0) {
                const cardWidth = carousel.querySelector('.carousel-card').offsetWidth + 16; // Card width + gap (4 units = 16px)

                const updateDots = () => {
                    const scrollLeft = carousel.scrollLeft;
                    const currentIndex = Math.round(scrollLeft / cardWidth);

                    dots.forEach((dot, index) => {
                        dot.classList.toggle('active', index === currentIndex);
                    });
                };

                // Initial dot state
                updateDots();

                // Update dots on scroll
                carousel.addEventListener('scroll', updateDots);

                // Clicking dots scrolls the carousel (Optional)
                dots.forEach((dot, index) => {
                    dot.addEventListener('click', () => {
                        carousel.scrollTo({
                            left: index * cardWidth,
                            behavior: 'smooth'
                        });
                    });
                });
            }
        });

    </script>
</div>
