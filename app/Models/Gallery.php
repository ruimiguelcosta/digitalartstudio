<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Gallery extends Model
{
    /** @use HasFactory<\Database\Factories\GalleryFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'cover_photo',
        'active',
        'order',
    ];

    protected function casts(): array
    {
        return [
            'active' => 'boolean',
            'order' => 'integer',
        ];
    }

    public function getCoverPhotoUrlAttribute(): ?string
    {
        if (! $this->cover_photo) {
            return null;
        }

        $path = $this->cover_photo;

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        $path = ltrim($path, '/');

        $possiblePaths = [
            $path,
            'galleries/'.$path,
            str_replace('galleries/', '', $path),
        ];

        foreach ($possiblePaths as $testPath) {
            if (Storage::disk('public')->exists($testPath)) {
                return asset('storage/'.$testPath);
            }
        }

        $urlPath = str_starts_with($path, 'galleries/') ? $path : 'galleries/'.$path;

        return asset('storage/'.$urlPath);
    }
}
