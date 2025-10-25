<?php

namespace App\Actions\Http\Albums;

use App\Http\Requests\StoreAlbumRequest;
use App\Models\Album;
use Illuminate\Http\JsonResponse;

class StoreAlbumAction
{
    public function __invoke(StoreAlbumRequest $request): JsonResponse
    {
        $album = Album::query()->create([
            'title' => $request->validated('title'),
            'description' => $request->validated('description'),
            'event_start_date' => $request->validated('event_start_date'),
            'event_end_date' => $request->validated('event_end_date'),
            'is_public' => $request->validated('is_public', false),
            'user_id' => auth()->id(),
        ]);

        return response()->json([
            'message' => 'Álbum criado com sucesso!',
            'data' => $album->load('photos'),
        ], 201);
    }
}
