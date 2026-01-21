<x-layouts.public title="Booking Confirmed!">
    <div class="max-w-2xl mx-auto py-16 px-6 text-center">
        
        <div class="mb-8 flex justify-center">
            <div class="w-24 h-24 bg-emerald-100 rounded-full flex items-center justify-center shadow-lg shadow-emerald-100">
                <flux:icon name="check" class="w-12 h-12 text-emerald-600" />
            </div>
        </div>

        <h1 class="text-4xl font-extrabold text-emerald-950 mb-4">Payment Successful!</h1>
        <p class="text-xl text-zinc-600 mb-12">
            Thank you, {{ $booking->name }}. Your adventure at <span class="font-bold text-emerald-800">{{ $booking->campingSite->name }}</span> is confirmed.
        </p>

        <div class="bg-white rounded-2xl shadow-xl border border-zinc-100 overflow-hidden text-left mb-10 max-w-lg mx-auto transform rotate-1 hover:rotate-0 transition duration-500">
            <div class="bg-emerald-900 p-6 text-white text-center">
                <div class="text-sm font-bold uppercase tracking-widest text-emerald-300 mb-1">Reservation ID</div>
                <div class="text-3xl font-mono">{{ $booking->id }}</div>
            </div>
            <div class="p-8 space-y-4">
                 <div class="flex justify-between items-center border-b border-zinc-50 pb-4">
                    <span class="text-zinc-500 font-medium">Check-in Date</span>
                    <span class="text-zinc-900 font-bold">{{ $booking->booking_date->format('F d, Y') }}</span>
                </div>
                <div class="flex justify-between items-center border-b border-zinc-50 pb-4">
                    <span class="text-zinc-500 font-medium">Guests</span>
                    <span class="text-zinc-900 font-bold">{{ $booking->campingSite->capacity }} People (Max)</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-zinc-500 font-medium">Amount Paid</span>
                    <span class="text-emerald-600 font-bold text-xl">RM {{ number_format($booking->campingSite->price, 2) }}</span>
                </div>
            </div>
            <div class="bg-zinc-50 px-8 py-4 text-center text-xs text-zinc-400">
                A confirmation email has been sent to {{ $booking->email }}
            </div>
        </div>

        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="/" class="btn-primary text-white px-8 py-4 rounded-xl font-bold hover:shadow-lg hover:-translate-y-1 transition text-lg">
                Back to Home
            </a>
            <a href="{{ route('bookings.show', $booking) }}" class="bg-white text-zinc-600 border border-zinc-200 px-8 py-4 rounded-xl font-bold hover:bg-zinc-50 hover:text-zinc-900 transition text-lg">
                View Receipt
            </a>
        </div>

    </div>
</x-layouts.public>
