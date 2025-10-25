<?php

namespace App\Jobs;

use App\Models\Photo;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Intervention\Image\Interfaces\ImageInterface;

class OptimizeImageJob implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Photo $photo
    ) {}

    public function handle(): void
    {
        if (! $this->photo->path || ! Storage::disk('public')->exists($this->photo->path)) {
            return;
        }

        $originalPath = Storage::disk('public')->path($this->photo->path);
        $manager = new ImageManager(new Driver);

        $image = $manager->read($originalPath);

        $image->scaleDown(1920, 1080);

        $this->addWatermark($image);

        $processedPath = $this->photo->path;
        $fullProcessedPath = Storage::disk('public')->path($processedPath);

        $directory = dirname($fullProcessedPath);
        if (! is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        $image->toJpeg(85)->save($fullProcessedPath);

        if (file_exists($fullProcessedPath)) {
            $this->photo->update([
                'path' => $processedPath,
                'file_size' => Storage::disk('public')->size($processedPath),
                'url' => Storage::disk('public')->url($processedPath),
            ]);
        } else {
            throw new \Exception('Failed to save processed image');
        }
    }

    private function addWatermark(ImageInterface $image): void
    {
        $width = $image->width();
        $height = $image->height();
        $text = 'Digital Art Studio';
        $fontSize = 40;
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

    private function addRepeatedWatermark(ImageInterface $image, string $text, int $fontSize, int $angle): void
    {
        $width = $image->width();
        $height = $image->height();
        $spacing = 200;

        for ($x = -$width; $x < $width * 2; $x += $spacing) {
            for ($y = -$height; $y < $height * 2; $y += $spacing) {
                $image->text($text, $x, $y, function ($font) use ($fontSize, $angle) {
                    $font->size($fontSize);
                    $font->color('rgba(255, 255, 255, 0.15)');
                    $font->align('center');
                    $font->valign('middle');
                    $font->angle($angle);
                });
            }
        }
    }
}
