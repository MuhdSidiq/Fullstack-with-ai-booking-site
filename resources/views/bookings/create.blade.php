<x-layouts::app :title="__('Create Booking')">
    <div class="max-w-xl mx-auto py-8">
        <h2 class="text-2xl font-bold mb-6">Create Booking</h2>
        <form method="POST" action="{{ route('bookings.store') }}" class="space-y-6">
            @csrf
            <flux:field>
                <flux:label>User</flux:label>
                <flux:select name="user_id" id="user_id" placeholder="Select a user...">
                    @foreach ($users as $user)
                        <flux:select.option value="{{ $user->id }}" :selected="old('user_id') == $user->id">{{ $user->name }}</flux:select.option>
                    @endforeach
                </flux:select>
                <flux:error name="user_id" />
            </flux:field>
            <flux:field>
                <flux:label>Camping Site</flux:label>
                <flux:select name="camping_site_id" placeholder="Select a camping site...">
                    @foreach ($campingSites as $site)
                        <flux:select.option value="{{ $site->id }}" :selected="old('camping_site_id') == $site->id">{{ $site->name }}</flux:select.option>
                    @endforeach
                </flux:select>
                <flux:error name="camping_site_id" />
            </flux:field>
            <flux:field>
                <flux:label>Name</flux:label>
                <flux:input type="text" name="name" id="name" value="{{ old('name') }}" />
                <flux:error name="name" />
            </flux:field>
            <flux:field>
                <flux:label>Email</flux:label>
                <flux:input type="email" name="email" id="email" value="{{ old('email') }}" />
                <flux:error name="email" />
            </flux:field>
            <flux:field>
                <flux:label>Phone</flux:label>
                <flux:input type="text" name="phone" id="phone" value="{{ old('phone') }}" />
                <flux:error name="phone" />
            </flux:field>
            <flux:field>
                <flux:label>Booking Date</flux:label>
                <flux:input type="datetime-local" name="booking_date" value="{{ old('booking_date') }}" />
                <flux:error name="booking_date" />
            </flux:field>
            <flux:field>
                <flux:label>Status</flux:label>
                <flux:select name="status">
                    <flux:select.option value="Pending" :selected="old('status', 'Pending') === 'Pending'">Pending</flux:select.option>
                    <flux:select.option value="Confirmed" :selected="old('status') === 'Confirmed'">Confirmed</flux:select.option>
                    <flux:select.option value="Cancelled" :selected="old('status') === 'Cancelled'">Cancelled</flux:select.option>
                    <flux:select.option value="Rescheduled" :selected="old('status') === 'Rescheduled'">Rescheduled</flux:select.option>
                </flux:select>
                <flux:error name="status" />
            </flux:field>
            <flux:field>
                <flux:label>Remarks</flux:label>
                <flux:input type="text" name="remarks" value="{{ old('remarks') }}" />
                <flux:error name="remarks" />
            </flux:field>
            <div>
                <flux:button variant="primary" type="submit" icon="plus">Create Booking</flux:button>
            </div>
        </form>
    </div>

    <script>
        const users = @json($users->keyBy('id'));

        document.getElementById('user_id').addEventListener('change', function() {
            const userId = this.value;
            const user = users[userId];

            if (user) {
                document.getElementById('name').value = user.name;
                document.getElementById('email').value = user.email;
            } else {
                document.getElementById('name').value = '';
                document.getElementById('email').value = '';
            }
        });
    </script>
</x-layouts::app>
