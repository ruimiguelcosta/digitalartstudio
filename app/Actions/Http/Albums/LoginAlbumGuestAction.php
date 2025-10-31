<?php

namespace App\Actions\Http\Albums;

use App\Http\Requests\Albums\LoginAlbumGuestRequest;
use App\Models\Album;
use App\Models\AlbumGuestLogin;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;

class LoginAlbumGuestAction
{
    public function __invoke(LoginAlbumGuestRequest $request, string $album): RedirectResponse
    {
        $validated = $request->validated();
        $email = $validated['email'];
        $pin = $validated['pin'];

        $albumModel = Album::query()->findOrFail($album);

        if ($albumModel->pin !== $pin) {
            return back()
                ->with('error', 'PIN incorreto.')
                ->withInput();
        }

        Session::put("album_guest_access_{$album}", $album);

        AlbumGuestLogin::query()->firstOrCreate([
            'album_id' => $album,
            'email' => $email,
        ]);

        return redirect()->route('albums.guest.show', ['album' => $album]);
    }
}
