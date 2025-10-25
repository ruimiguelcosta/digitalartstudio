<?php

namespace App\Models;

use App\Observers\PhotoObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

#[ObservedBy([PhotoObserver::class])]
class Photo extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'ref',
        'title',
        'description',
        'filename',
        'original_filename',
        'mime_type',
        'file_size',
        'path',
        'url',
        'order',
        'is_featured',
        'album_id',
        'user_id',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'file_size' => 'integer',
        'order' => 'integer',
    ];

    public function album(): BelongsTo
    {
        return $this->belongsTo(Album::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getUrlAttribute($value): string
    {
        if (str_starts_with($value, 'http')) {
            return $value;
        }

        return Storage::url($value);
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getFormattedFileSizeAttribute(): string
    {
        $bytes = $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB'];

        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, 2).' '.$units[$i];
    }
}
