<x-layouts::app :title="__('Camping Sites')">
    <div class="container mx-auto py-8">
        <h1 class="text-3xl font-bold mb-6 text-center text-blue-600">Camping Sites</h1>

        <a href="{{ route('camping-sites.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">Add New Camping Site</a>

        <flux:table>
            <flux:table.header>
                <flux:table.row>
                    <flux:table.heading>#</flux:table.heading>
                    <flux:table.heading>Name</flux:table.heading>
                    <flux:table.heading>Location</flux:table.heading>
                    <flux:table.heading>Capacity</flux:table.heading>
                    <flux:table.heading>Price</flux:table.heading>
                    <flux:table.heading>Actions</flux:table.heading>
                </flux:table.row>
            </flux:table.header>
            <flux:table.body>
                @forelse ($campingSites as $site)
                    <flux:table.row>
                        <flux:table.cell>{{ $loop->iteration }}</flux:table.cell>
                        <flux:table.cell>{{ $site->name }}</flux:table.cell>
                        <flux:table.cell>{{ $site->location }}</flux:table.cell>
                        <flux:table.cell>{{ $site->capacity }}</flux:table.cell>
                        <flux:table.cell>${{ number_format($site->price, 2) }}</flux:table.cell>
                        <flux:table.cell>
                            <a href="{{ route('camping-sites.edit', $site) }}" class="text-blue-500">Edit</a> |
                            <form action="{{ route('camping-sites.destroy', $site) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500">Delete</button>
                            </form>
                        </flux:table.cell>
                    </flux:table.row>
                @empty
                    <flux:table.row>
                        <flux:table.cell colspan="6" class="text-center text-gray-500">No camping sites available.</flux:table.cell>
                    </flux:table.row>
                @endforelse
            </flux:table.body>
        </flux:table>
    </div>
</x-layouts::app>