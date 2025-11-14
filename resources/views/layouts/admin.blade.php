<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>NutriQuest Admin - {{ $title ?? 'Dashboard' }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
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

        /* Mobile responsive adjustments */
        @media (max-width: 768px) {
            .admin-container {
                padding: 1rem;
            }
            .admin-table {
                font-size: 0.875rem;
            }
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50">
    <div class="min-h-screen">
        <!-- Admin Navigation -->
        <nav class="bg-white shadow-sm border-b">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <a href="{{ route('admin.dashboard') }}" class="text-xl font-bold text-primary">
                            NutriQuest Admin
                        </a>
                        <div class="hidden md:ml-6 md:flex md:space-x-8">
                            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('admin.dashboard') ? 'border-primary text-gray-900' : 'border-transparent text-gray-500' }} text-sm font-medium hover:text-gray-700">
                                Dashboard
                            </a>
                            <a href="{{ route('admin.users') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('admin.users*') ? 'border-primary text-gray-900' : 'border-transparent text-gray-500' }} text-sm font-medium hover:text-gray-700">
                                Users
                            </a>
                            <a href="{{ route('admin.activity-logs') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('admin.activity-logs') ? 'border-primary text-gray-900' : 'border-transparent text-gray-500' }} text-sm font-medium hover:text-gray-700">
                                Activity Logs
                            </a>
                            <a href="{{ route('admin.exercise-data') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('admin.exercise-data*') ? 'border-primary text-gray-900' : 'border-transparent text-gray-500' }} text-sm font-medium hover:text-gray-700">
                                Exercise Data
                            </a>
                            <a href="{{ route('admin.nutrition-data') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('admin.nutrition-data*') ? 'border-primary text-gray-900' : 'border-transparent text-gray-500' }} text-sm font-medium hover:text-gray-700">
                                Nutrition Data
                            </a>
                            <a href="{{ route('admin.reports') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('admin.reports') ? 'border-primary text-gray-900' : 'border-transparent text-gray-500' }} text-sm font-medium hover:text-gray-700">
                                Reports
                            </a>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('dashboard') }}" class="text-sm text-gray-500 hover:text-gray-700 bg-gray-100 hover:bg-gray-200 px-3 py-1 rounded transition duration-300">
                            User Dashboard
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-sm text-gray-500 hover:text-gray-700 bg-gray-100 hover:bg-gray-200 px-3 py-1 rounded transition duration-300">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Mobile Admin Menu -->
        <div class="md:hidden bg-white border-b">
            <div class="px-4 py-2">
                <select onchange="window.location.href=this.value" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary">
                    <option value="{{ route('admin.dashboard') }}" {{ request()->routeIs('admin.dashboard') ? 'selected' : '' }}>Dashboard</option>
                    <option value="{{ route('admin.users') }}" {{ request()->routeIs('admin.users*') ? 'selected' : '' }}>Users</option>
                    <option value="{{ route('admin.activity-logs') }}" {{ request()->routeIs('admin.activity-logs') ? 'selected' : '' }}>Activity Logs</option>
                    <option value="{{ route('admin.exercise-data') }}" {{ request()->routeIs('admin.exercise-data*') ? 'selected' : '' }}>Exercise Data</option>
                    <option value="{{ route('admin.nutrition-data') }}" {{ request()->routeIs('admin.nutrition-data*') ? 'selected' : '' }}>Nutrition Data</option>
                    <option value="{{ route('admin.reports') }}" {{ request()->routeIs('admin.reports') ? 'selected' : '' }}>Reports</option>
                </select>
            </div>
        </div>

        <!-- Page Content -->
        <main class="admin-container">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $slot }}
            </div>
        </main>
    </div>
</body>
</html>
