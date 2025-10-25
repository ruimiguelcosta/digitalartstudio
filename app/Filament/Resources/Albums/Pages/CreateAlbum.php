<?php

namespace App\Filament\Resources\Albums\Pages;

use App\Filament\Resources\Albums\AlbumResource;
use Filament\Resources\Pages\CreateRecord;

class CreateAlbum extends CreateRecord
{
    protected static string $resource = AlbumResource::class;

    protected function getCreateFormAction(): \Filament\Actions\Action
    {
        return parent::getCreateFormAction()
            ->label('Criar Álbum')
            ->color('primary')
            ->icon('heroicon-m-plus')
            ->button();
    }

    protected function getCancelFormAction(): \Filament\Actions\Action
    {
        return parent::getCancelFormAction()
            ->label('Cancelar')
            ->color('gray')
            ->button();
    }
}
