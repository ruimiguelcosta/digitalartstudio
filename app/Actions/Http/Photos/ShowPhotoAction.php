<?php

namespace App\Actions\Http\Photos;

use App\Domain\Photos\Services\PhotoService;
use App\Models\Photo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ShowPhotoAction
{
    public function __construct(private PhotoService $service)
    {
    }

    public function __invoke(Photo $photo): JsonResponse|Response
    {
        $photo = $this->service->find($photo->id);

        if (! $photo) {
            return response()->noContent(404);
        }

        return response()->json($photo->load('album'));
    }
}
