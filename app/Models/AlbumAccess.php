<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AlbumAccess extends Model
{
    protected $fillable = [
        'album_id',
        'user_id',
        'ip_address',
        'user_agent',
        'accessed_at',
    ];

    protected $casts = [
        'accessed_at' => 'datetime',
    ];

    public function album(): BelongsTo
    {
        return $this->belongsTo(Album::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
