<?php

namespace App\Actions\Http\Shop;

use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;

class UpdateCartServiceAction
{
    public function __invoke(): RedirectResponse
    {
        if (! session('shop_user_email')) {
            return redirect()->route('shop')->with('error', 'Por favor, faça login primeiro.');
        }

        $photoId = request()->input('photo_id');
        $serviceId = request()->input('service_id');

        $service = Service::query()->findOrFail($serviceId);

        $cart = session('shop_cart', []);

        $cart = collect($cart)->map(function ($item) use ($photoId, $serviceId, $service) {
            if (($item['photo_id'] ?? null) === $photoId) {
                $item['service_id'] = $serviceId;
                $item['service_name'] = $service->name;
                $item['service_price'] = $service->price;
            }

            return $item;
        })->toArray();

        Session::put('shop_cart', $cart);

        return back();
    }
}



