<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\CampingSite;
use App\Models\User;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
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
            'user_id' => 'required|exists:users,id',
            'camping_site_id' => 'required|exists:camping_sites,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'booking_date' => 'required|date|after_or_equal:today',
            'status' => 'required|in:Pending,Confirmed,Cancelled,Rescheduled',
            'remarks' => 'nullable|string|max:255',
        ]);
        $booking = Booking::create($validated);
        
        return redirect()->route('bookings.index')->with('success', 'Booking created successfully.');
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
}
