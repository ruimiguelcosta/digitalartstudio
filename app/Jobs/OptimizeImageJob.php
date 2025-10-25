<?php

namespace App\Jobs;

use App\Models\Photo;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class OptimizeImageJob implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Photo $photo
    ) {}

    public function handle(): void
    {
        if (! $this->photo->path || ! Storage::exists($this->photo->path)) {
            return;
        }

        $originalPath = Storage::path($this->photo->path);
        $manager = new ImageManager(new Driver);

        $image = $manager->read($originalPath);

        $image->resize(800, 600, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });

        $this->addWatermark($image);

        $image->toJpeg(60);

        $processedPath = str_replace('.', '_processed.', $this->photo->path);
        $image->save(Storage::path($processedPath));

        $this->photo->update([
            'path' => $processedPath,
            'file_size' => Storage::size($processedPath),
        ]);
    }

    private function addWatermark($image): void
    {
        $width = $image->width();
        $height = $image->height();
        $text = 'Digital Art Studio';
        $fontSize = 24;
        $angle = -45;

        $image->text($text, $width / 2, $height / 2, function ($font) use ($fontSize, $angle) {
            $font->size($fontSize);
            $font->color('rgba(255, 255, 255, 0.3)');
            $font->align('center');
            $font->valign('middle');
            $font->angle($angle);
        });

        $this->addRepeatedWatermark($image, $text, $fontSize, $angle);
    }

    private function addRepeatedWatermark($image, string $text, int $fontSize, int $angle): void
    {
        $width = $image->width();
        $height = $image->height();
        $spacing = 150;

        for ($x = -$width; $x < $width * 2; $x += $spacing) {
            for ($y = -$height; $y < $height * 2; $y += $spacing) {
                $image->text($text, $x, $y, function ($font) use ($fontSize, $angle) {
                    $font->size($fontSize);
                    $font->color('rgba(255, 255, 255, 0.2)');
                    $font->align('center');
                    $font->valign('middle');
                    $font->angle($angle);
                });
            }
        }
    }
}
