<div x-data class="min-h-screen bg-gray-50 flex flex-col items-center p-4 space-y-4 overflow-x-hidden">

    <!-- ===== HEADER ===== -->
    <header class="w-full max-w-6xl flex items-center justify-between px-4 py-3">
        <div class="flex items-center">
            <img src="/images/jastin.jpg" alt="Profile" class="w-10 h-10 md:w-12 md:h-12 rounded-full object-cover shadow-md">
        </div>

        <div class="flex-1 flex justify-center relative">
            <img src="/images/nutriquest-logo sm.png" alt="NutriQuest Logo" class="h-8 md:h-10 lg:h-12 object-contain drop-shadow-md">
        </div>

        <div class="flex items-center">
            <button @click="alert('Notifications clicked!')" class="relative">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 md:w-7 md:h-7 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3c0 .386-.145.738-.405 1.009L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
                <span class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] rounded-full w-3 h-3 flex items-center justify-center"></span>
            </button>
        </div>
    </header>

    <!-- ===== TODAY + EDIT ===== -->
    <div class="w-full max-w-6xl flex justify-between items-center px-2">
        <h1 class="text-xl md:text-2xl font-semibold text-gray-800">Today</h1>
        <button class="bg-gray-100 text-sm md:text-base px-4 py-1.5 md:py-2 rounded-full text-gray-600 hover:bg-gray-200 transition">Edit</button>
    </div>

    <!-- === LOGGING PROGRESS CARD === -->
    <div class="carousel-card relative bg-white rounded-2xl shadow-sm p-4 md:p-6 flex flex-col items-center w-full max-w-sm lg:max-w-md snap-start flex-shrink-0">
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
                <span class="text-lg md:text-xl font-bold text-gray-800">{{ $stats['meals_logged'] ?? 0 }} / 5 Meals</span>
                <span class="text-sm text-gray-500 mt-0.5">Logged</span>
            </div>
        </div>

        <p class="text-xs md:text-sm text-center mt-4 text-gray-600 leading-snug">
            You've logged <span class="font-bold">{{ $stats['meals_logged'] ?? 0 }} meals</span> and
            <span class="font-bold">{{ $stats['protein_consumed'] ?? 0 }}g of protein</span>.
        </p>
    </div>

    <!-- === CAROUSEL CONTAINER === -->
    <div class="carousel-container relative w-full max-w-6xl">
        <div id="cardCarousel" class="carousel flex overflow-x-auto gap-4 p-4 scroll-smooth snap-x snap-mandatory">
            <!-- MACRO CARD -->
            <div class="carousel-card relative bg-white rounded-2xl shadow-sm p-4 md:p-6 flex flex-col items-center w-full max-w-sm lg:max-w-md snap-start flex-shrink-0">
                <h2 class="text-lg md:text-xl font-semibold mb-4 md:mb-6 text-center">MACRO</h2>
                <div class="flex justify-around w-full gap-2 md:gap-4">
                    <!-- CARBS -->
                    <div class="flex flex-col items-center relative">
                        <p class="text-sm md:text-base font-semibold mb-2 md:mb-3" style="color: #3B82F6;">Carbs</p>
                        <div class="relative flex items-center justify-center">
                            <canvas id="carbsChart" class="w-20 h-20 md:w-24 md:h-24 lg:w-28 lg:h-28"></canvas>
                            <div class="absolute flex flex-col items-center justify-center">
                                <p class="text-base md:text-lg font-bold text-gray-800 leading-tight">{{ max(0, 250 - $carbs) }}</p>
                                <p class="text-xs text-gray-500 mt-0.5">Remaining</p>
                            </div>
                        </div>
                    </div>
                    <!-- FATS -->
                    <div class="flex flex-col items-center relative">
                        <p class="text-sm md:text-base font-semibold mb-2 md:mb-3" style="color: #F59E0B;">Fats</p>
                        <div class="relative flex items-center justify-center">
                            <canvas id="fatsChart" class="w-20 h-20 md:w-24 md:h-24 lg:w-28 lg:h-28"></canvas>
                            <div class="absolute flex flex-col items-center justify-center">
                                <p class="text-base md:text-lg font-bold text-gray-800 leading-tight">{{ max(0, 70 - $fats) }}</p>
                                <p class="text-xs text-gray-500 mt-0.5">Remaining</p>
                            </div>
                        </div>
                    </div>
                    <!-- PROTEIN -->
                    <div class="flex flex-col items-center relative">
                        <p class="text-sm md:text-base font-semibold mb-2 md:mb-3" style="color: #10B981;">Protein</p>
                        <div class="relative flex items-center justify-center">
                            <canvas id="proteinChart" class="w-20 h-20 md:w-24 md:h-24 lg:w-28 lg:h-28"></canvas>
                            <div class="absolute flex flex-col items-center justify-center">
                                <p class="text-base md:text-lg font-bold text-gray-800 leading-tight">{{ max(0, 150 - $protein) }}</p>
                                <p class="text-xs text-gray-500 mt-0.5">Remaining</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CALORIE GOAL CARD -->
            <div class="carousel-card relative bg-white rounded-2xl shadow-sm p-4 md:p-6 flex flex-col items-center w-full max-w-sm lg:max-w-md snap-start flex-shrink-0">
                <h2 class="text-lg md:text-xl font-semibold mb-4 md:mb-6 text-center">Calorie Goal</h2>
                <div class="relative w-32 h-32 md:w-36 md:h-36 lg:w-40 lg:h-40">
                    <canvas id="calorieChart"></canvas>
                    <div class="absolute inset-0 flex flex-col items-center justify-center">
                        <span id="caloriesRemainingText" class="text-lg md:text-xl font-bold text-gray-800">{{ max(0, 2000 - $caloriesIn) }}</span>
                        <span class="text-sm text-gray-500">Remaining</span>
                    </div>
                </div>
                <div class="flex justify-between mt-4 w-full text-xs md:text-sm px-2 md:px-4">
                    <span>Goal: <strong id="calorieGoal">2000</strong> kcal</span>
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
                class="bg-white rounded-2xl shadow-md p-4 md:p-6 flex flex-col justify-center cursor-pointer hover:shadow-lg transition h-32 md:h-40">

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
                class="bg-white rounded-2xl shadow-md p-4 md:p-6 flex flex-col justify-center cursor-pointer hover:shadow-lg transition h-32 md:h-40">

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

    <!-- === QUICK ACTIONS === -->
    <div class="w-full max-w-6xl mx-auto p-4">
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

    <!-- ===== SCRIPTS ===== -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Calculate progress percentages
        const mealsProgress = {{ $stats['meals_logged'] ?? 0 }} / 5 * 100;
        const carbsProgress = {{ $carbs }} / 250 * 100;
        const fatsProgress = {{ $fats }} / 70 * 100;
        const proteinProgress = {{ $protein }} / 150 * 100;
        const calorieProgress = {{ $caloriesIn }} / 2000 * 100;

        // Logging Progress Arc
        new Chart(document.getElementById("curvedProgressArc"), {
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

        // Macro charts
        function createMacroChart(id, color, value) {
            new Chart(document.getElementById(id), {
                type: "doughnut",
                data: { 
                    datasets: [{ 
                        data: [value, 100 - value], 
                        backgroundColor: [color, "#F3F4F6"], 
                        cutout: "70%" 
                    }] 
                },
                options: { 
                    plugins: { legend: { display: false } }, 
                    rotation: -90, 
                    circumference: 360, 
                    responsive: true, 
                    maintainAspectRatio: false 
                }
            });
        }

        createMacroChart("carbsChart", "#3B82F6", Math.min(carbsProgress, 100));
        createMacroChart("fatsChart", "#F59E0B", Math.min(fatsProgress, 100));
        createMacroChart("proteinChart", "#10B981", Math.min(proteinProgress, 100));
        createMacroChart("calorieChart", "#1C7C6E", Math.min(calorieProgress, 100));

        // Update calorie text
        document.getElementById("caloriesRemainingText").innerText = Math.max(0, 2000 - {{ $caloriesIn }});
        document.getElementById("caloriesConsumedFooter").innerText = {{ $caloriesIn }};

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

        // Handle window resize for better mobile experience
        window.addEventListener('resize', function() {
            // Re-initialize charts on orientation change for mobile
            if (window.innerWidth <= 768) {
                // Charts will automatically resize due to responsive: true
            }
        });
    </script>

    <!-- ===== STYLES ===== -->
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
        .carousel-card:hover { 
            transform: scale(1.02); 
            box-shadow: 0 8px 20px rgba(0,0,0,0.12); 
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

        /* Mobile-first responsive design */
        @media (max-width: 640px) {
            .carousel-card {
                min-width: 85vw;
            }
        }

        @media (min-width: 641px) and (max-width: 768px) {
            .carousel-card {
                min-width: 75vw;
            }
        }

        @media (min-width: 769px) {
            .carousel-card {
                min-width: 400px;
            }
        }

        /* Improved touch targets for mobile */
        @media (max-width: 768px) {
            button, a {
                min-height: 44px;
                min-width: 44px;
            }
        }
    </style>
</div>