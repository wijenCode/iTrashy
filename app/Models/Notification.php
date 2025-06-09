<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'message',
        'type',
        'link',
        'is_read'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
} 