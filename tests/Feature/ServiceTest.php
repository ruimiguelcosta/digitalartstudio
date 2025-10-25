<?php

namespace Tests\Feature;

use App\Filament\Resources\Services\Pages\CreateService;
use App\Filament\Resources\Services\Pages\EditService;
use App\Filament\Resources\Services\Pages\ListServices;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_service(): void
    {
        $adminUser = User::factory()->create(['role' => 'admin']);

        Livewire::actingAs($adminUser)
            ->test(CreateService::class)
            ->fillForm([
                'name' => 'Sessão de Fotografia',
                'price' => 150.00,
                'description' => 'Sessão de fotografia profissional',
                'is_active' => true,
            ])
            ->call('create')
            ->assertNotified()
            ->assertRedirect();

        $this->assertDatabaseHas('services', [
            'name' => 'Sessão de Fotografia',
            'price' => 150.00,
        ]);
    }

    public function test_admin_can_update_service(): void
    {
        $adminUser = User::factory()->create(['role' => 'admin']);
        $service = Service::factory()->create(['price' => 100.00]);

        Livewire::actingAs($adminUser)
            ->test(EditService::class, ['record' => $service->id])
            ->fillForm([
                'name' => 'Sessão Premium',
                'price' => 200.00,
            ])
            ->call('save')
            ->assertNotified();

        $service->refresh();
        $this->assertSame('Sessão Premium', $service->name);
        $this->assertSame('200.00', $service->price);
    }

    public function test_service_validation_requires_name_and_price(): void
    {
        $adminUser = User::factory()->create(['role' => 'admin']);

        Livewire::actingAs($adminUser)
            ->test(CreateService::class)
            ->fillForm([
                'name' => '',
                'price' => null,
            ])
            ->call('create')
            ->assertHasFormErrors(['name', 'price']);
    }

    public function test_price_must_be_positive(): void
    {
        $adminUser = User::factory()->create(['role' => 'admin']);

        Livewire::actingAs($adminUser)
            ->test(CreateService::class)
            ->fillForm([
                'name' => 'Test Service',
                'price' => -10.00,
            ])
            ->call('create')
            ->assertHasFormErrors(['price']);
    }

    public function test_admin_can_list_services(): void
    {
        $adminUser = User::factory()->create(['role' => 'admin']);
        $services = Service::factory()->count(3)->create();

        Livewire::actingAs($adminUser)
            ->test(ListServices::class)
            ->assertCanSeeTableRecords($services);
    }
}
