<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AlbumGuestLogin extends Model
{
    protected $fillable = [
        'album_id',
        'email',
    ];

    public function album(): BelongsTo
    {
        return $this->belongsTo(Album::class);
    }
}
