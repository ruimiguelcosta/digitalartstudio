<?php

namespace App\Actions\Http\Albums;

use App\Models\Album;
use Illuminate\Http\JsonResponse;

class ShowAlbumAction
{
    public function __invoke(Album $album): JsonResponse
    {
        $album->load(['photos', 'user']);

        return response()->json([
            'data' => $album,
        ]);
    }
}
