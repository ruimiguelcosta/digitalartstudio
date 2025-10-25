<?php

namespace App\Filament\Resources\Photos\Schemas;

use Filament\Schemas\Schema;

class PhotoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Schemas\Components\Grid::make(2)
                    ->schema([
                        \Filament\Schemas\Components\TextInput::make('title')
                            ->label('Título')
                            ->required()
                            ->maxLength(255),
                        \Filament\Schemas\Components\Select::make('album_id')
                            ->label('Álbum')
                            ->relationship('album', 'title')
                            ->required()
                            ->searchable()
                            ->preload(),
                    ]),
                \Filament\Schemas\Components\FileUpload::make('photo')
                    ->label('Foto')
                    ->image()
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/jpg', 'image/gif'])
                    ->maxSize(config('photos.max_size_mb') * 1024) // Use our dynamic config
                    ->required()
                    ->disk('public')
                    ->directory('photos'),
                \Filament\Schemas\Components\Textarea::make('description')
                    ->label('Descrição')
                    ->maxLength(1000)
                    ->rows(3),
                \Filament\Schemas\Components\Grid::make(2)
                    ->schema([
                        \Filament\Schemas\Components\Toggle::make('is_featured')
                            ->label('Foto em destaque')
                            ->default(false),
                        \Filament\Schemas\Components\TextInput::make('order')
                            ->label('Ordem')
                            ->numeric()
                            ->default(0)
                            ->minValue(0),
                    ]),
            ]);
    }
}
