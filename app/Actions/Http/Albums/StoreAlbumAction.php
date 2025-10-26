<?php

namespace App\Actions\Http\Albums;

use App\Domain\Albums\Data\AlbumData;
use App\Domain\Albums\Services\AlbumService;
use App\Http\Requests\Albums\StoreAlbumRequest;
use Illuminate\Http\JsonResponse;

class StoreAlbumAction
{
    public function __construct(private AlbumService $service)
    {
    }

    public function __invoke(StoreAlbumRequest $request): JsonResponse
    {
        $data = AlbumData::from($request->validated());
        $album = $this->service->create($data);

        return response()->json($album->load('photos'), 201);
    }
}
