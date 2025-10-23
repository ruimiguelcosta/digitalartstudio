<?php

namespace App\Actions\Http;

use Illuminate\View\View;

class AuthAction
{
    public function __invoke(): View
    {
        return view('auth');
    }
}

