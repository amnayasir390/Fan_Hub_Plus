<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'title', 'description', 'event_type',
        'start_date', 'end_date', 'venue', 'city', 'country',
        'latitude', 'longitude', 'ticket_link', 'image', 'is_featured',
    ];

    protected $casts = [
        'start_date'  => 'datetime',
        'end_date'    => 'datetime',
        'is_featured' => 'boolean',
        'latitude'    => 'decimal:7',
        'longitude'   => 'decimal:7',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getImageUrlAttribute(): string
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        return asset('images/placeholder.jpg');
    }

    public function scopeUpcoming($query)
    {
        return $query->where('start_date', '>=', now())->orderBy('start_date');
    }

    public function scopeByCity($query, $city)
    {
        return $query->where('city', 'like', "%{$city}%");
    }
}
