<?php

namespace App\Actions\Http\Shop;

use App\Http\Requests\Shop\CheckoutRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;

class ProcessCheckoutAction
{
    public function __invoke(CheckoutRequest $request): RedirectResponse
    {
        if (! session('shop_user_email')) {
            return redirect()->route('shop')->with('error', 'Por favor, faça login primeiro.');
        }

        $cart = session('shop_cart', []);
        if (empty($cart)) {
            return redirect()->route('shop.dashboard')->with('error', 'O seu carrinho está vazio.');
        }

        foreach ($cart as $item) {
            if (! isset($item['service_id']) || ! isset($item['service_price'])) {
                return redirect()->route('shop.checkout')
                    ->with('error', 'Por favor, selecione um formato para todas as fotos antes de finalizar.');
            }
        }

        $validated = $request->validated();
        $totalPrice = collect($cart)->sum(function ($item) {
            return $item['service_price'] ?? 0;
        });

        Session::forget('shop_cart');

        return redirect()->route('shop.dashboard')
            ->with('success', 'Encomenda enviada! Receberá um email com os detalhes de pagamento.');
    }
}

