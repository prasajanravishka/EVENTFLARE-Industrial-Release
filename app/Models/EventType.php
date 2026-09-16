<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventType extends Model
{
    use HasFactory;

    protected $primaryKey = 'event_type_id';

    protected $fillable = [
        'type_name',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function services()
    {
        return $this->hasMany(Service::class, 'event_type_id', 'event_type_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
