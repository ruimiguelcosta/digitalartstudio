<?php

namespace App\Filament\Resources\Services\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;

class ServicesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                \Filament\Tables\Columns\TextColumn::make('name')
                    ->label('Nome do Serviço')
                    ->searchable()
                    ->sortable(),

                \Filament\Tables\Columns\TextColumn::make('price')
                    ->label('Preço')
                    ->money('EUR')
                    ->sortable(),

                \Filament\Tables\Columns\TextColumn::make('description')
                    ->label('Descrição')
                    ->limit(50)
                    ->tooltip(function (\Filament\Tables\Columns\TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= 50) {
                            return null;
                        }

                        return $state;
                    }),

                \Filament\Tables\Columns\IconColumn::make('is_active')
                    ->label('Ativo')
                    ->boolean(),

                \Filament\Tables\Columns\TextColumn::make('created_at')
                    ->label('Criado em')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                \Filament\Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status')
                    ->placeholder('Todos os serviços')
                    ->trueLabel('Apenas ativos')
                    ->falseLabel('Apenas inativos'),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
