<?php

namespace App\Observers;

use App\Jobs\OptimizeImageJob;
use App\Models\Photo;

class PhotoObserver
{
    public function created(Photo $photo): void
    {
        OptimizeImageJob::dispatch($photo);
    }
}
