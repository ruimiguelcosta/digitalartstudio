<?php

namespace App\Console\Commands;

use App\Models\Photo;
use App\Observers\PhotoObserver;
use Illuminate\Console\Command;

class ProcessPhotoImages extends Command
{
    protected $signature = 'photos:process {--id= : Process specific photo by ID} {--all : Process all photos}';

    protected $description = 'Process photos with watermark and optimization';

    public function handle(): int
    {
        $observer = new PhotoObserver;

        if ($this->option('id')) {
            $photo = Photo::query()->find($this->option('id'));

            if (! $photo) {
                $this->error("Photo with ID {$this->option('id')} not found.");

                return 1;
            }

            $this->info("Processing photo: {$photo->title}");
            $observer->created($photo);
            $this->info('Photo processed successfully!');

            return 0;
        }

        if ($this->option('all')) {
            $photos = Photo::query()->get();

            if ($photos->isEmpty()) {
                $this->info('No photos found to process.');

                return 0;
            }

            $this->info("Processing {$photos->count()} photos...");

            $bar = $this->output->createProgressBar($photos->count());
            $bar->start();

            foreach ($photos as $photo) {
                $observer->created($photo);
                $bar->advance();
            }

            $bar->finish();
            $this->newLine();
            $this->info('All photos processed successfully!');

            return 0;
        }

        $this->error('Please specify --id=ID or --all option.');

        return 1;
    }
}
