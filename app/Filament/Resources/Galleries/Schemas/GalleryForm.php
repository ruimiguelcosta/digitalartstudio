<?php

namespace App\Filament\Resources\Galleries\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class GalleryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->columnSpanFull()
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('name')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn (string $operation, $state, $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null)
                                    ->columnSpanFull(),

                                TextInput::make('slug')
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(ignoreRecord: true)
                                    ->columnSpanFull(),

                                Textarea::make('description')
                                    ->maxLength(65535)
                                    ->rows(3)
                                    ->columnSpanFull(),

                                FileUpload::make('cover_photo')
                                    ->label('Foto de Capa')
                                    ->image()
                                    ->directory('galleries')
                                    ->visibility('public')
                                    ->columnSpanFull(),

                                Toggle::make('active')
                                    ->label('Ativo')
                                    ->default(false)
                                    ->columnSpan(1),

                                TextInput::make('order')
                                    ->label('Ordem')
                                    ->numeric()
                                    ->default(0)
                                    ->required()
                                    ->columnSpan(1),
                            ]),
                    ]),
            ]);
    }
}
