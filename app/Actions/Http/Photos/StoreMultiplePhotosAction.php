<?php

namespace App\Actions\Http\Photos;

use App\Http\Requests\Photos\StoreMultiplePhotosRequest;
use App\Models\Photo;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class StoreMultiplePhotosAction
{
    public function __invoke(StoreMultiplePhotosRequest $request): JsonResponse
    {
        $albumId = $request->validated()['album_id'];
        $photos = $request->file('photos');

        $uploadedPhotos = [];

        DB::transaction(function () use ($photos, $albumId, &$uploadedPhotos) {
            foreach ($photos as $index => $photo) {
                $filename = Str::uuid().'.'.$photo->getClientOriginalExtension();
                $path = $photo->storeAs('photos', $filename, 'public');

                $uploadedPhoto = Photo::query()->create([
                    'title' => pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME),
                    'description' => null,
                    'filename' => $filename,
                    'original_filename' => $photo->getClientOriginalName(),
                    'mime_type' => $photo->getMimeType(),
                    'path' => $path,
                    'url' => $path,
                    'album_id' => $albumId,
                    'user_id' => auth()->id(),
                    'is_featured' => false,
                    'order' => Photo::query()->where('album_id', $albumId)->max('order') + 1,
                    'file_size' => $photo->getSize(),
                ]);

                $uploadedPhotos[] = $uploadedPhoto;
            }
        });

        return response()->json([
            'message' => 'Fotos enviadas com sucesso!',
            'count' => count($uploadedPhotos),
            'photos' => $uploadedPhotos,
        ], 201);
    }
}
