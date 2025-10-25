<?php

namespace App\Actions\Http;

use Illuminate\View\View;

class ClientAlbumAction
{
    public function __invoke(string $id): View
    {
        return view('client-album', compact('id'));
    }
}
