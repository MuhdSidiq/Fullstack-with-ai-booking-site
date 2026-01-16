<x-layouts::app :title="__('Add Camping Site')">
    <div class="container mx-auto py-8">
        <h1 class="text-3xl font-bold mb-6 text-center text-blue-600">Add Camping Site</h1>

        <form action="{{ route('camping-sites.store') }}" method="POST" class="max-w-lg mx-auto">
            @csrf

            <div class="mb-4">
                <label for="name" class="block text-gray-700">Name</label>
                <input type="text" name="name" id="name" class="w-full border border-gray-300 rounded px-4 py-2" required>
            </div>

            <div class="mb-4">
                <label for="location" class="block text-gray-700">Location</label>
                <input type="text" name="location" id="location" class="w-full border border-gray-300 rounded px-4 py-2" required>
            </div>

            <div class="mb-4">
                <label for="capacity" class="block text-gray-700">Capacity</label>
                <input type="number" name="capacity" id="capacity" class="w-full border border-gray-300 rounded px-4 py-2" required>
            </div>

            <div class="mb-4">
                <label for="price" class="block text-gray-700">Price</label>
                <input type="number" step="0.01" name="price" id="price" class="w-full border border-gray-300 rounded px-4 py-2" required>
            </div>

            <div class="mb-4">
                <label for="is_prime_location" class="block text-gray-700">Prime Location</label>
                <input type="checkbox" name="is_prime_location" id="is_prime_location" class="mr-2">
                <span>Yes</span>
            </div>

            <div class="text-center">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Save</button>
            </div>
        </form>
    </div>
</x-layouts::app>