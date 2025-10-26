<?php

namespace App\Http\Requests\Photos;

use Illuminate\Foundation\Http\FormRequest;

class StorePhotoRequest extends FormRequest
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
        $maxSizeBytes = config('photos.max_size_mb') * 1024 * 1024;

        return [
            'album_id' => ['required', 'exists:albums,id'],
            'path' => ['required', 'string', 'max:255'],
            'original_filename' => ['required', 'string', 'max:255'],
            'size' => ['nullable', 'integer', 'min:0', 'max:'.$maxSizeBytes],
        ];
    }
}
