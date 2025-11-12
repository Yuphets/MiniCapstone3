<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FitTrack - Your Personal Fitness Companion</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #1C7C6E 0%, #145C52 100%);
        }
        .feature-card:hover {
            transform: translateY(-5px);
            transition: all 0.3s ease;
        }
        .btn-primary {
            background-color: #1C7C6E;
        }
        .btn-primary:hover {
            background-color: #145C52;
        }
        .text-primary {
            color: #1C7C6E;
        }
        .border-primary {
            border-color: #1C7C6E;
        }
        .image-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .image-hover:hover {
            transform: scale(1.05);
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body class="font-sans bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg fixed w-full top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center">
                        <span class="text-2xl font-bold text-primary">FitTrack</span>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    @auth
                        <a href="/dashboard" class="text-gray-600 hover:text-primary px-3 py-2 rounded-md text-sm font-medium transition duration-300">Dashboard</a>
                        <form method="POST" action="/logout" class="inline">
                            @csrf
                            <button type="submit" class="btn-primary text-white hover:bg-[#145C52] px-4 py-2 rounded-md text-sm font-medium transition duration-300">Logout</button>
                        </form>
                    @else
                        <a href="/login" class="text-gray-600 hover:text-primary px-3 py-2 rounded-md text-sm font-medium transition duration-300">Login</a>
                        <a href="/register" class="btn-primary text-white hover:bg-[#145C52] px-4 py-2 rounded-md text-sm font-medium transition duration-300">Get Started</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="gradient-bg text-white pt-20 pb-32">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div class="text-center lg:text-left">
                    <h1 class="text-5xl md:text-6xl font-bold mb-6 leading-tight">
                        Transform Your
                        <span class="block text-green-200">Fitness Journey</span>
                    </h1>
                    <p class="text-xl md:text-2xl mb-8 text-green-100 leading-relaxed">
                        All-in-one fitness tracking platform to monitor your workouts, nutrition, and progress in one seamless experience.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                        <a href="/register" class="bg-white text-primary hover:bg-gray-100 px-8 py-4 rounded-lg text-lg font-semibold transition duration-300 transform hover:scale-105">
                            Start Your Journey
                        </a>
                        <a href="#features" class="border-2 border-white text-white hover:bg-white hover:text-primary px-8 py-4 rounded-lg text-lg font-semibold transition duration-300">
                            Learn More
                        </a>
                    </div>
                </div>
                <div class="relative">
                    <div class="relative rounded-2xl overflow-hidden image-hover shadow-2xl">
                        <img src="{{ asset('images/person-working-out.jpg') }}" alt="Person working out with FitTrack" class="w-full h-96 object-cover">
                        <div class="absolute inset-0 bg-gradient-to-r from-green-900/20 to-transparent"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Everything You Need to Succeed</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Comprehensive tools to track every aspect of your fitness journey
                </p>
            </div>

            <!-- Feature 1 with Image -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center mb-20">
                <div class="order-2 lg:order-1">
                    <div class="relative rounded-2xl overflow-hidden image-hover shadow-2xl">
                        <img src="{{ asset('images/workout-tracking.jpg') }}" alt="Workout tracking interface" class="w-full h-96 object-cover">
                    </div>
                </div>
                <div class="order-1 lg:order-2">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mb-6">
                        <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                    </div>
                    <h3 class="text-3xl font-bold text-gray-900 mb-4">Smart Workout Tracking</h3>
                    <p class="text-lg text-gray-600 leading-relaxed mb-6">
                        Log your exercises with precision. Track sets, reps, weights, and monitor calories burned in real-time. Build your perfect workout routine with our intelligent tracking system.
                    </p>
                    <ul class="space-y-3 text-gray-600">
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-primary mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            Real-time progress tracking
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-primary mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            Custom workout plans
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-primary mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            Performance analytics
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Feature 2 with Image -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center mb-20">
                <div>
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mb-6">
                        <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-3xl font-bold text-gray-900 mb-4">Nutrition Made Simple</h3>
                    <p class="text-lg text-gray-600 leading-relaxed mb-6">
                        Take control of your nutrition with our comprehensive tracking system. Monitor calories, macronutrients, and maintain a balanced diet for optimal fitness results.
                    </p>
                    <ul class="space-y-3 text-gray-600">
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-primary mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            Calorie and macro tracking
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-primary mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            Food database with 1M+ items
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-primary mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            Meal planning tools
                        </li>
                    </ul>
                </div>
                <div>
                    <div class="relative rounded-2xl overflow-hidden image-hover shadow-2xl">
                        <img src="{{ asset('images/nutrition-tracking.jpg') }}" alt="Nutrition tracking dashboard" class="w-full h-96 object-scale-down">
                    </div>
                </div>
            </div>

            <!-- Feature 3 with Image -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div class="order-2 lg:order-1">
                    <div class="relative rounded-2xl overflow-hidden image-hover shadow-2xl">
                        <img src="{{ asset('images/progress-analytics.jpg') }}" alt="Progress analytics charts" class="w-full h-96 object-cover">
                    </div>
                </div>
                <div class="order-1 lg:order-2">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mb-6">
                        <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-3xl font-bold text-gray-900 mb-4">Visual Progress Analytics</h3>
                    <p class="text-lg text-gray-600 leading-relaxed mb-6">
                        See your transformation with beautiful charts and analytics. Track weight, measurements, body composition, and celebrate every milestone along your fitness journey.
                    </p>
                    <ul class="space-y-3 text-gray-600">
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-primary mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            Detailed progress charts
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-primary mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            Goal achievement tracking
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-primary mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            Milestone celebrations
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Gallery Section -->
    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Join Our Fitness Community</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    See how real people are transforming their lives with FitTrack
                </p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="relative rounded-2xl overflow-hidden image-hover">
                    <img src="{{ asset('images/gallery-1.jpg') }}" alt="FitTrack community member" class="w-full h-64 object-cover">
                </div>
                <div class="relative rounded-2xl overflow-hidden image-hover">
                    <img src="{{ asset('images/gallery-2.jpg') }}" alt="Happy FitTrack user" class="w-full h-64 object-cover">
                </div>
                <div class="relative rounded-2xl overflow-hidden image-hover">
                    <img src="{{ asset('images/gallery-3.jpg') }}" alt="Fitness transformation" class="w-full h-64 object-cover">
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-20 bg-primary text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                <div>
                    <div class="text-4xl font-bold mb-2">10K+</div>
                    <div class="text-green-200 text-lg">Active Users</div>
                </div>
                <div>
                    <div class="text-4xl font-bold mb-2">50K+</div>
                    <div class="text-green-200 text-lg">Workouts Logged</div>
                </div>
                <div>
                    <div class="text-4xl font-bold mb-2">100K+</div>
                    <div class="text-green-200 text-lg">Meals Tracked</div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-gray-900 text-white">
        <div class="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8">
            <h2 class="text-4xl font-bold mb-6">Ready to Transform Your Fitness Journey?</h2>
            <p class="text-xl text-gray-300 mb-8 max-w-2xl mx-auto">
                Join thousands of users who have already started tracking their fitness progress with FitTrack.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="/register" class="btn-primary hover:bg-[#145C52] text-white px-8 py-4 rounded-lg text-lg font-semibold transition duration-300 transform hover:scale-105">
                    Get Started Free
                </a>
                <a href="/login" class="border-2 border-gray-600 text-gray-300 hover:bg-gray-800 px-8 py-4 rounded-lg text-lg font-semibold transition duration-300">
                    Sign In
                </a>
            </div>
            <p class="text-gray-400 mt-4">No credit card required • 30-day free trial</p>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-2xl font-bold mb-4 text-primary">FitTrack</h3>
                    <p class="text-gray-400">
                        Your personal fitness companion for tracking workouts, nutrition, and progress.
                    </p>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Product</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#features" class="hover:text-white transition duration-300">Features</a></li>
                        <li><a href="#" class="hover:text-white transition duration-300">Pricing</a></li>
                        <li><a href="#" class="hover:text-white transition duration-300">API</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Company</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-white transition duration-300">About</a></li>
                        <li><a href="#" class="hover:text-white transition duration-300">Blog</a></li>
                        <li><a href="#" class="hover:text-white transition duration-300">Careers</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Support</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-white transition duration-300">Help Center</a></li>
                        <li><a href="#" class="hover:text-white transition duration-300">Contact</a></li>
                        <li><a href="#" class="hover:text-white transition duration-300">Privacy</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; 2024 FitTrack. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Smooth Scroll -->
    <script>
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>
</body>
</html>