<?php

namespace App\Livewire\Services;

use App\Models\Service;
use Livewire\Component;
use Livewire\WithPagination;

class ServiceManager extends Component
{
    use WithPagination;

    public $showCreateModal = false;

    public $showEditModal = false;

    public $showDeleteModal = false;

    public $serviceToDelete = null;

    public $name = '';

    public $description = '';

    public $price = '';

    public $is_active = true;

    public $editingService = null;

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'is_active' => 'boolean',
        ];
    }

    protected function messages()
    {
        return [
            'name.required' => 'O nome do serviço é obrigatório.',
            'name.max' => 'O nome não pode ter mais de 255 caracteres.',
            'price.required' => 'O preço é obrigatório.',
            'price.numeric' => 'O preço deve ser um número válido.',
            'price.min' => 'O preço deve ser maior ou igual a 0.',
        ];
    }

    public function mount()
    {
        // Component initialization
    }

    public function openCreateModal()
    {
        $this->resetForm();
        $this->showCreateModal = true;
    }

    public function closeCreateModal()
    {
        $this->showCreateModal = false;
        $this->resetForm();
        $this->resetErrorBag();
    }

    public function openEditModal($serviceId)
    {
        $service = Service::query()->findOrFail($serviceId);
        $this->editingService = $service;
        $this->name = $service->name;
        $this->description = $service->description;
        $this->price = $service->price;
        $this->is_active = $service->is_active;
        $this->showEditModal = true;
    }

    public function closeEditModal()
    {
        $this->showEditModal = false;
        $this->resetForm();
        $this->resetErrorBag();
    }

    public function confirmDelete($serviceId)
    {
        $this->serviceToDelete = $serviceId;
        $this->showDeleteModal = true;
    }

    public function cancelDelete()
    {
        $this->showDeleteModal = false;
        $this->serviceToDelete = null;
    }

    public function createService()
    {
        $this->validate();

        Service::query()->create([
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'is_active' => $this->is_active,
        ]);

        $this->closeCreateModal();
        session()->flash('message', 'Serviço criado com sucesso!');
    }

    public function updateService()
    {
        $this->validate();

        $this->editingService->update([
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'is_active' => $this->is_active,
        ]);

        $this->closeEditModal();
        session()->flash('message', 'Serviço atualizado com sucesso!');
    }

    public function deleteService()
    {
        if (! $this->serviceToDelete) {
            return;
        }

        $service = Service::query()->findOrFail($this->serviceToDelete);
        $service->delete();

        $this->cancelDelete();
        session()->flash('message', 'Serviço excluído com sucesso!');
    }

    private function resetForm()
    {
        $this->name = '';
        $this->description = '';
        $this->price = '';
        $this->is_active = true;
        $this->editingService = null;
    }

    public function render()
    {
        $services = Service::query()
            ->latest()
            ->paginate(10);

        return view('livewire.services.service-manager', [
            'services' => $services,
        ]);
    }
}
