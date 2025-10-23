<?php

namespace App\Actions\Http\Photos;

use App\Models\Photo;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class DeletePhotoAction
{
    public function __invoke(Photo $photo): JsonResponse
    {
        Storage::delete($photo->path);
        $photo->delete();

        return response()->json([
            'message' => 'Foto excluída com sucesso!',
        ]);
    }
}
