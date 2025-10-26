<?php

namespace App\Actions\Http\Albums;

use App\Domain\Albums\Data\AlbumData;
use App\Domain\Albums\Services\AlbumService;
use App\Http\Requests\Albums\UpdateAlbumRequest;
use App\Models\Album;
use Illuminate\Http\JsonResponse;

class UpdateAlbumAction
{
    public function __construct(private AlbumService $service)
    {
    }

    public function __invoke(UpdateAlbumRequest $request, Album $album): JsonResponse
    {
        $data = AlbumData::from($request->validated());
        $album = $this->service->update($album, $data);

        return response()->json($album->load('photos'));
    }
}
