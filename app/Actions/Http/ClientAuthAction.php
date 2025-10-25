<?php

namespace App\Actions\Http;

use Illuminate\View\View;

class ClientAuthAction
{
    public function __invoke(): View
    {
        return view('client-auth');
    }
}
