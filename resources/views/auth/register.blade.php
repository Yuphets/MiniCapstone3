<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - NutriQuest</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
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
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <!-- Header -->
        <div class="text-center">
            <a href="/" class="inline-block">
                <h1 class="text-3xl font-bold text-primary">NutriQuest</h1>
            </a>
            <h2 class="mt-6 text-2xl font-bold text-gray-900">
                Create your account
            </h2>
            <p class="mt-2 text-sm text-gray-600">
                Or <a href="/login" class="font-medium text-primary hover:text-green-700">sign in to existing account</a>
            </p>
        </div>

        <!-- Back to Home Button -->
        <div class="text-center">
            <a href="/" class="inline-flex items-center text-sm text-gray-600 hover:text-primary transition duration-300">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Home
            </a>
        </div>

        <!-- Register Form -->
        <form class="mt-8 space-y-6 bg-white p-8 rounded-2xl shadow-lg border border-gray-100" method="POST" action="/register">
            @csrf
            
            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="space-y-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                    <input id="name" name="name" type="text" autocomplete="name" required 
                           class="mt-1 appearance-none relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary focus:z-10"
                           placeholder="Enter your full name" value="{{ old('name') }}">
                </div>
                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                    <input id="username" name="username" type="text" autocomplete="username" required 
                           class="mt-1 appearance-none relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary focus:z-10"
                           placeholder="Choose a username" value="{{ old('username') }}">
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email address</label>
                    <input id="email" name="email" type="email" autocomplete="email" required 
                           class="mt-1 appearance-none relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary focus:z-10"
                           placeholder="Enter your email" value="{{ old('email') }}">
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input id="password" name="password" type="password" autocomplete="new-password" required 
                           class="mt-1 appearance-none relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary focus:z-10"
                           placeholder="Create a password">
                </div>
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required 
                           class="mt-1 appearance-none relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary focus:z-10"
                           placeholder="Confirm your password">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="height_cm" class="block text-sm font-medium text-gray-700">Height (cm)</label>
                        <input id="height_cm" name="height_cm" type="number" step="0.1" 
                               class="mt-1 appearance-none relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary focus:z-10"
                               placeholder="170" value="{{ old('height_cm') }}">
                    </div>
                    <div>
                        <label for="weight_kg" class="block text-sm font-medium text-gray-700">Weight (kg)</label>
                        <input id="weight_kg" name="weight_kg" type="number" step="0.1" 
                               class="mt-1 appearance-none relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary focus:z-10"
                               placeholder="70" value="{{ old('weight_kg') }}">
                    </div>
                </div>
            </div>

            <div>
                <button type="submit" 
                        class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white btn-primary hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition duration-300">
                    Create Account
                </button>
            </div>

            <div class="text-center">
                <p class="text-sm text-gray-600">
                    Already have an account? 
                    <a href="/login" class="font-medium text-primary hover:text-green-700">
                        Sign in here
                    </a>
                </p>
            </div>
        </form>
    </div>
</body>
</html>