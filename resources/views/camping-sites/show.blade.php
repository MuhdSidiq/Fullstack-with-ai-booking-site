<x-layouts.public :title="$campingSite->name">
    <div class="max-w-4xl mx-auto py-12 px-6">
        <div class="bg-white dark:bg-zinc-900 rounded-3xl overflow-hidden shadow-xl border border-zinc-200 dark:border-zinc-800">
            <!-- Header / Image Placeholder -->
            <div class="h-64 bg-zinc-100 dark:bg-zinc-800 relative">
                 @php
                    // Simple logic to pick an image based on name/type (similar to HomeController)
                    $name = strtolower($campingSite->name);
                    $img = 'https://images.unsplash.com/photo-1523987355523-c7b5b0dd90a7?auto=format&fit=crop&q=80&w=1200';
                    if (str_contains($name, 'rv')) $img = 'https://images.unsplash.com/photo-1526772662000-3f88f10405ff?auto=format&fit=crop&q=80&w=1200';
                    elseif (str_contains($name, 'glamping')) $img = 'https://images.unsplash.com/photo-1533167649158-6d508895b680?auto=format&fit=crop&q=80&w=1200';
                @endphp
                <img src="{{ $img }}" alt="{{ $campingSite->name }}" class="w-full h-full object-cover">
                <div class="absolute bottom-6 left-6">
                    <h1 class="text-4xl font-extrabold text-white drop-shadow-lg">{{ $campingSite->name }}</h1>
                    <div class="flex items-center gap-2 text-white/90 drop-shadow-md mt-2">
                        <flux:icon name="map-pin" class="w-5 h-5" />
                        <span>{{ $campingSite->location }}</span>
                    </div>
                </div>
            </div>

            <div class="p-8 grid md:grid-cols-3 gap-12">
                <!-- Details Column -->
                <div class="md:col-span-2 space-y-8">
                    <div>
                        <h2 class="text-xl font-bold mb-4">About this site</h2>
                        <p class="text-zinc-600 dark:text-zinc-400 leading-relaxed">
                            Experience the outdoors in style. This site offers premium amenities and beautiful views.
                            {{ $campingSite->is_prime_location ? 'Located in a prime spot for best views and privacy.' : '' }}
                        </p>
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div class="bg-zinc-50 dark:bg-zinc-800/50 p-4 rounded-xl">
                            <div class="text-sm text-zinc-500 mb-1">Capacity</div>
                            <div class="font-semibold text-lg flex items-center gap-2">
                                <flux:icon name="users" class="w-5 h-5 text-emerald-500" />
                                {{ $campingSite->capacity }} People
                            </div>
                        </div>
                        <div class="bg-zinc-50 dark:bg-zinc-800/50 p-4 rounded-xl">
                            <div class="text-sm text-zinc-500 mb-1">Price per Night</div>
                            <div class="font-semibold text-lg flex items-center gap-2">
                                <flux:icon name="currency-dollar" class="w-5 h-5 text-emerald-500" />
                                ${{ number_format($campingSite->price, 2) }}
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="font-bold mb-3">Facilities</h3>
                        <div class="flex flex-wrap gap-2">
                            @if(is_array($campingSite->facilities))
                                @foreach($campingSite->facilities as $facility)
                                    <span class="px-3 py-1 bg-emerald-100 text-emerald-800 rounded-full text-sm font-medium">
                                        {{ $facility }}
                                    </span>
                                @endforeach
                            @else
                                <span class="text-zinc-400 italic">No specific facilities listed.</span>
                            @endif
                        </div>
                    </div>

                    @if($campingSite->map_url)
                        <div>
                            <a href="{{ $campingSite->map_url }}" target="_blank" class="inline-flex items-center gap-2 text-emerald-600 hover:text-emerald-700 font-medium">
                                <flux:icon name="map" class="w-5 h-5" />
                                View on Map
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Booking Form Column -->
                <div class="md:col-span-1">
                    <div class="bg-zinc-50 dark:bg-zinc-800/50 p-6 rounded-2xl border border-zinc-100 dark:border-zinc-700/50 sticky top-6">
                        <h2 class="text-xl font-bold mb-6">Book Now</h2>
                        
                        <form action="{{ route('bookings.store') }}" method="POST" class="space-y-4">
                            @csrf
                            <input type="hidden" name="camping_site_id" value="{{ $campingSite->id }}">
                            <input type="hidden" name="status" value="Pending">

                            <flux:field>
                                <flux:label>Full Name</flux:label>
                                <flux:input type="text" name="name" required placeholder="John Doe" value="{{ auth()->user()?->name }}" />
                                <flux:error name="name" />
                            </flux:field>

                            <flux:field>
                                <flux:label>Email Address</flux:label>
                                <flux:input type="email" name="email" required placeholder="john@example.com" value="{{ auth()->user()?->email }}" />
                                <flux:error name="email" />
                            </flux:field>

                            <flux:field>
                                <flux:label>Phone Number</flux:label>
                                <flux:input type="tel" name="phone" required placeholder="+1 234 567 890" />
                                <flux:error name="phone" />
                            </flux:field>

                            <flux:field>
                                <flux:label>Booking Date</flux:label>
                                <flux:input type="date" name="date" required min="{{ date('Y-m-d') }}" />
                                <flux:error name="date" />
                            </flux:field>

                            <div class="pt-4">
                                <flux:button variant="primary" type="submit" class="w-full justify-center">
                                    Book & Pay
                                </flux:button>
                                <p class="text-xs text-center text-zinc-400 mt-3">
                                    You will be redirected to Billplz for payment.
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.public>
