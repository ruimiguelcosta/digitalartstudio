<?php

namespace App\Actions\Http;

use Illuminate\View\View;

class AlbumDetailAction
{
    public function __invoke(string $id): View
    {
        return view('album-detail', compact('id'));
    }
}

