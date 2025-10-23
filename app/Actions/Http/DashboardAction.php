<?php

namespace App\Actions\Http;

use Illuminate\View\View;

class DashboardAction
{
    public function __invoke(): View
    {
        return view('dashboard');
    }
}

