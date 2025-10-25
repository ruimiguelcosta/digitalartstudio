<?php

namespace App\Actions\Http;

use App\Models\Album;
use Illuminate\View\View;

class AlbumDetailAction
{
    public function __invoke(string $id): View
    {
        $album = Album::query()->findOrFail($id);

        return view('album-detail', compact('album'));
    }
}
