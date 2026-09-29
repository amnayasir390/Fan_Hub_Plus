<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'user_id', 'title', 'slug', 'excerpt', 'body',
        'cover_image', 'article_type', 'status', 'tags', 'is_featured',
        'view_count', 'event_date', 'event_location',
    ];

    protected $casts = [
        'tags'        => 'array',
        'is_featured' => 'boolean',
        'event_date'  => 'date',
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
