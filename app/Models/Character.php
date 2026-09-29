<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Character extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'name', 'slug', 'series', 'bio',
        'image', 'genre', 'abilities', 'tags', 'is_featured', 'popularity',
    ];

    protected $casts = [
        'abilities'   => 'array',
        'tags'        => 'array',
        'is_featured' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function bookmarks()
    {
        return $this->morphMany(Bookmark::class, 'bookmarkable');
    }

    public function ratings()
    {
        return $this->morphMany(Rating::class, 'ratable');
    }

    public function getImageUrlAttribute(): string
    {
        if ($this->image) {
            return str_starts_with($this->image, 'images/')
                ? asset($this->image)
                : asset('storage/' . $this->image);
        }
        return asset('images/placeholder.jpg');
    }
}
