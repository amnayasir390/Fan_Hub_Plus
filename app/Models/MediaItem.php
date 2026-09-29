<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MediaItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'title', 'description', 'media_type',
        'url', 'thumbnail', 'duration', 'tags', 'view_count',
        'is_featured', 'uploaded_by',
    ];

    protected $casts = [
        'tags'        => 'array',
        'is_featured' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
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

    public function getThumbnailUrlAttribute(): string
    {
        if ($this->thumbnail) {
            return asset('storage/' . $this->thumbnail);
        }
        return asset('images/placeholder.jpg');
    }

    public function getEmbedUrlAttribute(): string
    {
        $url = $this->url;
        // Convert YouTube watch URLs to embed
        if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]+)/', $url, $matches)) {
            return 'https://www.youtube.com/embed/' . $matches[1];
        }
        return $url;
    }
}
