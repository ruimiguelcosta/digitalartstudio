<?php

namespace App\Filament\Resources\Albums\RelationManagers;

use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PhotosRelationManager extends RelationManager
{
    protected static string $relationship = 'photos';

    protected static ?string $title = 'Fotos';

    protected static ?string $label = 'Foto';

    protected static ?string $pluralLabel = 'Fotos';

    public function form(Schema $schema): Schema
    {
        $maxSizeMB = config('photos.max_size_mb');

        return $schema
            ->components([
                FileUpload::make('path')
                    ->label('Fotografias')
                    ->image()
                    ->directory('photos')
                    ->visibility('public')
                    ->downloadable()
                    ->previewable()
                    ->maxSize($maxSizeMB * 1024)
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                    ->helperText("Aceita imagens em formato JPEG, PNG ou WebP (máx. {$maxSizeMB}MB)")
                    ->rules([
                        'required',
                        'file',
                        'max:'.($maxSizeMB * 1024 * 1024),
                    ])
                    ->validationAttribute('Fotografia')
                    ->required()
                    ->multiple()
                    ->columnSpanFull(),
                TextInput::make('original_filename')
                    ->label('Nome do Ficheiro Original')
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        $maxSizeMB = config('photos.max_size_mb');

        return $table
            ->recordTitleAttribute('original_filename')
            ->columns([
                ImageColumn::make('path')
                    ->label('Imagem')
                    ->square()
                    ->size(80),
                TextColumn::make('reference')
                    ->label('Referência')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('original_filename')
                    ->label('Nome do Ficheiro')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('size')
                    ->label('Tamanho')
                    ->formatStateUsing(fn ($state) => $state ? number_format($state / 1024, 2).' KB' : '-')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Criado em')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
            ])
            ->headerActions([
                CreateAction::make()
                    ->form([
                        FileUpload::make('path')
                            ->label('Fotografias')
                            ->image()
                            ->downloadable()
                            ->previewable()
                            ->maxSize($maxSizeMB * 1024)
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->helperText("Aceita imagens em formato JPEG, PNG ou WebP (máx. {$maxSizeMB}MB)")
                            ->validationAttribute('Fotografias')
                            ->required()
                            ->multiple()
                            ->columnSpanFull(),
                        TextInput::make('original_filename')
                            ->label('Nome do Ficheiro Original')
                            ->maxLength(255)
                            ->dehydrated(false)
                            ->hidden(),
                    ])
                    ->using(function (array $data, $livewire) {
                        $album = $livewire->ownerRecord;

                        $photoCount = \App\Models\Photo::query()->where('album_id', $album->id)->count();
                        $maxCount = config('photos.max_count');

                        $paths = is_array($data['path']) ? $data['path'] : [$data['path']];
                        $photosToAdd = count($paths);

                        if ($photoCount + $photosToAdd > $maxCount) {
                            throw new \Exception("Limite máximo de {$maxCount} fotos por álbum atingido. Tentou adicionar {$photosToAdd} fotos, mas só pode adicionar mais ".($maxCount - $photoCount).' fotos.');
                        }

                        $initials = $album->getInitials();
                        $nextNumber = $photoCount + 1;

                        foreach ($paths as $path) {
                            $extension = pathinfo($path, PATHINFO_EXTENSION);
                            $originalSize = \Illuminate\Support\Facades\Storage::disk('local')->size($path);

                            $reference = $initials.str_pad((string) $nextNumber, 5, '0', STR_PAD_LEFT);
                            $newFilename = $album->slug.str_pad((string) $nextNumber, 5, '0', STR_PAD_LEFT).'.'.$extension;
                            $newPath = "photos/{$album->slug}/{$newFilename}";

                            \Illuminate\Support\Facades\Storage::disk('local')->move($path, $newPath);

                            \App\Models\Photo::query()->create([
                                'album_id' => $album->id,
                                'reference' => $reference,
                                'path' => $newPath,
                                'original_filename' => $newFilename,
                                'size' => $originalSize,
                            ]);

                            $nextNumber++;
                        }
                    }),
            ])
            ->actions([
                EditAction::make()
                    ->form([
                        FileUpload::make('path')
                            ->label('Fotografia')
                            ->image()
                            ->downloadable()
                            ->previewable()
                            ->maxSize($maxSizeMB * 1024)
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->helperText("Aceita imagens em formato JPEG, PNG ou WebP (máx. {$maxSizeMB}MB)")
                            ->rules([
                                'file',
                                'max:'.($maxSizeMB * 1024 * 1024),
                            ])
                            ->validationAttribute('Fotografia')
                            ->columnSpanFull(),
                        TextInput::make('original_filename')
                            ->label('Nome do Ficheiro Original')
                            ->maxLength(255)
                            ->dehydrated(false)
                            ->hidden(),
                    ])
                    ->using(function (array $data, $livewire, $record) {
                        if (isset($data['path'])) {
                            $album = $livewire->ownerRecord;
                            $extension = pathinfo($data['path'], PATHINFO_EXTENSION);
                            $originalSize = \Illuminate\Support\Facades\Storage::disk('local')->size($data['path']);

                            $photoCount = \App\Models\Photo::query()->where('album_id', $album->id)->where('id', '!=', $record->id)->count() + 1;
                            $newFilename = $album->slug.str_pad((string) $photoCount, 5, '0', STR_PAD_LEFT).'.'.$extension;
                            $newPath = "photos/{$album->slug}/{$newFilename}";

                            \Illuminate\Support\Facades\Storage::disk('local')->delete($record->path);
                            \Illuminate\Support\Facades\Storage::disk('local')->move($data['path'], $newPath);

                            $record->update([
                                'path' => $newPath,
                                'original_filename' => $newFilename,
                                'size' => $originalSize,
                            ]);
                        } else {
                            $record->update($data);
                        }
                    }),
                DeleteAction::make(),
            ])
            ->bulkActions([
            ]);
    }
}
