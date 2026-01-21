# Billplz Integration Setup

This project uses Billplz for payment processing. Follow these steps to configure it.

## 1. Environment Variables

Add the following variables to your `.env` file:

```env
BILLPLZ_API_KEY=your_billplz_api_key
BILLPLZ_X_SIGNATURE=your_billplz_x_signature
BILLPLZ_COLLECTION_ID=your_billplz_collection_id
```

You can find these values in your [Billplz Dashboard](https://www.billplz.com/dashboard).

## 2. Webhook Configuration

To handle payment callbacks, you need to set up the Callback URL in your Billplz Collection settings.

**Callback URL:** `https://your-domain.com/billplz/callback`

If you are developing locally, use a tool like [Expose](https://expose.dev) or [Ngrok](https://ngrok.com) to tunnel your local server and use the public URL.

## 3. Usage

### Checkout
To initiate a payment for a booking, verify the booking is in `Pending` status and redirect the user to:
`route('billplz.checkout', $booking)`

### Callback
The system automatically handles callbacks at `/billplz/callback`. It verifies the `X-Signature`, updates the booking status to `Confirmed`, and sends a confirmation email.
