<?php

namespace App\Services;

use App\Models\Photo;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class PhotoOptimizationService
{
    public function optimize(Photo $photo): void
    {
        if (! Storage::disk('local')->exists($photo->path)) {
            return;
        }

        $fullPath = Storage::disk('local')->path($photo->path);

        $manager = new ImageManager(new Driver);

        $image = $manager->read($fullPath);
        $image->scale(width: 600);

        $width = $image->width();
        $height = $image->height();
        $watermarkText = 'www.digitalartstudio.pt';

        $spacingX = 150;
        $spacingY = 70;

        for ($x = 20; $x < $width; $x += $spacingX) {
            for ($y = 30; $y < $height; $y += $spacingY) {
                $image->text($watermarkText, $x, $y, function ($font) {
                    $font->size(31);
                    $font->color('FFFFFF');
                    $font->align('left');
                });
            }
        }

        $optimized = $image->toJpeg(quality: 65);

        Storage::disk('local')->put($photo->path, (string) $optimized);

        $optimizedSize = Storage::disk('local')->size($photo->path);

        $photo->update(['size' => $optimizedSize]);
    }
}
