<?php

namespace App\Filament\Resources\Services\Schemas;

use Filament\Schemas\Schema;

class ServiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Forms\Components\TextInput::make('name')
                    ->label('Nome do Serviço')
                    ->required()
                    ->maxLength(255),

                \Filament\Forms\Components\TextInput::make('price')
                    ->label('Preço (€)')
                    ->required()
                    ->numeric()
                    ->prefix('€')
                    ->step(0.01)
                    ->minValue(0),

                \Filament\Forms\Components\Textarea::make('description')
                    ->label('Descrição')
                    ->rows(3)
                    ->columnSpanFull(),

                \Filament\Forms\Components\Toggle::make('is_active')
                    ->label('Ativo')
                    ->default(true),
            ]);
    }
}
