<?php

namespace App\Actions\Http\Photos;

use App\Domain\Photos\Data\PhotoData;
use App\Domain\Photos\Services\PhotoService;
use App\Http\Requests\Photos\StorePhotoRequest;
use Illuminate\Http\JsonResponse;

class StorePhotoAction
{
    public function __construct(private PhotoService $service)
    {
    }

    public function __invoke(StorePhotoRequest $request): JsonResponse
    {
        $data = PhotoData::from($request->validated());
        $photo = $this->service->create($data);

        return response()->json($photo->load('album'), 201);
    }
}
