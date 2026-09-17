<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseStudy extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_type_id',
        'booking_id',
        'title',
        'category_tag',
        'category_label',
        'venue',
        'event_date',
        'guests_count',
        'image_url',
        'tagline',
        'summary',
        'quote',
        'client_name',
        'services_delivered',
        'is_featured_home',
        'is_active',
        'display_order',
    ];

    protected $casts = [
        'services_delivered' => 'array',
        'is_featured_home' => 'boolean',
        'is_active' => 'boolean',
        'guests_count' => 'integer',
        'display_order' => 'integer',
    ];

    public function eventType()
    {
        return $this->belongsTo(EventType::class, 'event_type_id', 'event_type_id');
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id', 'BookingID');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured_home', true);
    }
}
