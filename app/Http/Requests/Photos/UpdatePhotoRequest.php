<?php

namespace App\Http\Requests\Photos;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePhotoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'album_id' => ['sometimes', 'exists:albums,id'],
            'path' => ['sometimes', 'string', 'max:255'],
            'original_filename' => ['sometimes', 'string', 'max:255'],
            'size' => ['nullable', 'integer', 'min:0'],
        ];
    }
}
