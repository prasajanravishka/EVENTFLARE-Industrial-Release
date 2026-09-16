<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventExtra extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'equipment',
        'food_style',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id', 'BookingID');
    }
}
