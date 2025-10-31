<?php

namespace App\Filament\Resources\Albums\Pages;

use App\Filament\Resources\Albums\AlbumResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Str;

class EditAlbum extends EditRecord
{
    protected static string $resource = AlbumResource::class;

    public function mount(int|string $record): void
    {
        parent::mount($record);

        $user = auth()->user();

        if ($user && $user->roles()->where('slug', 'manager')->exists()) {
            $this->redirect(static::getResource()::getUrl('view', ['record' => $record]));
        }

        $album = $this->record;
        if ($album && empty($album->pin)) {
            $album->pin = Str::random(12);
            $album->saveQuietly();
            $this->record->refresh();
        }
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
