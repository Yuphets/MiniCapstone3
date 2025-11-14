<!-- Desktop Navigation -->
<nav class="bg-white shadow-sm border-b hidden md:block">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <a href="{{ route('dashboard') }}" class="text-xl font-bold text-primary">
                    NutriQuest
                </a>
                <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('dashboard') ? 'border-primary text-gray-900' : 'border-transparent text-gray-500' }} text-sm font-medium hover:text-gray-700">
                        Dashboard
                    </a>
                    <a href="{{ route('workouts') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('workouts') ? 'border-primary text-gray-900' : 'border-transparent text-gray-500' }} text-sm font-medium hover:text-gray-700">
                        Workouts
                    </a>
                    <a href="{{ route('meals') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('meals') ? 'border-primary text-gray-900' : 'border-transparent text-gray-500' }} text-sm font-medium hover:text-gray-700">
                        Meals
                    </a>
                    <a href="{{ route('progress') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('progress') ? 'border-primary text-gray-900' : 'border-transparent text-gray-500' }} text-sm font-medium hover:text-gray-700">
                        Progress
                    </a>
                    <a href="{{ route('diary') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('diary') ? 'border-primary text-gray-900' : 'border-transparent text-gray-500' }} text-sm font-medium hover:text-gray-700">
                        Diary
                    </a>

                    <!-- Admin Panel Link -->
                    @auth
                        @if(auth()->user()->is_admin)
                            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->is('admin*') ? 'border-primary text-gray-900' : 'border-transparent text-gray-500' }} text-sm font-medium hover:text-gray-700">
                                Admin Panel
                            </a>
                        @endif
                    @endauth
                </div>
            </div>
            <div class="flex items-center space-x-4">
                <span class="text-sm text-gray-700">Welcome, {{ Auth::user()->name ?? 'User' }}</span>
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
