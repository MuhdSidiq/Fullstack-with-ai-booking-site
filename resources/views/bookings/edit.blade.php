<x-layouts::app :title="__('Edit Booking')">
    <div class="max-w-xl mx-auto py-8">
        <h2 class="text-2xl font-bold mb-6">Edit Booking</h2>
        <form method="POST" action="{{ route('bookings.update', $booking) }}" class="space-y-6">
            @csrf
            @method('PUT')
            <flux:field>
                <flux:label>User</flux:label>
                <flux:select name="user_id" placeholder="Select a user...">
                    @foreach ($users as $user)
                        <flux:select.option value="{{ $user->id }}" :selected="old('user_id', $booking->user_id) == $user->id">{{ $user->name }}</flux:select.option>
                    @endforeach
                </flux:select>
                <flux:error name="user_id" />
            </flux:field>
            <flux:field>
                <flux:label>Camping Site</flux:label>
                <flux:select name="camping_site_id" placeholder="Select a camping site...">
                    @foreach ($campingSites as $site)
                        <flux:select.option value="{{ $site->id }}" :selected="old('camping_site_id', $booking->camping_site_id) == $site->id">{{ $site->name }}</flux:select.option>
                    @endforeach
                </flux:select>
                <flux:error name="camping_site_id" />
            </flux:field>
            <flux:field>
                <flux:label>Name</flux:label>
                <flux:input type="text" name="name" value="{{ old('name', $booking->name) }}" />
                <flux:error name="name" />
            </flux:field>
            <flux:field>
                <flux:label>Email</flux:label>
                <flux:input type="email" name="email" value="{{ old('email', $booking->email) }}" />
                <flux:error name="email" />
            </flux:field>
            <flux:field>
                <flux:label>Phone</flux:label>
                <flux:input type="text" name="phone" value="{{ old('phone', $booking->phone) }}" />
                <flux:error name="phone" />
            </flux:field>
            <flux:field>
                <flux:label>Booking Date</flux:label>
                <flux:input type="datetime-local" name="booking_date" value="{{ old('booking_date', $booking->booking_date?->format('Y-m-d\TH:i')) }}" />
                <flux:error name="booking_date" />
            </flux:field>
            <flux:field>
                <flux:label>Status</flux:label>
                <flux:select name="status">
                    <flux:select.option value="Pending" :selected="old('status', $booking->status) === 'Pending'">Pending</flux:select.option>
                    <flux:select.option value="Confirmed" :selected="old('status', $booking->status) === 'Confirmed'">Confirmed</flux:select.option>
                    <flux:select.option value="Cancelled" :selected="old('status', $booking->status) === 'Cancelled'">Cancelled</flux:select.option>
                    <flux:select.option value="Rescheduled" :selected="old('status', $booking->status) === 'Rescheduled'">Rescheduled</flux:select.option>
                </flux:select>
                <flux:error name="status" />
            </flux:field>
            <flux:field>
                <flux:label>Remarks</flux:label>
                <flux:input type="text" name="remarks" value="{{ old('remarks', $booking->remarks) }}" />
                <flux:error name="remarks" />
            </flux:field>
            <div class="flex gap-2">
                <flux:button variant="primary" type="submit">Update Booking</flux:button>
                <flux:button variant="ghost" href="{{ route('bookings.index') }}">Cancel</flux:button>
            </div>
        </form>
    </div>
</x-layouts::app>
