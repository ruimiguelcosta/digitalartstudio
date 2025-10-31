<?php

namespace App\Filament\Resources\Albums\Schemas;

use App\AlbumStatus;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AlbumForm
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
                                    ->columnSpanFull(),

                                Textarea::make('description')
                                    ->maxLength(65535)
                                    ->columnSpanFull(),

                                DatePicker::make('start_date')
                                    ->required()
                                    ->native(false)
                                    ->displayFormat('d/m/Y'),

                                DatePicker::make('end_date')
                                    ->required()
                                    ->native(false)
                                    ->displayFormat('d/m/Y')
                                    ->after('start_date'),

                                Select::make('status')
                                    ->label('Estado')
                                    ->options([
                                        AlbumStatus::Draft->value => AlbumStatus::Draft->label(),
                                        AlbumStatus::Private->value => AlbumStatus::Private->label(),
                                        AlbumStatus::Published->value => AlbumStatus::Published->label(),
                                    ])
                                    ->default(AlbumStatus::Draft->value)
                                    ->required()
                                    ->live()
                                    ->afterStateUpdated(function ($state, $set) {
                                        if ($state !== AlbumStatus::Private->value) {
                                            $set('manager_email', null);
                                        }
                                    }),

                                TextInput::make('manager_email')
                                    ->label('Email do Manager')
                                    ->email()
                                    ->required(fn ($get) => $get('status') === AlbumStatus::Private->value)
                                    ->visible(fn ($get) => $get('status') === AlbumStatus::Private->value)
                                    ->columnSpanFull(),

                                TextInput::make('pin')
                                    ->label('PIN')
                                    ->disabled()
                                    ->dehydrated(false)
                                    ->helperText('O PIN é gerado automaticamente quando o álbum é criado.')
                                    ->columnSpanFull(),
                            ]),
                    ]),
            ]);
    }
}
