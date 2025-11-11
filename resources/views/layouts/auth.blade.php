<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'NutriQuest - Fitness Tracker')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @livewireStyles
</head>
<body class="h-full bg-gray-50 font-sans antialiased">
    <!-- Simple header for auth pages -->
    <header class="bg-green-600 text-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-center py-4">
                <h1 class="text-xl font-bold">NutriQuest</h1>
            </div>
        </div>
    </header>

    <main class="flex-1">
        @yield('content')
    </main>

    @livewireScripts
</body>
</html>
