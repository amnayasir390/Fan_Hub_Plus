<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'ratable_type', 'ratable_id', 'score', 'thumbs_up'];

    protected $casts = [
        'thumbs_up' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ratable()
    {
        return $this->morphTo();
    }
}
