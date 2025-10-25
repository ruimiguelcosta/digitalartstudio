<?php

namespace Tests\Feature;

use App\Livewire\Services\ServiceManager;
use App\Models\Service;
use App\Models\User;
use Livewire\Livewire;
use Tests\TestCase;

class ServiceManagerTest extends TestCase
{
    public function test_admin_can_access_services_page(): void
    {
        $adminUser = User::factory()->create(['role' => 'admin']);

        $this->actingAs($adminUser);

        $this->get('/services')
            ->assertStatus(200)
            ->assertSee('Gestão de Serviços');
    }

    public function test_regular_user_cannot_access_services_page(): void
    {
        $regularUser = User::factory()->create(['role' => 'user']);

        $this->actingAs($regularUser);

        $this->get('/services')
            ->assertStatus(403);
    }

    public function test_guest_cannot_access_services_page(): void
    {
        $this->get('/services')
            ->assertRedirect('/auth');
    }

    public function test_can_create_service(): void
    {
        $adminUser = User::factory()->create(['role' => 'admin']);

        $this->actingAs($adminUser);

        Livewire::test(ServiceManager::class)
            ->set('name', 'Fotografia de Evento')
            ->set('description', 'Serviço completo de fotografia')
            ->set('price', 150.00)
            ->set('is_active', true)
            ->call('createService')
            ->assertSet('showCreateModal', false);

        $this->assertDatabaseHas('services', [
            'name' => 'Fotografia de Evento',
            'description' => 'Serviço completo de fotografia',
            'price' => 150.00,
            'is_active' => true,
        ]);
    }

    public function test_can_edit_service(): void
    {
        $adminUser = User::factory()->create(['role' => 'admin']);
        $service = Service::factory()->create([
            'name' => 'Serviço Original',
            'price' => 100.00,
        ]);

        $this->actingAs($adminUser);

        Livewire::test(ServiceManager::class)
            ->call('openEditModal', $service->id)
            ->set('name', 'Serviço Atualizado')
            ->set('price', 200.00)
            ->call('updateService')
            ->assertSet('showEditModal', false);

        $this->assertDatabaseHas('services', [
            'id' => $service->id,
            'name' => 'Serviço Atualizado',
            'price' => 200.00,
        ]);
    }

    public function test_can_delete_service(): void
    {
        $adminUser = User::factory()->create(['role' => 'admin']);
        $service = Service::factory()->create();

        $this->actingAs($adminUser);

        Livewire::test(ServiceManager::class)
            ->call('confirmDelete', $service->id)
            ->call('deleteService')
            ->assertSet('showDeleteModal', false);

        $this->assertDatabaseMissing('services', [
            'id' => $service->id,
        ]);
    }

    public function test_service_validation(): void
    {
        $adminUser = User::factory()->create(['role' => 'admin']);

        $this->actingAs($adminUser);

        Livewire::test(ServiceManager::class)
            ->set('name', '')
            ->set('price', -10)
            ->call('createService')
            ->assertHasErrors(['name', 'price']);
    }

    public function test_services_menu_link_only_visible_to_admin(): void
    {
        $adminUser = User::factory()->create(['role' => 'admin']);
        $regularUser = User::factory()->create(['role' => 'user']);

        // Admin should see services link
        $this->actingAs($adminUser);
        $this->get('/dashboard')
            ->assertSee('Serviços');

        // Regular user should not see services link
        $this->actingAs($regularUser);
        $this->get('/dashboard')
            ->assertDontSee('Serviços');
    }
}
