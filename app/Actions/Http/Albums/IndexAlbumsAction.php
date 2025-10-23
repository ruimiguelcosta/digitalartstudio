<?php

namespace App\Actions\Http\Albums;

use App\Models\Album;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class IndexAlbumsAction
{
    public function __invoke(Request $request): JsonResponse
    {
        $query = Album::query()->with(['photos', 'user']);

        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->get('search') . '%')
                  ->orWhere('description', 'like', '%' . $request->get('search') . '%');
        }

        if ($request->has('is_public')) {
            $query->where('is_public', $request->boolean('is_public'));
        }

        $albums = $query->latest()->paginate(15);

        return response()->json($albums);
    }
}
