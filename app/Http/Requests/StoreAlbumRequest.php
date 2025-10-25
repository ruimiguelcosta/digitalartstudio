<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAlbumRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'event_start_date' => ['nullable', 'date'],
            'event_end_date' => ['nullable', 'date', 'after_or_equal:event_start_date'],
            'is_public' => ['boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'O título é obrigatório.',
            'title.max' => 'O título não pode ter mais de 255 caracteres.',
            'description.max' => 'A descrição não pode ter mais de 1000 caracteres.',
            'event_start_date.date' => 'A data de início deve ser uma data válida.',
            'event_end_date.date' => 'A data de fim deve ser uma data válida.',
            'event_end_date.after_or_equal' => 'A data de fim deve ser igual ou posterior à data de início.',
        ];
    }
}
