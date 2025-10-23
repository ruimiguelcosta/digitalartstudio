<?php

namespace App\Actions\Http\Albums;

use App\Models\Album;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class DeleteAlbumAction
{
    public function __invoke(Album $album): JsonResponse
    {
        foreach ($album->photos as $photo) {
            Storage::delete($photo->path);
        }

        $album->delete();

        return response()->json([
            'message' => 'Álbum excluído com sucesso!',
        ]);
    }
}
