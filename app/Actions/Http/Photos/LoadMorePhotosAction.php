<?php

namespace App\Actions\Http\Photos;

use App\Http\Requests\Photos\LoadMorePhotosRequest;
use App\Models\Photo;
use Illuminate\Http\JsonResponse;

class LoadMorePhotosAction
{
    public function __invoke(LoadMorePhotosRequest $request): JsonResponse
    {
        $albumId = $request->validated()['album_id'];
        $offset = $request->validated()['offset'];
        $limit = 25;

        $totalPhotos = Photo::query()
            ->where('album_id', $albumId)
            ->count();

        $photos = Photo::query()
            ->where('album_id', $albumId)
            ->orderBy('created_at')
            ->offset($offset)
            ->limit($limit)
            ->get()
            ->map(function ($photo) {
                $encodedPath = base64_encode($photo->path);
                $url = route('filament.admin.storage.photo', ['path' => $encodedPath]);

                return [
                    'id' => $photo->id,
                    'path' => $photo->path,
                    'url' => $url,
                    'original_filename' => $photo->original_filename,
                    'reference' => $photo->reference,
                ];
            })
            ->toArray();

        return response()->json([
            'photos' => $photos,
            'has_more' => ($offset + count($photos)) < $totalPhotos,
        ]);
    }
}

