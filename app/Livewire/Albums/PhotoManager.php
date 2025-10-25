<?php

namespace App\Livewire\Albums;

use App\Models\Album;
use App\Models\AlbumAccess;
use App\Models\Photo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class PhotoManager extends Component
{
    use WithFileUploads;

    public Album $album;

    public $photos = [];

    public $showUploadModal = false;

    public $uploadedPhotos = [];

    public $isUploading = false;

    protected $rules = [
        'uploadedPhotos.*' => 'required|image|max:10240', // 10MB max
    ];

    protected $messages = [
        'uploadedPhotos.*.required' => 'Selecione pelo menos uma foto.',
        'uploadedPhotos.*.image' => 'O arquivo deve ser uma imagem válida.',
        'uploadedPhotos.*.max' => 'A imagem não pode ser maior que 10MB.',
    ];

    public function mount(Album $album)
    {
        $this->album = $album;
        $this->loadPhotos();
    }

    public function loadPhotos()
    {
        $this->photos = $this->album->photos()->orderBy('order')->get()->toArray();
    }

    public function openUploadModal()
    {
        $this->showUploadModal = true;
        $this->uploadedPhotos = [];
    }

    public function closeUploadModal()
    {
        $this->showUploadModal = false;
        $this->uploadedPhotos = [];
        $this->resetErrorBag();
    }

    public function updatedUploadedPhotos()
    {
        $this->validate();
    }

    public function uploadPhotos()
    {
        $this->validate();

        $this->isUploading = true;

        try {
            $uploadedCount = 0;

            foreach ($this->uploadedPhotos as $photo) {
                $path = $photo->store('photos', 'public');

                Photo::query()->create([
                    'album_id' => $this->album->id,
                    'filename' => basename($path),
                    'original_name' => $photo->getClientOriginalName(),
                    'mime_type' => $photo->getMimeType(),
                    'size' => $photo->getSize(),
                    'order' => $this->album->photos()->count() + $uploadedCount + 1,
                ]);

                $uploadedCount++;
            }

            $this->loadPhotos();
            $this->closeUploadModal();

            session()->flash('message', "Sucesso! {$uploadedCount} fotos foram adicionadas ao álbum.");

        } catch (\Exception $e) {
            session()->flash('error', 'Erro ao fazer upload das fotos: '.$e->getMessage());
        } finally {
            $this->isUploading = false;
        }
    }

    public function deletePhoto($photoId)
    {
        $photo = Photo::query()->findOrFail($photoId);

        if ($photo->album->user_id !== auth()->id()) {
            session()->flash('error', 'Não tem permissão para excluir esta foto.');

            return;
        }

        // Delete file from storage
        Storage::disk('public')->delete('photos/'.$photo->filename);

        // Delete from database
        $photo->delete();

        $this->loadPhotos();
        session()->flash('message', 'Foto excluída com sucesso!');
    }

    public function publishAlbum()
    {
        if ($this->album->user_id !== auth()->id()) {
            session()->flash('error', 'Não tem permissão para publicar este álbum.');

            return;
        }

        $this->album->update(['is_public' => true]);
        session()->flash('message', 'Álbum publicado com sucesso!');
    }

    public function render()
    {
        $accesses = collect();

        // Only show accesses for admins
        if (Auth::user()->is_admin) {
            $accesses = AlbumAccess::where('album_id', $this->album->id)
                ->with('user')
                ->latest('accessed_at')
                ->limit(50)
                ->get();
        }

        return view('livewire.albums.photo-manager', [
            'accesses' => $accesses,
        ]);
    }
}
