# Product Requirement Document

## Phrase 1: Focus on Model, Database, Controller

### Requirements:
- **Model:**
  - Create models for `Booking`, `CampingSite`, and `User`.
  - Define relationships between models (e.g., `User` has many `Bookings`, `CampingSite` has many `Bookings`).
  - Use an enum for `status` in the `Booking` model (e.g., `Pending`, `Confirmed`, `Cancelled`, `Rescheduled`).
  - Add a `remarks` field to the `Booking` model to store reasons for cancellation or rescheduling.
- **Database:**
  - Design database schema to support bookings, campsites, and users.
  - Implement migrations for creating tables with necessary fields (e.g., `start_date`, `end_date`, `status`, `remarks`).
  - Ensure that no records are deleted; instead, update the `status` and `remarks` fields as needed.
  - Seed database with sample data for testing.
- **Controller:**
  - Develop controllers to handle booking creation and updates.
  - Implement logic for checking campsite availability.
  - Ensure validation rules for user input (e.g., valid dates, required fields).

### Checklist:
- [/] Create models with relationships. 
- [/] Design and implement database schema.
- [/] Develop controllers for booking operations.
- [/] Implement validation rules.

---

## Phrase 2: Focus on Payment Gateway Integration

### Requirements:
- **Payment Processor:**
  - Integrate with Stripe or PayPal for secure transactions.
  - Support credit card and digital wallet payments.
- **Security:**
  - Use encryption to handle sensitive payment data.
  - Ensure compliance with PCI DSS standards.
- **User Experience:**
  - Provide a seamless checkout process.
  - Generate and email digital receipts upon successful payment.

### Checklist:
- [ ] Integrate payment gateway (Stripe/PayPal).
- [ ] Implement encryption for sensitive data.
- [ ] Ensure PCI DSS compliance.
- [ ] Develop receipt generation and email functionality.

---

## Phrase 3: Focus on Admin Views

### Requirements:
- **Dashboard:**
  - Create a central dashboard for managing bookings.
  - Display a searchable list of all current and upcoming bookings.
- **Booking Management:**
  - Allow admins to edit or cancel bookings.
  - Automatically update availability calendar upon changes.
- **User Interface:**
  - Design user-friendly views for managing bookings.
  - Ensure responsiveness for different screen sizes.

### Checklist:
- [ ] Develop admin dashboard.
- [ ] Implement booking management features.
- [ ] Design responsive and user-friendly views.
- [ ] Ensure automatic updates to availability calendar.