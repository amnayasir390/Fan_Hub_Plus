<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Merchandise extends Model
{
    use HasFactory;

    protected $table = 'merchandise';

    protected $fillable = [
        'category_id', 'name', 'slug', 'description', 'image',
        'gallery_images', 'price', 'badge', 'status', 'release_date',
        'buy_link', 'view_count', 'popularity', 'is_featured',
    ];

    protected $casts = [
        'gallery_images' => 'array',
        'is_featured'    => 'boolean',
        'release_date'   => 'date',
        'price'          => 'decimal:2',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function bookmarks()
    {
        return $this->morphMany(Bookmark::class, 'bookmarkable');
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
