<?php

namespace App\Actions\Http\Photos;

use App\Http\Requests\UpdatePhotoRequest;
use App\Models\Photo;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UpdatePhotoAction
{
    public function __invoke(UpdatePhotoRequest $request, Photo $photo): JsonResponse
    {
        $data = $request->validated();

        if ($request->hasFile('photo')) {
            Storage::delete($photo->path);
            
            $file = $request->file('photo');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('photos', $filename, 'public');
            
            $data['filename'] = $filename;
            $data['original_filename'] = $file->getClientOriginalName();
            $data['mime_type'] = $file->getMimeType();
            $data['file_size'] = $file->getSize();
            $data['path'] = $path;
            $data['url'] = $path;
        }

        $photo->update($data);

        return response()->json([
            'message' => 'Foto atualizada com sucesso!',
            'data' => $photo->load('album'),
        ]);
    }
}
