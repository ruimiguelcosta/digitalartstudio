<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePhotoRequest extends FormRequest
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
            'photo' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:10240'],
            'album_id' => ['required', 'exists:albums,id'],
            'is_featured' => ['boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'O título é obrigatório.',
            'title.max' => 'O título não pode ter mais de 255 caracteres.',
            'description.max' => 'A descrição não pode ter mais de 1000 caracteres.',
            'photo.required' => 'A foto é obrigatória.',
            'photo.image' => 'O arquivo deve ser uma imagem.',
            'photo.mimes' => 'A imagem deve ser do tipo: jpeg, png, jpg ou gif.',
            'photo.max' => 'A imagem não pode ter mais de 10MB.',
            'album_id.required' => 'O álbum é obrigatório.',
            'album_id.exists' => 'O álbum selecionado não existe.',
        ];
    }
}
