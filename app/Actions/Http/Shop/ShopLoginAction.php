<?php

namespace App\Actions\Http\Shop;

use App\Http\Requests\Shop\ShopLoginRequest;
use App\Models\Album;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;

class ShopLoginAction
{
    public function __invoke(ShopLoginRequest $request): RedirectResponse
    {
        $email = $request->validated()['email'];
        $pin = $request->validated()['pin'];

        $album = Album::query()
            ->where('pin', $pin)
            ->first();

        if (! $album) {
            return back()->with('error', 'PIN incorreto.')->withInput();
        }

        \App\Models\AlbumGuestLogin::query()->firstOrCreate([
            'album_id' => $album->id,
            'email' => $email,
        ]);

        Session::put('shop_user_email', $email);
        Session::put('shop_album_id', $album->id);

        return redirect()->route('shop.dashboard');
    }
}
