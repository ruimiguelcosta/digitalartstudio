<?php

namespace App\Livewire\Albums;

use App\Models\Album;
use Livewire\Component;
use Livewire\WithPagination;

class AlbumManager extends Component
{
    use WithPagination;

    public $search = '';

    public $isPublic = null;

    public $showCreateDialog = false;

    public $newAlbum = [
        'title' => '',
        'description' => '',
        'event_start_date' => '',
        'event_end_date' => '',
    ];

    protected $rules = [
        'newAlbum.title' => 'required|string|max:255',
        'newAlbum.description' => 'nullable|string',
        'newAlbum.event_start_date' => 'required|date',
        'newAlbum.event_end_date' => 'nullable|date|after_or_equal:newAlbum.event_start_date',
    ];

    protected $messages = [
        'newAlbum.title.required' => 'O título é obrigatório.',
        'newAlbum.event_start_date.required' => 'A data de início do evento é obrigatória.',
        'newAlbum.event_end_date.after_or_equal' => 'A data de fim deve ser igual ou posterior à data de início.',
    ];

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedIsPublic()
    {
        $this->resetPage();
    }

    public function openCreateDialog()
    {
        $this->showCreateDialog = true;
        $this->resetForm();
    }

    public function closeCreateDialog()
    {
        $this->showCreateDialog = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->newAlbum = [
            'title' => '',
            'description' => '',
            'event_start_date' => '',
            'event_end_date' => '',
        ];
        $this->resetErrorBag();
    }

    public function createAlbum()
    {
        $this->validate();

        Album::query()->create([
            'title' => $this->newAlbum['title'],
            'description' => $this->newAlbum['description'],
            'event_start_date' => $this->newAlbum['event_start_date'],
            'event_end_date' => $this->newAlbum['event_end_date'],
            'user_id' => auth()->id(),
        ]);

        $this->closeCreateDialog();
        $this->dispatch('album-created');

        session()->flash('message', 'Álbum criado com sucesso!');
    }

    public function deleteAlbum($albumId)
    {
        $album = Album::query()->findOrFail($albumId);

        if ($album->user_id !== auth()->id()) {
            session()->flash('error', 'Não tem permissão para excluir este álbum.');

            return;
        }

        $album->delete();
        $this->dispatch('album-deleted');

        session()->flash('message', 'Álbum excluído com sucesso!');
    }

    public function render()
    {
        $query = Album::query()->with(['photos', 'user']);

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%'.$this->search.'%')
                    ->orWhere('description', 'like', '%'.$this->search.'%');
            });
        }

        if ($this->isPublic !== null) {
            $query->where('is_public', $this->isPublic);
        }

        $albums = $query->latest()->paginate(15);

        return view('livewire.albums.album-manager', [
            'albums' => $albums,
        ]);
    }
}
