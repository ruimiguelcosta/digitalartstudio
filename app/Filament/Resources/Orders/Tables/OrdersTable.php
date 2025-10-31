<?php

namespace App\Filament\Resources\Orders\Tables;

use Filament\Actions\ViewAction;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class OrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->searchable()
                    ->sortable()
                    ->weight(FontWeight::Bold),
                TextColumn::make('customer_name')
                    ->label('Cliente')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('customer_email')
                    ->label('Email')
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-o-envelope'),
                TextColumn::make('customer_phone')
                    ->label('Telemóvel')
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-o-phone'),
                TextColumn::make('album.name')
                    ->label('Álbum')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('items_count')
                    ->label('Itens')
                    ->counts('items')
                    ->sortable(),
                TextColumn::make('total_price')
                    ->label('Total')
                    ->money('EUR', locale: 'pt_PT')
                    ->sortable()
                    ->weight(FontWeight::Bold),
                TextColumn::make('created_at')
                    ->label('Data')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->icon('heroicon-o-calendar'),
            ])
            ->filters([
            ])
            ->recordActions([
                ViewAction::make(),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
