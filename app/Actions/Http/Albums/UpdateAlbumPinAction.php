<?php

namespace App\Actions\Http\Albums;

use App\Domain\Albums\Services\AlbumService;
use App\Http\Requests\Albums\UpdateAlbumPinRequest;
use App\Models\Album;
use Illuminate\Http\JsonResponse;

class UpdateAlbumPinAction
{
    public function __construct(private AlbumService $service) {}

    public function __invoke(UpdateAlbumPinRequest $request, Album $album): JsonResponse
    {
        $pin = $request->validated()['pin'] ?? null;
        $album = $this->service->updatePin($album, $pin);

        return response()->json($album->toArray());
    }
}
