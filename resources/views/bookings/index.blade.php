<x-layouts::app :title="__('Bookings')">
    <div class="container mx-auto py-8">
        <h1 class="text-3xl font-bold mb-6 text-center text-blue-600">Bookings</h1>

        <div class="overflow-x-auto">
            <table class="table-auto w-full border-collapse border border-gray-300 shadow-lg">
                <thead>
                    <tr class="bg-blue-100 text-blue-800">
                        <th class="border border-gray-300 px-4 py-2">#</th>
                        <th class="border border-gray-300 px-4 py-2">Customer Name</th>
                        <th class="border border-gray-300 px-4 py-2">Date</th>
                        <th class="border border-gray-300 px-4 py-2">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($bookings as $booking)
                        <tr class="odd:bg-white even:bg-gray-50 hover:bg-blue-50">
                            <td class="border border-gray-300 px-4 py-2 text-center">{{ $loop->iteration }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $booking->name }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $booking->booking_date }}</td>
                            <td class="border border-gray-300 px-4 py-2 text-center">
                                <span class="px-2 py-1 rounded-full text-white {{ $booking->status === 'confirmed' ? 'bg-green-500' : ($booking->status === 'pending' ? 'bg-yellow-500' : 'bg-red-500') }}">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center border border-gray-300 px-4 py-2 text-gray-500">No bookings available.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $bookings->links() }} <!-- Added pagination links -->
        </div>
    </div>
</x-layouts::app>