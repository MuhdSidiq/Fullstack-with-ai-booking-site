<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\CampingSite;
use App\Models\User;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * Redirect to Billplz payment page
     */
    public function billplzCheckout(Booking $booking)
    {
        // Ensure booking is in Pending status
        if ($booking->status !== 'Pending') {
            return redirect()->route('bookings.index')
                ->with('error', 'This booking cannot be paid. Status: '.$booking->status);
        }

        $campingSite = $booking->campingSite;

        // Initialize Billplz
        $connect = new \Billplz\Connect(config('services.billplz.api_key'));
        
        if (config('services.billplz.url')) {
            $connect->url = config('services.billplz.url');
        } else {
            $connect->detectMode();
        }
        
        $billplz = new \Billplz\API($connect);

        // Create a bill
        $response = $billplz->createBill(
            [
                'collection_id' => config('services.billplz.collection_id'),
                'email' => $booking->email,
                'name' => $booking->name,
                'amount' => (int) ($campingSite->price * 100), // Amount in cents
                'callback_url' => route('billplz.callback'),
                'description' => 'Booking for ' . $campingSite->name . ' on ' . $booking->booking_date->format('M d, Y'),
            ],
            [
                'redirect_url' => route('bookings.thank-you', $booking),
                'reference_1_label' => 'Booking ID',
                'reference_1' => (string) $booking->id,
                'reference_2_label' => 'Camping Site',
                'reference_2' => $campingSite->name,
            ]
        );

        list($rheader, $rbody) = $billplz->toArray($response);

        // Check if bill creation was successful
        if ($rheader !== 200) {
            \Illuminate\Support\Facades\Log::error('Billplz creation failed', ['response' => $rbody]);
            return redirect()->route('bookings.show', $booking)
                ->with('error', 'Failed to create payment. Please try again.');
        }

        // Redirect to Billplz payment page
        return redirect($rbody['url']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!auth()->check()) {
            return redirect()->route('home')->with('success', 'If you completed a payment, your booking status will be updated shortly.');
        }

        $bookings = Booking::with('campingSite')->orderBy('booking_date', 'desc')->paginate(20);

        return view('bookings.index', compact('bookings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::orderBy('name')->get();
        $campingSites = CampingSite::orderBy('name')->get();

        return view('bookings.create', compact('users', 'campingSites'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'camping_site_id' => 'required|exists:camping_sites,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'date' => 'required|date|after_or_equal:today',
        ]);

        $booking = Booking::create([
            'user_id' => $validated['user_id'] ?? auth()->id(),
            'camping_site_id' => $validated['camping_site_id'],
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'booking_date' => $validated['date'],
            'status' => 'Pending',
        ]);

        // Redirect to Billplz payment page
        return redirect()->route('billplz.checkout', ['booking' => $booking->id]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Booking $booking)
    {
        $booking->load(['user', 'campingSite']);

        return view('bookings.show', compact('booking'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Booking $booking)
    {
        $users = User::orderBy('name')->get();
        $campingSites = CampingSite::orderBy('name')->get();

        return view('bookings.edit', compact('booking', 'users', 'campingSites'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'camping_site_id' => 'required|exists:camping_sites,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'booking_date' => 'required|date|after_or_equal:today',
            'status' => 'required|in:Pending,Confirmed,Cancelled,Rescheduled',
            'remarks' => 'nullable|string|max:255',
        ]);
        $booking->update($validated);

        return redirect()->route('bookings.index')->with('success', 'Booking updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Booking $booking)
    {
        // Instead of deleting, mark as cancelled and add remarks
        $booking->update([
            'status' => 'Cancelled',
            'remarks' => 'Cancelled by admin',
        ]);

        return redirect()->route('bookings.index')->with('success', 'Booking cancelled.');
    }

    /**
     * Show the payment confirmation page.
     */
    public function thankYou(Booking $booking)
    {
        // Optional: Check if really paid/confirmed, or show specific message if pending
        return view('bookings.thank-you', compact('booking'));
    }
}
