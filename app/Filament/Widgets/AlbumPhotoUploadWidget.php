<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class AlbumPhotoUploadWidget extends Widget
{
    protected int|string|array $columnSpan = 'full';

    protected function getView(): string
    {
        return 'filament.widgets.album-photo-upload';
    }
}
