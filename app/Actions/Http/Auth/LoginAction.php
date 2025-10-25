<?php

namespace App\Actions\Http\Auth;

use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class LoginAction
{
    public function __invoke(LoginRequest $request): JsonResponse
    {
        $credentials = $request->validated();

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return response()->json([
                'message' => 'Login realizado com sucesso!',
                'user' => Auth::user(),
            ]);
        }

        return response()->json([
            'message' => 'Credenciais inválidas.',
        ], 401);
    }
}
