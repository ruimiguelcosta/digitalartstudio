<?php

namespace App\Actions\Http\Shop;

use App\Models\Photo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;

class AddToCartAction
{
    public function __invoke(): RedirectResponse
    {
        if (! session('shop_user_email')) {
            return redirect()->route('shop')->with('error', 'Por favor, faça login primeiro.');
        }

        $photoId = request()->input('photo_id');
        $albumId = session('shop_album_id');

        $photo = Photo::query()
            ->where('id', $photoId)
            ->where('album_id', $albumId)
            ->firstOrFail();

        $cart = session('shop_cart', []);
        
        $exists = collect($cart)->contains('photo_id', $photoId);
        if ($exists) {
            return back()->with('error', 'Esta foto já está no carrinho.');
        }

        $cart[] = [
            'photo_id' => $photo->id,
            'album_id' => $albumId,
            'photo_index' => request()->input('photo_index'),
        ];

        Session::put('shop_cart', $cart);

        return back()->with('success', 'Foto adicionada ao carrinho.');
    }
}

