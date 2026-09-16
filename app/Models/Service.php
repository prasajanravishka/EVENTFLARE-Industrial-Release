<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $primaryKey = 'service_id';

    protected $fillable = [
        'event_type_id',
        'service_name',
        'description',
        'priority_rank',
        'is_required',
        'typical_capacity',
        'notes',
    ];

    protected $casts = [
        'is_required' => 'boolean',
    ];

    public function eventType()
    {
        return $this->belongsTo(EventType::class, 'event_type_id', 'event_type_id');
    }

    public function suppliers()
    {
        return $this->belongsToMany(Supplier::class, 'supplier_services', 'service_id', 'supplier_id');
    }

    public function listings()
    {
        return $this->hasMany(SupplierListing::class, 'service_id', 'service_id');
    }
}
