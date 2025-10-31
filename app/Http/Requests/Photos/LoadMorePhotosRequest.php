<?php

namespace App\Http\Requests\Photos;

use Illuminate\Foundation\Http\FormRequest;

class LoadMorePhotosRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'album_id' => ['required', 'uuid', 'exists:albums,id'],
            'offset' => ['required', 'integer', 'min:0'],
        ];
    }
}
