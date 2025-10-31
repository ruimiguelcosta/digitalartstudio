<?php

namespace App\Actions\Http\Shop;

use App\Http\Requests\Shop\CheckoutRequest;
use App\Jobs\SendOrderEmailsJob;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
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

        $albumId = session('shop_album_id');
        $userEmail = session('shop_user_email');

        $order = DB::transaction(function () use ($validated, $userEmail, $albumId, $totalPrice, $cart) {
            $order = Order::query()->create([
                'customer_name' => $validated['name'],
                'customer_email' => $userEmail,
                'customer_phone' => $validated['phone'],
                'album_id' => $albumId,
                'total_price' => $totalPrice,
            ]);

            foreach ($cart as $item) {
                $order->items()->create([
                    'photo_id' => $item['photo_id'],
                    'service_id' => $item['service_id'],
                    'service_name' => $item['service_name'] ?? 'Serviço',
                    'service_price' => $item['service_price'],
                    'photo_index' => $item['photo_index'] ?? null,
                ]);
            }

            return $order;
        });

        SendOrderEmailsJob::dispatch($order);

        Session::forget('shop_cart');

        return redirect()->route('shop.dashboard')
            ->with('success', 'Obrigado pela sua encomenda. Será contactado em breve para ajustar detalhes.');
    }
}

