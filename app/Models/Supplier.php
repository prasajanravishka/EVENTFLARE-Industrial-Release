<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'business_name',
        'category',
        'description',
        'contact_phone',
        'location',
        'logo_url',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function listings()
    {
        return $this->hasMany(SupplierListing::class, 'supplier_id', 'id');
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'supplier_services', 'supplier_id', 'service_id');
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class, 'supplier_id');
    }

    public function bookingServices()
    {
        return $this->hasMany(BookingService::class, 'supplier_id');
    }
}
