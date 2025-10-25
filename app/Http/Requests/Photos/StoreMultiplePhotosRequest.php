<?php

namespace App\Http\Requests\Photos;

use Illuminate\Foundation\Http\FormRequest;

class StoreMultiplePhotosRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'album_id' => ['required', 'exists:albums,id'],
            'photos.*' => ['required', 'image', 'max:10240'],
        ];
    }

    public function messages(): array
    {
        return [
            'album_id.required' => 'O álbum é obrigatório.',
            'album_id.exists' => 'O álbum selecionado não existe.',
            'photos.*.required' => 'Pelo menos uma foto é obrigatória.',
            'photos.*.image' => 'Todos os ficheiros devem ser imagens.',
            'photos.*.max' => 'Cada foto deve ter no máximo 10MB.',
        ];
    }
}
