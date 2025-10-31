<?php

namespace App\Actions\Http\Albums;

use App\Http\Requests\Albums\ShowAlbumGuestRequest;
use App\Models\Album;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;

class ShowAlbumGuestAction
{
    public function __invoke(ShowAlbumGuestRequest $request, string $album): View|RedirectResponse
    {
        $albumModel = Album::query()->findOrFail($album);

        $sessionAlbumId = Session::get("album_guest_access_{$album}");

        if ($albumModel->pin && $sessionAlbumId !== $album) {
            return view('albums.guest-login', ['album' => $albumModel]);
        }

        return view('albums.guest-show', ['album' => $albumModel]);
    }
}
