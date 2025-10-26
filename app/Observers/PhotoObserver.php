<?php

namespace App\Observers;

use App\Jobs\OptimizePhotoJob;
use App\Models\Photo;

class PhotoObserver
{
    public function created(Photo $photo): void
    {
        $isSync = config('photos.is_sync');

        if ($isSync) {
            app(\App\Services\PhotoOptimizationService::class)->optimize($photo);
        } else {
            OptimizePhotoJob::dispatch($photo);
        }
    }
}
