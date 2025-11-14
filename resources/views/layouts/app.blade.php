<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>NutriQuest - {{ $title ?? 'Dashboard' }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Livewire Styles -->
    @livewireStyles

    <style>
        body {
            font-family: 'Inter', sans-serif;
            padding-bottom: 5rem; /* Space for bottom navbar on mobile */
        }
        .text-primary {
            color: #1C7C6E;
        }
        .bg-primary {
            background-color: #1C7C6E;
        }
        .bg-primary:hover {
            background-color: #145C52;
        }
        .border-primary {
            border-color: #1C7C6E;
        }

        /* Remove bottom padding on desktop */
        @media (min-width: 768px) {
            body {
                padding-bottom: 0;
            }
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50">
    <div class="min-h-screen">
        <!-- Include Navigation Components -->
        @include('components.desktop-nav')
        @include('components.mobile-header')

        <!-- Page Content -->
        <main class="pb-4 md:pb-0">
            {{ $slot }}
        </main>

        <!-- Mobile Bottom Navigation -->
        @include('components.mobile-nav')
    </div>

    <!-- Livewire Scripts -->
    @livewireScripts

    <!-- Alpine.js -->
    <script src="//unpkg.com/alpinejs" defer></script>
</body>
</html>
