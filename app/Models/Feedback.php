<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Feedback extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'name', 'email', 'type', 'subject',
        'message', 'status', 'admin_notes',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
