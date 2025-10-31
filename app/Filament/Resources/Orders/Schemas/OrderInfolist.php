<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class OrderInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(2)
                    ->schema([
                        Section::make('Dados do Cliente')
                            ->schema([
                                TextEntry::make('customer_name')
                                    ->label('Nome'),
                                TextEntry::make('customer_email')
                                    ->label('Email')
                                    ->icon('heroicon-o-envelope'),
                                TextEntry::make('customer_phone')
                                    ->label('Telemóvel')
                                    ->icon('heroicon-o-phone'),
                            ]),
                        Section::make('Informações da Encomenda')
                            ->schema([
                                TextEntry::make('id')
                                    ->label('Número da Encomenda')
                                    ->formatStateUsing(fn ($state) => '#'.$state),
                                TextEntry::make('created_at')
                                    ->label('Data')
                                    ->dateTime('d/m/Y H:i'),
                                TextEntry::make('album.name')
                                    ->label('Álbum')
                                    ->placeholder('N/A'),
                                TextEntry::make('total_price')
                                    ->label('Total')
                                    ->money('EUR', locale: 'pt_PT'),
                            ]),
                    ]),
                Section::make('Itens da Encomenda')
                    ->schema([
                        RepeatableEntry::make('items')
                            ->schema([
                                Grid::make(4)
                                    ->schema([
                                        TextEntry::make('photo_index')
                                            ->label('Foto')
                                            ->formatStateUsing(fn ($state) => $state !== null ? 'Foto '.($state + 1) : 'Foto')
                                            ->placeholder('N/A'),
                                        TextEntry::make('photo.original_filename')
                                            ->label('Ficheiro')
                                            ->placeholder('N/A'),
                                        TextEntry::make('service_name')
                                            ->label('Serviço'),
                                        TextEntry::make('service_price')
                                            ->label('Preço')
                                            ->money('EUR', locale: 'pt_PT'),
                                    ]),
                            ])
                            ->columns(1),
                    ]),
            ]);
    }
}
