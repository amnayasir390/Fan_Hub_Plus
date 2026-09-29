<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'description', 'icon', 'color', 'cover_image', 'is_active', 'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function contents()
    {
        return $this->hasMany(Content::class);
    }

    public function mediaItems()
    {
        return $this->hasMany(MediaItem::class);
    }

    public function characters()
    {
        return $this->hasMany(Character::class);
    }

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function merchandise()
    {
        return $this->hasMany(Merchandise::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function fanSubmissions()
    {
        return $this->hasMany(FanSubmission::class);
    }
}
