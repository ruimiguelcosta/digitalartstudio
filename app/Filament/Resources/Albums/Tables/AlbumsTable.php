<?php

namespace App\Filament\Resources\Albums\Tables;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\Layout\Grid;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AlbumsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                Grid::make()
                    ->schema([
                        ImageColumn::make('photo_preview')
                            ->label('Foto')
                            ->disk('local')
                            ->circular()
                            ->size(150)
                            ->state(function ($record) {
                                $firstPhoto = $record->photos->first();

                                return $firstPhoto ? $firstPhoto->path : null;
                            }),
                        Split::make([
                            Grid::make()
                                ->columns(1)
                                ->grow(false)
                                ->schema([
                                    TextColumn::make('status')
                                        ->badge()
                                        ->formatStateUsing(fn ($state) => $state->label())
                                        ->color(fn ($state) => $state === \App\AlbumStatus::Published ? 'success' : 'gray')
                                        ->size('sm')
                                        ->grow(false),
                                ]),
                            Stack::make([
                                TextColumn::make('name')
                                    ->label('Nome')
                                    ->searchable()
                                    ->sortable()
                                    ->weight(FontWeight::Bold)
                                    ->size('lg'),
                                Stack::make([
                                    TextColumn::make('start_date')
                                        ->label('Data Início')
                                        ->date('d/m/Y')
                                        ->size('sm')
                                        ->icon('heroicon-o-calendar'),
                                    TextColumn::make('end_date')
                                        ->label('Data Fim')
                                        ->date('d/m/Y')
                                        ->size('sm')
                                        ->icon('heroicon-o-calendar'),
                                ])
                                    ->space(1),
                                TextColumn::make('photos_count')
                                    ->label('Fotos')
                                    ->counts('photos')
                                    ->size('sm')
                                    ->icon('heroicon-o-photo'),
                            ])
                                ->space(2),
                        ]),
                    ])
                    ->columnSpan(2),
            ])
            ->filters([
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->contentGrid([
                'md' => 2,
                'xl' => 3,
            ])
            ->defaultSort('created_at', 'desc')
            ->defaultPaginationPageOption(50)
            ->paginationPageOptions([25, 50, 100]);
    }
}
