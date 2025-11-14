<div class="min-h-screen bg-gray-50 pb-20">
 <!-- Header - Minimalist Centered Design (Smaller) -->
<div class="max-w-2xl mx-auto mb-8 pt-6">
    <div class="text-center">
        <h2 class="text-2xl md:text-3xl font-bold text-[#1C7C6E] mb-3">
            Workout Tracker
        </h2>
        <p class="text-base text-gray-600 max-w-md mx-auto">
            Track your fitness journey
        </p>
    </div>
</div>
    <!-- Flash Messages -->
    @if (session('message'))
        <div class="max-w-6xl mx-auto mb-4">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('message') }}
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <div class="max-w-6xl mx-auto px-4">
        <!-- Workout Form -->
        @if($showForm)
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
            <h2 class="text-lg font-semibold mb-4 text-gray-900">{{ $editingId ? 'Edit' : 'Add' }} Workout</h2>

            <form wire:submit.prevent="saveWorkout">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Activity</label>
                        <select wire:model="form.activity_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Select Activity</option>
                            @foreach($activities as $activity)
                                <option value="{{ $activity->id }}">{{ $activity->name }}</option>
                            @endforeach
                        </select>
                        @error('form.activity_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                        <input type="date" wire:model="form.activity_date"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('form.activity_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Duration (minutes)</label>
                        <input type="number" wire:model="form.duration_min"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('form.duration_min') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Start Time</label>
                        <input type="time" wire:model="form.start_time"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                    <textarea wire:model="form.notes" rows="3"
                              class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                              placeholder="Any notes about your workout..."></textarea>
                </div>

                <div class="flex space-x-3">
                    <button type="submit"
                            class="bg-[#1C7C6E] text-white px-6 py-2 rounded-lg font-medium hover:bg-[#166B5F] transition duration-200">
                        {{ $editingId ? 'Update' : 'Save' }} Workout
                    </button>
                    <button type="button" wire:click="cancelEdit"
                            class="bg-gray-500 text-white px-6 py-2 rounded-lg font-medium hover:bg-gray-600 transition duration-200">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
        @endif

        <!-- Workouts List - Only show when NOT adding/editing -->
        @if(!$showForm)
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <!-- Header with Add Button -->
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-gray-900">Today's Workouts</h3>
                    <button wire:click="startWorkout"
                            class="bg-[#1C7C6E] text-white px-4 py-2 rounded-lg font-medium hover:bg-[#166B5F] transition duration-200 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Add Workout
                    </button>
                </div>
            </div>

            <!-- Workout Items -->
            <div class="p-6">
                @if(count($workouts) > 0)
                    <div class="space-y-4">
                        @foreach($workouts as $workout)
                            <div class="border border-gray-200 rounded-lg p-4 hover:border-[#1C7C6E] transition duration-200">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-3 mb-2">
                                            <div class="w-10 h-10 bg-[#1C7C6E] bg-opacity-10 rounded-lg flex items-center justify-center">
                                                <svg class="w-5 h-5 text-[#1C7C6E]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <h4 class="font-semibold text-lg text-gray-900">{{ $workout->activity->name }}</h4>
                                                <div class="flex items-center gap-4 text-sm text-gray-600 mt-1">
                                                    <span class="flex items-center gap-1">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        </svg>
                                                        {{ $workout->duration_min }} min
                                                    </span>
                                                    <span class="flex items-center gap-1">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 14v6m-3-3h6M6 10h2a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2zm10 0h2a2 2 0 002-2V6a2 2 0 00-2-2h-2a2 2 0 00-2 2v2a2 2 0 002 2zM6 20h2a2 2 0 002-2v-2a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2z"></path>
                                                        </svg>
                                                        {{ number_format($workout->calories_burned) }} cal
                                                    </span>
                                                    @if($workout->start_time)
                                                        <span class="flex items-center gap-1">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3"></path>
                                                            </svg>
                                                            {{ $workout->start_time }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        @if($workout->notes)
                                            <div class="bg-gray-50 rounded-lg p-3 mt-2">
                                                <p class="text-sm text-gray-600">{{ $workout->notes }}</p>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex space-x-3 ml-4">
                                        <button wire:click="editWorkout({{ $workout->id }})"
                                                class="text-[#1C7C6E] hover:text-[#166B5F] transition duration-200 flex items-center gap-1 text-sm font-medium">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                            Edit
                                        </button>
                                        <button wire:click="deleteWorkout({{ $workout->id }})"
                                                class="text-red-600 hover:text-red-700 transition duration-200 flex items-center gap-1 text-sm font-medium"
                                                onclick="return confirm('Are you sure you want to delete this workout?')">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                            Delete
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <!-- Empty State -->
                    <div class="text-center py-12">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No workouts logged today</h3>
                        <p class="text-gray-500 mb-4">Start your fitness journey by adding your first workout</p>
                        <button wire:click="startWorkout"
                                class="bg-[#1C7C6E] text-white px-6 py-2 rounded-lg font-medium hover:bg-[#166B5F] transition duration-200 inline-flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Add Your First Workout
                        </button>
                    </div>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>
