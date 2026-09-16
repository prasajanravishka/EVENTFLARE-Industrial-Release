<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingService extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'service_id',
        'supplier_id',
        'listing_id',
        'custom_notes',
        'assigned_cost',
        'status',
    ];

    protected $casts = [
        'assigned_cost' => 'decimal:2',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id', 'BookingID');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id', 'service_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }

    public function listing()
    {
        return $this->belongsTo(SupplierListing::class, 'listing_id', 'listing_id');
    }
}
