<div class="px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Workouts</h1>
        <button wire:click="startWorkout"
                class="bg-green-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-green-700 transition duration-200">
            + Add Workout
        </button>
    </div>

    @if (session('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('message') }}
        </div>
    @endif

    <!-- Workout Form -->
    @if($showForm)
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <h2 class="text-lg font-semibold mb-4">{{ $editingId ? 'Edit' : 'Add' }} Workout</h2>

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
                        class="bg-blue-600 text-white px-6 py-2 rounded-lg font-medium hover:bg-blue-700 transition duration-200">
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

    <!-- Workouts List -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h3 class="text-lg font-semibold mb-4">Today's Workouts</h3>

        @if(count($workouts) > 0)
            <div class="space-y-4">
                @foreach($workouts as $workout)
                    <div class="border border-gray-200 rounded-lg p-4">
                        <div class="flex justify-between items-start">
                            <div>
                                <h4 class="font-semibold text-lg">{{ $workout->activity->name }}</h4>
                                <p class="text-gray-600">{{ $workout->duration_min }} minutes • {{ number_format($workout->calories_burned) }} calories burned</p>
                                @if($workout->start_time)
                                    <p class="text-gray-500">Started at: {{ $workout->start_time }}</p>
                                @endif
                                @if($workout->notes)
                                    <p class="text-gray-500 mt-1">{{ $workout->notes }}</p>
                                @endif
                            </div>
                            <div class="flex space-x-2">
                                <button wire:click="editWorkout({{ $workout->id }})"
                                        class="text-blue-600 hover:text-blue-800">Edit</button>
                                <button wire:click="deleteWorkout({{ $workout->id }})"
                                        class="text-red-600 hover:text-red-800"
                                        onclick="return confirm('Are you sure you want to delete this workout?')">Delete</button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500 text-center py-8">No workouts logged today.</p>
        @endif
    </div>
</div>
