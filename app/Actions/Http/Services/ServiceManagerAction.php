<?php

namespace App\Actions\Http\Services;

use Illuminate\Http\Request;
use Illuminate\View\View;

class ServiceManagerAction
{
    public function __invoke(Request $request): View
    {
        return view('services.manager');
    }
}
