<?php

namespace App\Actions\Http\Albums;

use App\Http\Requests\UpdateAlbumRequest;
use App\Models\Album;
use Illuminate\Http\JsonResponse;

class UpdateAlbumAction
{
    public function __invoke(UpdateAlbumRequest $request, Album $album): JsonResponse
    {
        $album->update($request->validated());

        return response()->json([
            'message' => 'Álbum atualizado com sucesso!',
            'data' => $album->load('photos'),
        ]);
    }
}
