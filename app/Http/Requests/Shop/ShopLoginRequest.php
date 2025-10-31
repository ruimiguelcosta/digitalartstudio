<?php

namespace App\Http\Requests\Shop;

use Illuminate\Foundation\Http\FormRequest;

class ShopLoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'email'],
            'pin' => ['required', 'string', 'size:12', 'regex:/^[a-zA-Z0-9]{12}$/'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'O email é obrigatório.',
            'email.email' => 'O email deve ser válido.',
            'pin.required' => 'O PIN é obrigatório.',
            'pin.size' => 'O PIN deve ter 12 caracteres.',
            'pin.regex' => 'O PIN deve conter apenas letras e números.',
        ];
    }
}
