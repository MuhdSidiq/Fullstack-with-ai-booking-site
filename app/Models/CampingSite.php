<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampingSite extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'location',
        'capacity',
        'price',
        'is_prime_location',
        'facilities',
        'map_url',
    ];

    protected $casts = [
        'facilities' => 'array',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
