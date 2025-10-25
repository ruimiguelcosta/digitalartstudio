<?php

namespace App\Actions\Http;

use Illuminate\View\View;

class IndexAction
{
    public function __invoke(): View
    {
        return view('index');
    }
}
