<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory; // Corrected the namespace for HasFactory

class Booking extends Model
{

    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'camping_site_id',
        'name',
        'email',
        'phone',
        'booking_date',
        'status',
        'remarks',
    ];

    protected function casts(): array
    {
        return [
            'booking_date' => 'datetime',
        ];
    }

    /**
     * Enum for booking status.
     */
    const STATUS_PENDING = 'Pending';
    const STATUS_CONFIRMED = 'Confirmed';
    const STATUS_CANCELLED = 'Cancelled';
    const STATUS_RESCHEDULED = 'Rescheduled';

    /**
     * Relationships
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function campingSite()
    {
        return $this->belongsTo(CampingSite::class);
    }
}
