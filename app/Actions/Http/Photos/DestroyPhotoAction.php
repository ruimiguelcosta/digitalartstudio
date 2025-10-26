<?php

namespace App\Actions\Http\Photos;

use App\Domain\Photos\Services\PhotoService;
use App\Models\Photo;
use Illuminate\Http\Response;

class DestroyPhotoAction
{
    public function __construct(private PhotoService $service)
    {
    }

    public function __invoke(Photo $photo): Response
    {
        $this->service->delete($photo);

        return response()->noContent();
    }
}
