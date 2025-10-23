<?php

namespace App\Actions\Http\Photos;

use App\Http\Requests\StorePhotoRequest;
use App\Models\Photo;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class StorePhotoAction
{
    public function __invoke(StorePhotoRequest $request): JsonResponse
    {
        $file = $request->file('photo');
        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('photos', $filename, 'public');

        $photo = Photo::query()->create([
            'title' => $request->validated('title'),
            'description' => $request->validated('description'),
            'filename' => $filename,
            'original_filename' => $file->getClientOriginalName(),
            'mime_type' => $file->getMimeType(),
            'file_size' => $file->getSize(),
            'path' => $path,
            'url' => $path,
            'is_featured' => $request->validated('is_featured', false),
            'album_id' => $request->validated('album_id'),
            'user_id' => auth()->id(),
        ]);

        return response()->json([
            'message' => 'Foto enviada com sucesso!',
            'data' => $photo->load('album'),
        ], 201);
    }
}
