<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePhotoRequest extends FormRequest
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
            'title' => ['sometimes', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'photo' => ['sometimes', 'image', 'mimes:jpeg,png,jpg,gif', 'max:10240'],
            'album_id' => ['sometimes', 'exists:albums,id'],
            'is_featured' => ['sometimes', 'boolean'],
            'order' => ['sometimes', 'integer', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.max' => 'O título não pode ter mais de 255 caracteres.',
            'description.max' => 'A descrição não pode ter mais de 1000 caracteres.',
            'photo.image' => 'O arquivo deve ser uma imagem.',
            'photo.mimes' => 'A imagem deve ser do tipo: jpeg, png, jpg ou gif.',
            'photo.max' => 'A imagem não pode ter mais de 10MB.',
            'album_id.exists' => 'O álbum selecionado não existe.',
            'order.integer' => 'A ordem deve ser um número inteiro.',
            'order.min' => 'A ordem deve ser maior ou igual a 0.',
        ];
    }
}
