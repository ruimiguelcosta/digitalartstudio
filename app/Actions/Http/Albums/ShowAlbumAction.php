<?php

namespace App\Actions\Http\Albums;

use App\Models\Album;
use Illuminate\Http\JsonResponse;

class ShowAlbumAction
{
    public function __invoke(string $album): JsonResponse
    {
        $album = Album::query()->findOrFail($album);
        $album->load(['photos', 'user']);

        return response()->json($album);
    }
}
