<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookingConfirmed extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public Booking $booking)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $campingSite = $this->booking->campingSite;

        return (new MailMessage)
            ->subject('Booking Confirmed - '.$campingSite->name)
            ->greeting('Hello '.$this->booking->name.'!')
            ->line('Your camping site booking has been confirmed.')
            ->line('**Booking Details:**')
            ->line('Camping Site: '.$campingSite->name)
            ->line('Date: '.$this->booking->booking_date->format('l, F j, Y'))
            ->line('Amount Paid: RM '.number_format($campingSite->price, 2))
            ->action('View Booking', route('bookings.show', $this->booking))
            ->line('We look forward to seeing you!')
            ->line('If you have any questions, please contact us.')
            ->salutation('Best regards, '.config('app.name'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'booking_id' => $this->booking->id,
            'camping_site' => $this->booking->campingSite->name,
            'booking_date' => $this->booking->booking_date->toDateString(),
        ];
    }
}
