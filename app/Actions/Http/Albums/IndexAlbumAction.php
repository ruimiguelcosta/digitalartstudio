<?php

namespace App\Actions\Http\Albums;

use App\Domain\Albums\Services\AlbumService;
use Illuminate\Http\JsonResponse;

class IndexAlbumAction
{
    public function __construct(private AlbumService $service)
    {
    }

    public function __invoke(): JsonResponse
    {
        $albums = $this->service->getAll();

        return response()->json($albums);
    }
}
