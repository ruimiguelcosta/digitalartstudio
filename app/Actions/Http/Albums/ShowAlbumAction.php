<?php

namespace App\Actions\Http\Albums;

use App\Domain\Albums\Services\AlbumService;
use App\Models\Album;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ShowAlbumAction
{
    public function __construct(private AlbumService $service)
    {
    }

    public function __invoke(Album $album): JsonResponse|Response
    {
        $album = $this->service->find($album->id);

        if (! $album) {
            return response()->noContent(404);
        }

        return response()->json($album->load('photos'));
    }
}
