<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Content extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'title', 'slug', 'excerpt', 'body',
        'cover_image', 'content_type', 'genre', 'release_year',
        'popularity', 'view_count', 'status', 'user_id', 'tags',
    ];

    protected $casts = [
        'tags' => 'array',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bookmarks()
    {
        return $this->morphMany(Bookmark::class, 'bookmarkable');
    }

    public function ratings()
    {
        return $this->morphMany(Rating::class, 'ratable');
    }

    public function getAverageRatingAttribute(): float
    {
        return round($this->ratings()->avg('score') ?? 0, 1);
    }

    public function getCoverImageUrlAttribute(): string
    {
        if ($this->cover_image) {
            return str_starts_with($this->cover_image, 'images/')
                ? asset($this->cover_image)
                : asset('storage/' . $this->cover_image);
        }
        return asset('images/placeholder.jpg');
    }
}
