<!-- Mobile Bottom Navigation -->
<nav class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 md:hidden z-40">
    <div class="flex justify-around items-center h-16">
        <a href="{{ route('dashboard') }}" class="flex flex-col items-center justify-center px-3 py-2 {{ request()->routeIs('dashboard') ? 'text-primary' : 'text-gray-500' }} hover:text-gray-700 transition duration-200">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            <span class="text-xs mt-1">Dashboard</span>
        </a>

        <a href="{{ route('workouts') }}" class="flex flex-col items-center justify-center px-3 py-2 {{ request()->routeIs('workouts') ? 'text-primary' : 'text-gray-500' }} hover:text-gray-700 transition duration-200">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
            </svg>
            <span class="text-xs mt-1">Workouts</span>
        </a>

        <a href="{{ route('meals') }}" class="flex flex-col items-center justify-center px-3 py-2 {{ request()->routeIs('meals') ? 'text-primary' : 'text-gray-500' }} hover:text-gray-700 transition duration-200">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span class="text-xs mt-1">Meals</span>
        </a>

        <a href="{{ route('diary') }}" class="flex flex-col items-center justify-center px-3 py-2 {{ request()->routeIs('diary') ? 'text-primary' : 'text-gray-500' }} hover:text-gray-700 transition duration-200">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <span class="text-xs mt-1">Diary</span>
        </a>

        <a href="{{ route('progress') }}" class="flex flex-col items-center justify-center px-3 py-2 {{ request()->routeIs('progress') ? 'text-primary' : 'text-gray-500' }} hover:text-gray-700 transition duration-200">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
            </svg>
            <span class="text-xs mt-1">Progress</span>
        </a>
    </div>
</nav>
