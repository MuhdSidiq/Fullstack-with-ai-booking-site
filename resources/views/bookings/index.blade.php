<x-layouts::app :title="__('Bookings')">
    <div class="container mx-auto py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold">Bookings</h1>
            <flux:button variant="primary" icon="plus" href="{{ route('bookings.create') }}">New Booking</flux:button>
        </div>

        @if (session('success') || request('session_id'))
            <flux:callout variant="success" icon="check-circle" class="mb-6">
                {{ session('success') ?? 'Payment successful! Your booking has been confirmed.' }}
            </flux:callout>
        @endif

        @if (session('error') || request('canceled'))
            <flux:callout variant="danger" icon="x-circle" class="mb-6">
                {{ session('error') ?? 'Payment was cancelled. Please try again.' }}
            </flux:callout>
        @endif

        <div class="overflow-x-auto rounded-lg border border-zinc-200 dark:border-zinc-700">
            <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700">
                <thead class="bg-zinc-50 dark:bg-zinc-800">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-medium text-zinc-500 dark:text-zinc-400">#</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-zinc-500 dark:text-zinc-400">Customer</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-zinc-500 dark:text-zinc-400">Camping Site</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-zinc-500 dark:text-zinc-400">Date</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-zinc-500 dark:text-zinc-400">Status</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-zinc-500 dark:text-zinc-400">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700 bg-white dark:bg-zinc-900">
                    @forelse ($bookings as $booking)
                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800">
                            <td class="px-4 py-3 text-sm">{{ $loop->iteration }}</td>
                            <td class="px-4 py-3">
                                <div class="text-sm font-medium">{{ $booking->name }}</div>
                                <div class="text-sm text-zinc-500">{{ $booking->email }}</div>
                            </td>
                            <td class="px-4 py-3 text-sm">{{ $booking->campingSite?->name ?? '-' }}</td>
                            <td class="px-4 py-3 text-sm whitespace-nowrap">{{ $booking->booking_date?->format('M d, Y H:i') }}</td>
                            <td class="px-4 py-3">
                                @php
                                    $color = match($booking->status) {
                                        'Confirmed' => 'green',
                                        'Pending' => 'yellow',
                                        'Cancelled' => 'red',
                                        'Rescheduled' => 'blue',
                                        default => 'zinc',
                                    };
                                @endphp
                                <flux:badge size="sm" :color="$color">{{ $booking->status }}</flux:badge>
                            </td>
                            <td class="px-4 py-3">
                                <flux:dropdown>
                                    <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal"></flux:button>
                                    <flux:menu>
                                        <flux:menu.item icon="eye" href="{{ route('bookings.show', $booking) }}">View</flux:menu.item>
                                        <flux:menu.item icon="pencil" href="{{ route('bookings.edit', $booking) }}">Edit</flux:menu.item>
                                        <flux:menu.separator />
                                        <form method="POST" action="{{ route('bookings.destroy', $booking) }}">
                                            @csrf
                                            @method('DELETE')
                                            <flux:menu.item variant="danger" icon="trash" type="submit">Cancel</flux:menu.item>
                                        </form>
                                    </flux:menu>
                                </flux:dropdown>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-zinc-500">No bookings available.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $bookings->links() }}
        </div>
    </div>
</x-layouts::app>
