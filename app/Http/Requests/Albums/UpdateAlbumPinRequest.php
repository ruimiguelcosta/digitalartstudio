<?php

namespace App\Http\Requests\Albums;

use App\Models\Album;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAlbumPinRequest extends FormRequest
{
    public function authorize(): bool
    {
        $user = auth()->user();
        $album = $this->route('album');

        if (! $user || ! $album instanceof Album) {
            return false;
        }

        $isManager = $user->roles()->where('slug', 'manager')->exists();
        $hasAccess = $album->manager_id === $user->id;

        return $isManager && $hasAccess;
    }

    public function rules(): array
    {
        return [
            'pin' => ['nullable', 'string', 'size:12', 'regex:/^[a-zA-Z0-9]{12}$/'],
        ];
    }
}
