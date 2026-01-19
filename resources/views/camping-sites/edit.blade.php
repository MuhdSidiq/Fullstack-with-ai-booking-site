<x-layouts::app :title="__('Edit Camping Site')">
    <div class="max-w-xl mx-auto py-8">
        <h2 class="text-2xl font-bold mb-6">Edit Camping Site</h2>
        <form method="POST" action="{{ route('camping-sites.update', $campingSite) }}" class="space-y-6">
            @csrf
            @method('PUT')
            <flux:field>
                <flux:label>Name</flux:label>
                <flux:input type="text" name="name" value="{{ old('name', $campingSite->name) }}" />
                <flux:error name="name" />
            </flux:field>
            <flux:field>
                <flux:label>Location</flux:label>
                <flux:input type="text" name="location" value="{{ old('location', $campingSite->location) }}" />
                <flux:error name="location" />
            </flux:field>
            <flux:field>
                <flux:label>Capacity</flux:label>
                <flux:input type="number" name="capacity" value="{{ old('capacity', $campingSite->capacity) }}" />
                <flux:error name="capacity" />
            </flux:field>
            <flux:field>
                <flux:label>Price</flux:label>
                <flux:input type="number" step="0.01" name="price" value="{{ old('price', $campingSite->price) }}" />
                <flux:error name="price" />
            </flux:field>
            <flux:field>
                <flux:checkbox name="is_prime_location" value="1" :checked="old('is_prime_location', $campingSite->is_prime_location)" label="Prime Location" />
                <flux:error name="is_prime_location" />
            </flux:field>
            <div class="flex gap-2">
                <flux:button variant="primary" type="submit">Update</flux:button>
                <flux:button variant="ghost" href="{{ route('camping-sites.index') }}">Cancel</flux:button>
            </div>
        </form>
    </div>
</x-layouts::app>
