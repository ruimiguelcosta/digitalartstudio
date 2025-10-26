<?php

namespace App\Actions\Http\Photos;

use App\Domain\Photos\Data\PhotoData;
use App\Domain\Photos\Services\PhotoService;
use App\Http\Requests\Photos\UpdatePhotoRequest;
use App\Models\Photo;
use Illuminate\Http\JsonResponse;

class UpdatePhotoAction
{
    public function __construct(private PhotoService $service)
    {
    }

    public function __invoke(UpdatePhotoRequest $request, Photo $photo): JsonResponse
    {
        $data = PhotoData::from($request->validated());
        $photo = $this->service->update($photo, $data);

        return response()->json($photo->load('album'));
    }
}
