<?php

namespace App\Actions\Http\Albums;

use App\Domain\Albums\Services\AlbumService;
use App\Models\Album;
use Illuminate\Http\Response;

class DestroyAlbumAction
{
    public function __construct(private AlbumService $service)
    {
    }

    public function __invoke(Album $album): Response
    {
        $this->service->delete($album);

        return response()->noContent();
    }
}
