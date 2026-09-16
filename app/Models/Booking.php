<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $primaryKey = 'BookingID';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'BookingID',
        'user_id',
        'user_name',
        'EventType',
        'Place',
        'NumberOfGuests',
        'EventDate',
        'DayNight',
        'FoodPreferences',
        'ExtraDetails',
        'status',
    ];

    protected $casts = [
        'EventDate' => 'date',
        'NumberOfGuests' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function services()
    {
        return $this->hasMany(BookingService::class, 'booking_id', 'BookingID');
    }

    public function extra()
    {
        return $this->hasOne(EventExtra::class, 'booking_id', 'BookingID');
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class, 'booking_id', 'BookingID');
    }
}
