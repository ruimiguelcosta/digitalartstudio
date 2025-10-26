<?php

namespace App\Actions\Http\Photos;

use App\Domain\Photos\Services\PhotoService;
use Illuminate\Http\JsonResponse;

class IndexPhotoAction
{
    public function __construct(private PhotoService $service)
    {
    }

    public function __invoke(): JsonResponse
    {
        $photos = $this->service->getAll();

        return response()->json($photos);
    }
}
