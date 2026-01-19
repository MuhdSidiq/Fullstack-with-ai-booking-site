<x-layouts::app :title="__('Booking Details')">
    <div class="max-w-2xl mx-auto py-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold">Booking Details</h2>
            <div class="flex gap-2">
                <flux:button variant="primary" icon="pencil" href="{{ route('bookings.edit', $booking) }}">Edit</flux:button>
                <flux:button variant="ghost" href="{{ route('bookings.index') }}">Back</flux:button>
            </div>
        </div>

        <div class="bg-white dark:bg-zinc-800 rounded-lg border border-zinc-200 dark:border-zinc-700 overflow-hidden">
            <dl class="divide-y divide-zinc-200 dark:divide-zinc-700">
                <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                    <dt class="text-sm font-medium text-zinc-500 dark:text-zinc-400">User</dt>
                    <dd class="mt-1 text-sm sm:col-span-2 sm:mt-0">{{ $booking->user?->name ?? '-' }}</dd>
                </div>
                <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                    <dt class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Camping Site</dt>
                    <dd class="mt-1 text-sm sm:col-span-2 sm:mt-0">{{ $booking->campingSite?->name ?? '-' }}</dd>
                </div>
                <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                    <dt class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Name</dt>
                    <dd class="mt-1 text-sm sm:col-span-2 sm:mt-0">{{ $booking->name }}</dd>
                </div>
                <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                    <dt class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Email</dt>
                    <dd class="mt-1 text-sm sm:col-span-2 sm:mt-0">{{ $booking->email }}</dd>
                </div>
                <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                    <dt class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Phone</dt>
                    <dd class="mt-1 text-sm sm:col-span-2 sm:mt-0">{{ $booking->phone }}</dd>
                </div>
                <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                    <dt class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Booking Date</dt>
                    <dd class="mt-1 text-sm sm:col-span-2 sm:mt-0">{{ $booking->booking_date?->format('M d, Y H:i') }}</dd>
                </div>
                <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                    <dt class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Status</dt>
                    <dd class="mt-1 text-sm sm:col-span-2 sm:mt-0">
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
                    </dd>
                </div>
                <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                    <dt class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Remarks</dt>
                    <dd class="mt-1 text-sm sm:col-span-2 sm:mt-0">{{ $booking->remarks ?? '-' }}</dd>
                </div>
            </dl>
        </div>
    </div>
</x-layouts::app>
