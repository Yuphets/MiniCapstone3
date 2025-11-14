<x-layouts.app>
<div class="py-6">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Back Button -->
            <div class="mb-6">
                <a href="{{ route('admin.nutrition-data') }}"
                   class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700 transition duration-200">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to Nutrition Data
                </a>
            </div>

            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-900">Create New Food Item</h1>
                <p class="mt-1 text-sm text-gray-600">Add a new food item to the nutrition database</p>
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
                <form action="{{ route('admin.food-items.create') }}" method="POST" class="p-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label for="name" class="block text-sm font-medium text-gray-700">Food Name *</label>
                            <input type="text" name="name" id="name" required
                                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                   value="{{ old('name') }}"
                                   placeholder="e.g., Chicken Breast, Brown Rice">
                        </div>

                        <div>
                            <label for="brand" class="block text-sm font-medium text-gray-700">Brand</label>
                            <input type="text" name="brand" id="brand"
                                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                   value="{{ old('brand') }}"
                                   placeholder="e.g., Generic, Brand Name">
                        </div>

                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
                            <input type="text" name="category" id="category"
                                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                   value="{{ old('category') }}"
                                   placeholder="e.g., Protein, Grains, Vegetables">
                        </div>

                        <div>
                            <label for="serving_qty" class="block text-sm font-medium text-gray-700">Serving Quantity *</label>
                            <input type="number" name="serving_qty" id="serving_qty" step="0.1" min="0" required
                                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                   value="{{ old('serving_qty', 1) }}"
                                   placeholder="e.g., 1">
                        </div>

                        <div>
                            <label for="serving_unit" class="block text-sm font-medium text-gray-700">Serving Unit *</label>
                            <input type="text" name="serving_unit" id="serving_unit" required
                                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                   value="{{ old('serving_unit', 'piece') }}"
                                   placeholder="e.g., piece, cup, gram">
                        </div>

                        <div>
                            <label for="calories" class="block text-sm font-medium text-gray-700">Calories *</label>
                            <input type="number" name="calories" id="calories" step="0.1" min="0" required
                                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                   value="{{ old('calories') }}"
                                   placeholder="e.g., 165">
                        </div>

                        <div>
                            <label for="protein_g" class="block text-sm font-medium text-gray-700">Protein (g) *</label>
                            <input type="number" name="protein_g" id="protein_g" step="0.1" min="0" required
                                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                   value="{{ old('protein_g') }}"
                                   placeholder="e.g., 31">
                        </div>

                        <div>
                            <label for="carbs_g" class="block text-sm font-medium text-gray-700">Carbs (g) *</label>
                            <input type="number" name="carbs_g" id="carbs_g" step="0.1" min="0" required
                                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                   value="{{ old('carbs_g') }}"
                                   placeholder="e.g., 0">
                        </div>

                        <div>
                            <label for="fats_g" class="block text-sm font-medium text-gray-700">Fats (g) *</label>
                            <input type="number" name="fats_g" id="fats_g" step="0.1" min="0" required
                                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                   value="{{ old('fats_g') }}"
                                   placeholder="e.g., 3.6">
                        </div>
                    </div>

                    <div class="mt-6">
                        <label for="notes" class="block text-sm font-medium text-gray-700">Notes</label>
                        <textarea name="notes" id="notes" rows="3"
                                  class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                  placeholder="Optional notes about the food item">{{ old('notes') }}</textarea>
                    </div>

                    <div class="mt-8 flex justify-end space-x-3">
                        <a href="{{ route('admin.nutrition-data') }}"
                           class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Cancel
                        </a>
                        <button type="submit"
                                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            Create Food Item
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.app>
