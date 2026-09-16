<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_name',
        'booking_id',
        'total_budget',
        'food_budget',
        'buffet_cost',
        'beverages_cost',
        'desserts_cost',
        'snacks_cost',
        'total_spent',
        'remaining_budget',
        'variance',
    ];

    protected $casts = [
        'total_budget' => 'decimal:2',
        'food_budget' => 'decimal:2',
        'buffet_cost' => 'decimal:2',
        'beverages_cost' => 'decimal:2',
        'desserts_cost' => 'decimal:2',
        'snacks_cost' => 'decimal:2',
        'total_spent' => 'decimal:2',
        'remaining_budget' => 'decimal:2',
        'variance' => 'decimal:2',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id', 'BookingID');
    }
}
