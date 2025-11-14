<x-layouts.app>
    <div class="py-6">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-900">Create New Activity</h1>
                <p class="mt-1 text-sm text-gray-600">Add a new exercise activity to the database</p>
            </div>

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white shadow rounded-lg">
                <form action="{{ route('admin.activities.create') }}" method="POST" class="p-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Activity Name *</label>
                            <input type="text" name="name" id="name" required
                                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                   value="{{ old('name') }}"
                                   placeholder="e.g., Running, Weight Training">
                        </div>

                        <div>
                            <label for="activity_type" class="block text-sm font-medium text-gray-700">Activity Type *</label>
                            <select name="activity_type" id="activity_type" required
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Select Type</option>
                                <option value="cardio" {{ old('activity_type') == 'cardio' ? 'selected' : '' }}>Cardio</option>
                                <option value="strength" {{ old('activity_type') == 'strength' ? 'selected' : '' }}>Strength Training</option>
                                <option value="flexibility" {{ old('activity_type') == 'flexibility' ? 'selected' : '' }}>Flexibility</option>
                                <option value="sports" {{ old('activity_type') == 'sports' ? 'selected' : '' }}>Sports</option>
                                <option value="other" {{ old('activity_type') == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>

                        <div>
                            <label for="calories_per_min" class="block text-sm font-medium text-gray-700">Calories per Minute *</label>
                            <input type="number" name="calories_per_min" id="calories_per_min" step="0.1" min="0" required
                                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                   value="{{ old('calories_per_min') }}"
                                   placeholder="e.g., 8.5">
                        </div>

                        <div>
                            <label for="default_duration_min" class="block text-sm font-medium text-gray-700">Default Duration (minutes) *</label>
                            <input type="number" name="default_duration_min" id="default_duration_min" min="1" required
                                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                   value="{{ old('default_duration_min', 30) }}"
                                   placeholder="e.g., 30">
                        </div>
                    </div>

                    <div class="mt-6">
                        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea name="description" id="description" rows="4"
                                  class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                  placeholder="Optional description of the activity">{{ old('description') }}</textarea>
                    </div>

                    <div class="mt-8 flex justify-end space-x-3">
                        <a href="{{ route('admin.exercise-data') }}"
                           class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Cancel
                        </a>
                        <button type="submit"
                                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            Create Activity
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.app>
