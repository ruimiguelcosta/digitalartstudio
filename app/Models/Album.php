<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Album extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'title',
        'description',
        'event_start_date',
        'event_end_date',
        'slug',
        'is_public',
        'user_id',
    ];

    protected $casts = [
        'is_public' => 'boolean',
        'event_start_date' => 'date',
        'event_end_date' => 'date',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($album) {
            if (empty($album->slug)) {
                $album->slug = Str::slug($album->title);
            }
        });

        static::updating(function ($album) {
            if ($album->isDirty('title') && empty($album->slug)) {
                $album->slug = Str::slug($album->title);
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function photos(): HasMany
    {
        return $this->hasMany(Photo::class)->orderBy('order');
    }

    public function featuredPhoto(): HasMany
    {
        return $this->hasMany(Photo::class)->where('is_featured', true);
    }

    public function accesses(): HasMany
    {
        return $this->hasMany(AlbumAccess::class)->latest('accessed_at');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
