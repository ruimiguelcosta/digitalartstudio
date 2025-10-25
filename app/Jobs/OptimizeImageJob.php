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

        $image->scaleDown(600, null);

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
        $text = 'Digital Art Studio - PREVIEW ONLY';
        $fontSize = max(24, min($width, $height) / 20);
        $angle = -45;

        $this->addMainWatermark($image, $text, $fontSize, $angle);
        $this->addRepeatedWatermark($image, $text, $fontSize, $angle);
        $this->addCornerWatermarks($image, $text, $fontSize);
    }

    private function addMainWatermark(ImageInterface $image, string $text, int $fontSize, int $angle): void
    {
        $width = $image->width();
        $height = $image->height();

        $image->text($text, $width / 2, $height / 2, function ($font) use ($fontSize, $angle) {
            $font->size($fontSize);
            $font->color('rgba(255, 255, 255, 0.8)');
            $font->align('center');
            $font->valign('middle');
            $font->angle($angle);
        });
    }

    private function addRepeatedWatermark(ImageInterface $image, string $text, int $fontSize, int $angle): void
    {
        $width = $image->width();
        $height = $image->height();
        $spacing = max(80, $height / 14);

        for ($x = -$width; $x < $width * 2; $x += $spacing) {
            for ($y = -$height; $y < $height * 2; $y += $spacing) {
                $image->text($text, $x, $y, function ($font) use ($fontSize, $angle) {
                    $font->size($fontSize * 0.7);
                    $font->color('rgba(255, 255, 255, 0.4)');
                    $font->align('center');
                    $font->valign('middle');
                    $font->angle($angle);
                });
            }
        }
    }

    private function addCornerWatermarks(ImageInterface $image, string $text, int $fontSize): void
    {
        $width = $image->width();
        $height = $image->height();
        $cornerFontSize = $fontSize * 0.6;
        $margin = 20;

        $corners = [
            [$margin, $margin],
            [$width - $margin, $margin],
            [$margin, $height - $margin],
            [$width - $margin, $height - $margin],
        ];

        foreach ($corners as $corner) {
            $image->text('PREVIEW', $corner[0], $corner[1], function ($font) use ($cornerFontSize, $corner, $width) {
                $font->size($cornerFontSize);
                $font->color('rgba(255, 0, 0, 0.9)');
                $font->align($corner[0] < $width / 2 ? 'left' : 'right');
                $font->valign($corner[1] < $width / 2 ? 'top' : 'bottom');
            });
        }
    }
}
