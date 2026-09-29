<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'avatar', 'role',
        'favorite_fandoms', 'categories_of_interest',
        'display_preference', 'font_size', 'dark_mode', 'bio',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at'      => 'datetime',
            'password'               => 'hashed',
            'favorite_fandoms'       => 'array',
            'categories_of_interest' => 'array',
            'dark_mode'              => 'boolean',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function feedback()
    {
        return $this->hasMany(Feedback::class);
    }

    public function fanSubmissions()
    {
        return $this->hasMany(FanSubmission::class);
    }

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function chatHistory()
    {
        return $this->hasMany(ChatHistory::class);
    }

    public function getAvatarUrlAttribute(): string
    {
        if ($this->avatar) {
            return asset('storage/' . $this->avatar);
        }
        $name = urlencode($this->name);
        return "https://ui-avatars.com/api/?name={$name}&background=4A26B7&color=D6CBD6&size=128";
    }
}
