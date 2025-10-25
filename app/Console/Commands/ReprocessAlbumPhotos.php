<?php

namespace App\Console\Commands;

use App\Jobs\OptimizeImageJob;
use App\Models\Album;
use Illuminate\Console\Command;

class ReprocessAlbumPhotos extends Command
{
    protected $signature = 'photos:reprocess-album {album_id : ID of the album to reprocess} {--force : Force reprocessing even if already processed}';

    protected $description = 'Reprocess all photos in a specific album with watermark and optimization';

    public function handle(): int
    {
        $albumId = $this->argument('album_id');
        $force = $this->option('force');

        $album = Album::query()->find($albumId);

        if (! $album) {
            $this->error("Album with ID {$albumId} not found.");

            return 1;
        }

        $photos = $album->photos()->get();

        if ($photos->isEmpty()) {
            $this->info("No photos found in album '{$album->title}'.");

            return 0;
        }

        $this->info("Found {$photos->count()} photos in album '{$album->title}'.");

        if (! $force) {
            $processedCount = $photos->whereNotNull('url')->count();
            if ($processedCount > 0) {
                $this->warn("{$processedCount} photos appear to be already processed.");
                if (! $this->confirm('Do you want to reprocess them anyway?')) {
                    $this->info('Operation cancelled.');

                    return 0;
                }
            }
        }

        $this->info("Dispatching optimization jobs for {$photos->count()} photos...");

        $bar = $this->output->createProgressBar($photos->count());
        $bar->start();

        $dispatchedCount = 0;

        foreach ($photos as $photo) {
            OptimizeImageJob::dispatch($photo);
            $dispatchedCount++;
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();

        $this->info("Successfully dispatched {$dispatchedCount} optimization jobs!");
        $this->info("Photos will be processed in the background. Check the queue status with 'php artisan queue:work'.");

        return 0;
    }
}
