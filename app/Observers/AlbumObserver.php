<?php

namespace App\Observers;

use App\Models\Album;

class AlbumObserver
{
    public function creating(Album $album): void
    {
        if (empty($album->slug)) {
            $album->slug = $this->generateSlug($album->name);
        }
    }

    private function generateSlug(string $name): string
    {
        $words = explode(' ', $name);
        $initials = '';
        
        foreach ($words as $word) {
            if (! empty($word)) {
                $initials .= strtoupper(substr($word, 0, 1));
            }
        }
        
        $slug = strtoupper(substr($initials, 0, 3));
        
        $counter = 1;
        $uniqueSlug = $slug.str_pad((string) $counter, 4, '0', STR_PAD_LEFT);
        
        while (Album::query()->where('slug', $uniqueSlug)->exists()) {
            $counter++;
            $uniqueSlug = $slug.str_pad((string) $counter, 4, '0', STR_PAD_LEFT);
        }
        
        return $uniqueSlug;
    }

    /**
     * Handle the Album "deleted" event.
     */
    public function deleted(Album $album): void
    {
        //
    }

    /**
     * Handle the Album "restored" event.
     */
    public function restored(Album $album): void
    {
        //
    }

    /**
     * Handle the Album "force deleted" event.
     */
    public function forceDeleted(Album $album): void
    {
        //
    }
}
