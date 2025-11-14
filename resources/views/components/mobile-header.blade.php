<!-- Mobile Header -->
<div class="md:hidden bg-white shadow-sm border-b">
    <div class="px-4 py-3">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <a href="{{ route('dashboard') }}" class="text-lg font-bold text-primary">
                    NutriQuest
                </a>
            </div>
            <div class="flex items-center space-x-3">
                <span class="text-sm text-gray-700">{{ Auth::user()->name ?? 'User' }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-sm text-gray-500 hover:text-gray-700">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
