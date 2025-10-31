<?php

namespace App\Models;

use App\AlbumStatus;
use App\Observers\AlbumObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[ObservedBy([AlbumObserver::class])]
class Album extends Model
{
    /** @use HasFactory<\Database\Factories\AlbumFactory> */
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'start_date',
        'end_date',
        'status',
        'manager_email',
        'manager_id',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'status' => AlbumStatus::class,
        ];
    }

    public function photos(): HasMany
    {
        return $this->hasMany(Photo::class);
    }

    public function manager(): BelongsTo
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    public function firstPhoto(): ?Photo
    {
        return $this->photos()->first();
    }

    public function getInitials(): string
    {
        $words = explode(' ', $this->name);
        $initials = '';
        foreach ($words as $word) {
            $initials .= strtoupper(substr($word, 0, 1));
        }

        return $initials;
    }
}
