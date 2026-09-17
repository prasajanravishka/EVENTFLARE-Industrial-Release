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
        'image_url',
        'badge',
        'chips',
        'vendor_count_label',
        'accent_color',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected $appends = [
        'image_display_url',
    ];

    public function getImageDisplayUrlAttribute(): ?string
    {
        if (!$this->image_url) {
            return null;
        }

        if (str_starts_with($this->image_url, 'http://') || str_starts_with($this->image_url, 'https://')) {
            return $this->image_url;
        }

        return asset(ltrim($this->image_url, '/'));
    }

    public function services()
    {
        return $this->hasMany(Service::class, 'event_type_id', 'event_type_id');
    }

    public function caseStudies()
    {
        return $this->hasMany(CaseStudy::class, 'event_type_id', 'event_type_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
