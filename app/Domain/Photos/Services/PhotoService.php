<?php

namespace App\Domain\Photos\Services;

use App\Domain\Photos\Data\PhotoData;
use App\Models\Album;
use App\Models\Photo;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class PhotoService
{
    public function create(PhotoData $data): Photo
    {
        return DB::transaction(function () use ($data) {
            $album = Album::query()->findOrFail($data->album_id);
            
            $photoCount = Photo::query()->where('album_id', $album->id)->count();
            $maxCount = config('photos.max_count');
            
            if ($photoCount >= $maxCount) {
                throw new \Exception("Limite máximo de {$maxCount} fotos por álbum atingido.");
            }
            
            $nextNumber = $photoCount + 1;
            $initials = $album->getInitials();
            $reference = $initials.str_pad((string) $nextNumber, 5, '0', STR_PAD_LEFT);
            
            $extension = pathinfo($data->path, PATHINFO_EXTENSION);
            $originalSize = \Illuminate\Support\Facades\Storage::disk('local')->size($data->path);
            
            $newFilename = $album->slug.str_pad((string) $nextNumber, 5, '0', STR_PAD_LEFT).'.'.$extension;
            $newPath = "photos/{$album->slug}/{$newFilename}";
            
            \Illuminate\Support\Facades\Storage::disk('local')->move($data->path, $newPath);

            return Photo::query()->create([
                'album_id' => $album->id,
                'reference' => $reference,
                'path' => $newPath,
                'original_filename' => $newFilename,
                'size' => $originalSize,
            ]);
        });
    }

    public function update(Photo $photo, PhotoData $data): Photo
    {
        return DB::transaction(function () use ($photo, $data) {
            $updateData = array_filter($data->toArray(), fn ($value) => $value !== null);
            
            if (!empty($updateData)) {
                $photo->fill($updateData);
                $photo->save();
            }

            return $photo->fresh();
        });
    }

    public function delete(Photo $photo): bool
    {
        return DB::transaction(function () use ($photo) {
            return $photo->delete();
        });
    }

    public function getAll(): LengthAwarePaginator
    {
        return Photo::query()->with('album')->latest()->paginate(15);
    }

    public function find(string $id): ?Photo
    {
        return Photo::query()->with('album')->find($id);
    }
}
