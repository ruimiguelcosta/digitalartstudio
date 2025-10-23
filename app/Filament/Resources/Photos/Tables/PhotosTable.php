<?php

namespace App\Filament\Resources\Photos\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;

class PhotosTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                \Filament\Tables\Columns\ImageColumn::make('url')
                    ->label('Foto')
                    ->size(60)
                    ->square(),
                \Filament\Tables\Columns\TextColumn::make('title')
                    ->label('Título')
                    ->searchable()
                    ->sortable(),
                \Filament\Tables\Columns\TextColumn::make('album.title')
                    ->label('Álbum')
                    ->searchable()
                    ->sortable(),
                \Filament\Tables\Columns\IconColumn::make('is_featured')
                    ->label('Destaque')
                    ->boolean(),
                \Filament\Tables\Columns\TextColumn::make('order')
                    ->label('Ordem')
                    ->sortable(),
                \Filament\Tables\Columns\TextColumn::make('formatted_file_size')
                    ->label('Tamanho')
                    ->sortable('file_size'),
                \Filament\Tables\Columns\TextColumn::make('created_at')
                    ->label('Criado em')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                \Filament\Tables\Filters\SelectFilter::make('album_id')
                    ->label('Álbum')
                    ->relationship('album', 'title')
                    ->searchable()
                    ->preload(),
                \Filament\Tables\Filters\TernaryFilter::make('is_featured')
                    ->label('Em destaque')
                    ->boolean()
                    ->trueLabel('Apenas em destaque')
                    ->falseLabel('Apenas normais')
                    ->native(false),
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
