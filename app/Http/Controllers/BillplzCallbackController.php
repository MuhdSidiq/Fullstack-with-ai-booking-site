<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Notifications\BookingConfirmed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BillplzCallbackController extends Controller
{
    /**
     * Handle Billplz callback
     */
    public function handle(Request $request)
    {
        // Get X-Signature from headers
        $xSignature = $request->header('X-Signature');
        $billplzSignature = config('services.billplz.x_signature');

        // Verify signature if enabled
        if ($billplzSignature && $xSignature) {
            $calculatedSignature = hash_hmac('sha256', $request->getContent(), $billplzSignature);

            if ($xSignature !== $calculatedSignature) {
                Log::error('Billplz callback signature verification failed', [
                    'expected' => $calculatedSignature,
                    'received' => $xSignature,
                ]);

                return response()->json(['error' => 'Invalid signature'], 400);
            }
        }

        // Get callback data
        $billId = $request->input('id');
        $collectionId = $request->input('collection_id');
        $paid = $request->input('paid') === 'true';
        $state = $request->input('state');
        $amount = $request->input('amount');
        $paidAmount = $request->input('paid_amount');
        $bookingId = $request->input('reference_1');

        Log::info('Billplz callback received', [
            'bill_id' => $billId,
            'booking_id' => $bookingId,
            'paid' => $paid,
            'state' => $state,
            'amount' => $amount,
        ]);

        // Find booking
        if (! $bookingId) {
            Log::error('Billplz callback missing booking_id');

            return response()->json(['error' => 'Missing booking reference'], 400);
        }

        $booking = Booking::find($bookingId);

        if (! $booking) {
            Log::error('Booking not found', ['booking_id' => $bookingId]);

            return response()->json(['error' => 'Booking not found'], 404);
        }

        // Process payment based on state
        if ($paid && $state === 'paid') {
            // Payment successful
            $booking->update([
                'status' => 'Confirmed',
                'remarks' => "Payment completed via Billplz (Bill ID: {$billId})",
            ]);

            // Send confirmation email
            $booking->notify(new BookingConfirmed($booking));

            Log::info('Booking confirmed and email sent', [
                'booking_id' => $booking->id,
                'bill_id' => $billId,
            ]);
        } else {
            // Payment failed or cancelled
            Log::warning('Billplz payment not completed', [
                'booking_id' => $booking->id,
                'bill_id' => $billId,
                'state' => $state,
                'paid' => $paid,
            ]);
        }

        return response()->json(['status' => 'success']);
    }
}
