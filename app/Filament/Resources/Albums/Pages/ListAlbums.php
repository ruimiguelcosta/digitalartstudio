<?php

namespace App\Filament\Resources\Albums\Pages;

use App\Filament\Resources\Albums\AlbumResource;
use App\Filament\Resources\Albums\Tables\AlbumsTable;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Table;

class ListAlbums extends ListRecords
{
    protected static string $resource = AlbumResource::class;

    protected function getHeaderActions(): array
    {
        $user = auth()->user();
        $isManager = $user && $user->roles()->where('slug', 'manager')->exists();

        return [
            CreateAction::make()
                ->visible(! $isManager),
        ];
    }

    public function table(Table $table): Table
    {
        return AlbumsTable::configure($table)
            ->modifyQueryUsing(function ($query) {
                $user = auth()->user();

                if ($user && $user->roles()->where('slug', 'manager')->exists()) {
                    $query->where('manager_id', $user->id);
                }

                $query->with('photos');
            });
    }
}
