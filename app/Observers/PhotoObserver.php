<?php

namespace App\Observers;

use App\Models\Photo;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class PhotoObserver
{
    public function created(Photo $photo): void
    {
        $this->processImage($photo);
    }

    private function processImage(Photo $photo): void
    {
        if (! $photo->path || ! Storage::exists($photo->path)) {
            return;
        }

        $originalPath = Storage::path($photo->path);
        $manager = new ImageManager(new Driver);

        $image = $manager->read($originalPath);

        $image->resize(600, 400, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });

        $this->addWatermark($image);

        $image->toJpeg(60);

        $processedPath = str_replace('.', '_processed.', $photo->path);
        $image->save(Storage::path($processedPath));

        $photo->update([
            'path' => $processedPath,
            'file_size' => Storage::size($processedPath),
        ]);
    }

    private function addWatermark($image): void
    {
        $width = $image->width();
        $height = $image->height();
        $text = 'DIGITAL ART STUDIO';
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
