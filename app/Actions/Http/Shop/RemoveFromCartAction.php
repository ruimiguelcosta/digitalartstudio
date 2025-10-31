<?php

namespace App\Actions\Http\Shop;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;

class RemoveFromCartAction
{
    public function __invoke(): RedirectResponse
    {
        if (! session('shop_user_email')) {
            return redirect()->route('shop')->with('error', 'Por favor, faça login primeiro.');
        }

        $photoId = request()->input('photo_id');
        $cart = session('shop_cart', []);

        $cart = collect($cart)->reject(function ($item) use ($photoId) {
            return ($item['photo_id'] ?? null) === $photoId;
        })->values()->toArray();

        Session::put('shop_cart', $cart);

        return back()->with('success', 'Foto removida do carrinho.');
    }
}

