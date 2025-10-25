<?php

namespace App\Filament\Resources\Albums\Schemas;

use Filament\Schemas\Schema;

class AlbumForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Schemas\Components\TextInput::make('title')
                    ->label('Título')
                    ->required()
                    ->maxLength(255),
                \Filament\Schemas\Components\Textarea::make('description')
                    ->label('Descrição')
                    ->maxLength(1000)
                    ->rows(3),
            ]);
    }
}
