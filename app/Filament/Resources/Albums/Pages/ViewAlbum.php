<?php

namespace App\Filament\Resources\Albums\Pages;

use App\Filament\Resources\Albums\AlbumResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewAlbum extends ViewRecord
{
    protected static string $resource = AlbumResource::class;

    public function mount(int|string $record): void
    {
        parent::mount($record);

        $user = auth()->user();

        if ($user && $user->roles()->where('slug', 'manager')->exists()) {
            if ($this->record->manager_id !== $user->id) {
                $this->redirect(static::getResource()::getUrl('index'));
            }
        }
    }

    protected function getHeaderActions(): array
    {
        $user = auth()->user();
        $isManager = $user && $user->roles()->where('slug', 'manager')->exists();

        return [
            EditAction::make()
                ->visible(! $isManager),
        ];
    }
}
