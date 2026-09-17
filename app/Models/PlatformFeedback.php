<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlatformFeedback extends Model
{
    use HasFactory;

    protected $table = 'platform_feedback';

    protected $fillable = [
        'user_id',
        'booking_id',
        'nps_score',
        'platform_rating',
        'category',
        'comments',
    ];

    protected $casts = [
        'nps_score' => 'integer',
        'platform_rating' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id', 'BookingID');
    }
}
