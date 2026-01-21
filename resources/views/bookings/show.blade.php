<x-layouts.public :title="__('Booking Details')">
    <div class="max-w-2xl mx-auto py-12 px-6">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-bold text-emerald-950">Booking Details</h2>
            <div class="flex gap-2">
                <a href="/" class="text-zinc-500 hover:text-zinc-700 font-medium text-sm">Back to Home</a>
            </div>
        </div>

        @if (request('canceled'))
            <div class="bg-red-50 text-red-700 p-4 rounded-xl mb-6 border border-red-100 flex items-center gap-3">
                <flux:icon name="x-circle" class="w-5 h-5 shrink-0" />
                <span>Payment was cancelled. You can try again by clicking "Pay Now" below.</span>
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow-lg border border-zinc-100 overflow-hidden">
            <dl class="divide-y divide-zinc-50">
                <!-- User row removed for public view, or handled conditionally -->
                
                <div class="px-6 py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                    <dt class="text-sm font-bold text-zinc-500">Accommodation</dt>
                    <dd class="mt-1 text-sm sm:col-span-2 sm:mt-0 font-medium text-zinc-900">{{ $booking->campingSite?->name ?? '-' }}</dd>
                </div>
                <div class="px-6 py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                    <dt class="text-sm font-bold text-zinc-500">Guest Name</dt>
                    <dd class="mt-1 text-sm sm:col-span-2 sm:mt-0 font-medium text-zinc-900">{{ $booking->name }}</dd>
                </div>
                <div class="px-6 py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                    <dt class="text-sm font-bold text-zinc-500">Email</dt>
                    <dd class="mt-1 text-sm sm:col-span-2 sm:mt-0 font-medium text-zinc-900">{{ $booking->email }}</dd>
                </div>
                <div class="px-6 py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                    <dt class="text-sm font-bold text-zinc-500">Phone</dt>
                    <dd class="mt-1 text-sm sm:col-span-2 sm:mt-0 font-medium text-zinc-900">{{ $booking->phone }}</dd>
                </div>
                <div class="px-6 py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                    <dt class="text-sm font-bold text-zinc-500">Date</dt>
                    <dd class="mt-1 text-sm sm:col-span-2 sm:mt-0 font-medium text-zinc-900">{{ $booking->booking_date?->format('M d, Y') }}</dd>
                </div>
                <div class="px-6 py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                    <dt class="text-sm font-bold text-zinc-500">Status</dt>
                    <dd class="mt-1 text-sm sm:col-span-2 sm:mt-0">
                         @php
                            $status = $booking->status;
                            $statusClasses = match($status) {
                                'Confirmed' => 'bg-emerald-100 text-emerald-800',
                                'Pending' => 'bg-amber-100 text-amber-800',
                                'Cancelled' => 'bg-red-100 text-red-800',
                                default => 'bg-zinc-100 text-zinc-800',
                            };
                        @endphp
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusClasses }}">
                            {{ $status }}
                        </span>
                    </dd>
                </div>
                @if($booking->remarks)
                <div class="px-6 py-5 sm:grid sm:grid-cols-3 sm:gap-4 bg-zinc-50/50">
                    <dt class="text-sm font-bold text-zinc-500">Remarks</dt>
                    <dd class="mt-1 text-sm sm:col-span-2 sm:mt-0 text-zinc-700">{{ $booking->remarks }}</dd>
                </div>
                @endif
            </dl>
        </div>

        @if ($booking->status === 'Pending')
            <div class="mt-8">
                <a href="{{ route('billplz.checkout', $booking) }}" class="w-full btn-primary text-white py-4 rounded-xl font-bold text-lg hover:brightness-110 transition flex items-center justify-center gap-2 shadow-lg shadow-emerald-900/10">
                    <i class="fas fa-credit-card"></i>
                    Pay RM {{ number_format($booking->campingSite->price, 2) }}
                </a>
            </div>
        @endif
    </div>
</x-layouts.public>
