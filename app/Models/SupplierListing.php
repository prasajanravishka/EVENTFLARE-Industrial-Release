<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierListing extends Model
{
    use HasFactory;

    protected $primaryKey = 'listing_id';

    protected $fillable = [
        'supplier_id',
        'service_id',
        'title',
        'description',
        'price',
        'price_type',
        'capacity',
        'image_url',
        'status',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id', 'service_id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
