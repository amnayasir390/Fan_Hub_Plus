<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FanSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'category_id', 'title', 'excerpt', 'body',
        'cover_image', 'status', 'admin_notes',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getCoverImageUrlAttribute(): string
    {
        if ($this->cover_image) {
            return asset('storage/' . $this->cover_image);
        }
        return asset('images/placeholder.jpg');
    }
}
