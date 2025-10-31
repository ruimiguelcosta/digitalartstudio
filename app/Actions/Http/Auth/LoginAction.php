<?php

namespace App\Actions\Http\Auth;

use App\Http\Requests\Auth\LoginRequest;
use App\Models\Album;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;

class LoginAction
{
    public function __invoke(LoginRequest $request): RedirectResponse
    {
        $email = $request->validated()['email'];
        $pin = $request->validated()['pin'];

        $album = Album::query()
            ->where('manager_email', $email)
            ->where('pin', $pin)
            ->first();

        if (! $album) {
            return back()->with('error', 'Email ou PIN incorretos.')->withInput();
        }

        Session::put('album_access', $album->id);

        return redirect()->route('dashboard');
    }
}
