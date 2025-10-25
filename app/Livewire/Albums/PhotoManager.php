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

    public $showDeleteModal = false;

    public $photoToDelete = null;

    public $showSlideshow = false;

    public $currentSlideIndex = 0;

    public $isSlideshowPlaying = false;

    protected function rules()
    {
        return [
            'uploadedPhotos.*' => 'required|image|max:'.(config('photos.max_size_mb') * 1024), // Convert MB to KB
            'uploadedPhotos' => 'max:'.config('photos.max_count'),
        ];
    }

    protected function messages()
    {
        return [
            'uploadedPhotos.*.required' => 'Selecione pelo menos uma foto.',
            'uploadedPhotos.*.image' => 'O arquivo deve ser uma imagem válida.',
            'uploadedPhotos.*.max' => 'A imagem não pode ser maior que '.config('photos.max_size_mb').'MB.',
            'uploadedPhotos.max' => 'Máximo '.config('photos.max_count').' fotos por upload.',
        ];
    }

    private function generatePhotoRef(): string
    {
        $albumTitle = $this->album->title;

        $words = explode(' ', $albumTitle);
        $initials = '';

        foreach ($words as $word) {
            if (! empty(trim($word))) {
                $initials .= strtoupper(substr($word, 0, 1));
            }
        }

        $lastPhoto = Photo::query()
            ->where('album_id', $this->album->id)
            ->where('ref', 'like', $initials.'-%')
            ->orderBy('ref', 'desc')
            ->first();

        if ($lastPhoto && $lastPhoto->ref) {
            $lastNumber = (int) substr($lastPhoto->ref, strrpos($lastPhoto->ref, '-') + 1);
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1;
        }

        return $initials.'-'.str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
    }

    public function mount(Album $album)
    {
        $this->album = $album;
        $this->loadPhotos();
    }

    public function loadPhotos()
    {
        $this->photos = $this->album->photos()->orderBy('order')->get()->toArray();
    }

    public function refreshPhotos()
    {
        $this->loadPhotos();
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

    public function removePhoto($index)
    {
        if (isset($this->uploadedPhotos[$index])) {
            unset($this->uploadedPhotos[$index]);
            $this->uploadedPhotos = array_values($this->uploadedPhotos);
            $this->resetErrorBag();
        }
    }

    public function confirmDelete($photoId)
    {
        $this->photoToDelete = $photoId;
        $this->showDeleteModal = true;
    }

    public function cancelDelete()
    {
        $this->showDeleteModal = false;
        $this->photoToDelete = null;
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
                $ref = $this->generatePhotoRef();
                $extension = $photo->getClientOriginalExtension();
                $newFilename = $ref.'.'.$extension;

                // Criar estrutura de pastas: photos/slug-album/nome-da-foto
                $albumFolder = 'photos/'.$this->album->slug;
                $path = $photo->storeAs($albumFolder, $newFilename, 'public');

                Photo::query()->create([
                    'ref' => $ref,
                    'album_id' => $this->album->id,
                    'title' => pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME), // Extract filename without extension
                    'filename' => $newFilename,
                    'original_filename' => $photo->getClientOriginalName(),
                    'mime_type' => $photo->getMimeType(),
                    'file_size' => $photo->getSize(),
                    'path' => $path, // Add the full path
                    'url' => Storage::disk('public')->url($path), // Add the public URL
                    'order' => $this->album->photos()->count() + $uploadedCount + 1,
                    'user_id' => auth()->id(),
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

    public function deletePhoto()
    {
        if (! $this->photoToDelete) {
            return;
        }

        $photo = Photo::query()->findOrFail($this->photoToDelete);

        if ($photo->album->user_id !== auth()->id()) {
            session()->flash('error', 'Não tem permissão para excluir esta foto.');
            $this->cancelDelete();

            return;
        }

        // Delete file from storage
        Storage::disk('public')->delete($photo->path);

        // Delete from database
        $photo->delete();

        $this->loadPhotos();

        // Close modal
        $this->cancelDelete();

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

    public function openSlideshow($startIndex = 0)
    {
        if (count($this->photos) === 0) {
            return;
        }

        $this->currentSlideIndex = $startIndex;
        $this->showSlideshow = true;
        $this->isSlideshowPlaying = true;

        $this->dispatch('slideshow-playing');
    }

    public function closeSlideshow()
    {
        $this->showSlideshow = false;
        $this->isSlideshowPlaying = false;
        $this->currentSlideIndex = 0;

        $this->dispatch('slideshow-paused');
    }

    public function nextSlide()
    {
        if (count($this->photos) === 0) {
            return;
        }

        $this->currentSlideIndex = ($this->currentSlideIndex + 1) % count($this->photos);
    }

    public function previousSlide()
    {
        if (count($this->photos) === 0) {
            return;
        }

        $this->currentSlideIndex = $this->currentSlideIndex === 0
            ? count($this->photos) - 1
            : $this->currentSlideIndex - 1;
    }

    public function goToSlide($index)
    {
        if ($index >= 0 && $index < count($this->photos)) {
            $this->currentSlideIndex = $index;
        }
    }

    public function toggleSlideshowPlay()
    {
        $this->isSlideshowPlaying = ! $this->isSlideshowPlaying;

        if ($this->isSlideshowPlaying) {
            $this->dispatch('slideshow-playing');
        } else {
            $this->dispatch('slideshow-paused');
        }
    }

    public function render()
    {
        $accesses = collect();

        // Only show accesses for admins
        if (Auth::user()->isAdmin()) {
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
