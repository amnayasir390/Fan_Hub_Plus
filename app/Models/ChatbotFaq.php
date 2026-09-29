<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ChatbotFaq extends Model
{
    use HasFactory;

    protected $fillable = [
        'question', 'answer', 'category', 'keywords', 'is_active', 'sort_order',
    ];

    protected $casts = [
        'keywords'  => 'array',
        'is_active' => 'boolean',
    ];
}
