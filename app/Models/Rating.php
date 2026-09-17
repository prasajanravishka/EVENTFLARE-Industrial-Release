<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'user_id',
        'supplier_id',
        'rating',
        'rating_quality',
        'rating_punctuality',
        'rating_communication',
        'rating_value',
        'photos',
        'review_title',
        'review_text',
        'supplier_reply',
        'supplier_replied_at',
        'admin_status',
    ];

    protected $casts = [
        'rating' => 'integer',
        'rating_quality' => 'integer',
        'rating_punctuality' => 'integer',
        'rating_communication' => 'integer',
        'rating_value' => 'integer',
        'photos' => 'array',
        'supplier_replied_at' => 'datetime',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id', 'BookingID');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function scopeApproved($query)
    {
        return $query->where('admin_status', 'approved');
    }
}
