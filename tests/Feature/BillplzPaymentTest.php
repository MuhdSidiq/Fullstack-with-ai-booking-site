<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\CampingSite;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;
use Billplz\Client;
use Mockery;

class BillplzPaymentTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Mock Billplz configuration
        Config::set('services.billplz', [
            'api_key' => 'test_api_key',
            'x_signature' => 'test_signature',
            'collection_id' => 'test_collection_id',
        ]);
    }

    public function test_checkout_redirects_to_billplz()
    {
        $user = User::factory()->create();
        $campingSite = CampingSite::factory()->create(['price' => 100]);
        $booking = Booking::create([
            'user_id' => $user->id,
            'camping_site_id' => $campingSite->id,
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '1234567890',
            'booking_date' => now()->addDay(),
            'status' => 'Pending',
        ]);

        // Mock Billplz API and Connect
        $connectMock = Mockery::mock(\Billplz\Connect::class);
        $apiMock = Mockery::mock('overload:Billplz\API');
        $apiMock->shouldReceive('createBill')->once()->andReturn([200, json_encode(['url' => 'https://billplz.com/bills/abcdef'])]);
        $apiMock->shouldReceive('toArray')->andReturn([200, ['url' => 'https://billplz.com/bills/abcdef']]);

        $response = $this->get(route('billplz.checkout', $booking));

        $response->assertRedirect('https://billplz.com/bills/abcdef');
    }

    public function test_guest_checkout_redirects_to_billplz()
    {
        $campingSite = CampingSite::factory()->create(['price' => 100]);
        $booking = Booking::create([
            'user_id' => null, // Guest
            'camping_site_id' => $campingSite->id,
            'name' => 'Guest User',
            'email' => 'guest@example.com',
            'phone' => '1234567890',
            'booking_date' => now()->addDay(),
            'status' => 'Pending',
        ]);

        // Mock Billplz API and Connect
        $connectMock = Mockery::mock(\Billplz\Connect::class);
        $apiMock = Mockery::mock('overload:Billplz\API');
        $apiMock->shouldReceive('createBill')->once()->andReturn([200, json_encode(['url' => 'https://billplz.com/bills/guest-bill'])]);
        $apiMock->shouldReceive('toArray')->andReturn([200, ['url' => 'https://billplz.com/bills/guest-bill']]);

        $response = $this->get(route('billplz.checkout', $booking));

        $response->assertRedirect('https://billplz.com/bills/guest-bill');
        $this->assertDatabaseHas('bookings', [
            'id' => $booking->id,
            'user_id' => null
        ]);
    }

    public function test_callback_confirms_booking()
    {
        $user = User::factory()->create();
        $booking = Booking::create([
            'user_id' => $user->id,
            'camping_site_id' => CampingSite::factory()->create(['price' => 100])->id,
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '1234567890',
            'booking_date' => now()->addDay(),
            'status' => 'Pending',
        ]);

        $payload = [
            'id' => 'bill_123',
            'collection_id' => 'test_collection_id',
            'paid' => 'true',
            'state' => 'paid',
            'amount' => '10000',
            'paid_amount' => '10000',
            'reference_1' => (string) $booking->id,
        ];

        // Mock X-Signature
        $content = http_build_query($payload);
        $signature = hash_hmac('sha256', $content, 'test_signature');

        $server = [
            'HTTP_X-Signature' => $signature,
            'CONTENT_TYPE' => 'application/x-www-form-urlencoded',
        ];

        $response = $this->call('POST', route('billplz.callback'), $payload, [], [], $server, $content);

        $response->assertOk();
        
        $this->assertDatabaseHas('bookings', [
            'id' => $booking->id,
            'status' => 'Confirmed',
            'remarks' => 'Payment completed via Billplz (Bill ID: bill_123)',
        ]);
    }
}
