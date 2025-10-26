<?php

namespace App\Jobs;

use App\Models\Photo;
use App\Services\PhotoOptimizationService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class OptimizePhotoJob implements ShouldQueue
{
    use Queueable;

    public function __construct(public Photo $photo)
    {
    }

    public function handle(PhotoOptimizationService $service): void
    {
        $service->optimize($this->photo);
    }
}
