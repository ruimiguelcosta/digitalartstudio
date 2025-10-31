<?php

namespace Tests\Feature;

use App\Models\Album;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AlbumsTest extends TestCase
{
    use RefreshDatabase;

    public function test_cria_um_album_com_sucesso(): void
    {
        $payload = [
            'name' => 'Casamento 2024',
            'description' => 'Fotos do casamento',
            'start_date' => '2024-06-01',
            'end_date' => '2024-06-05',
            'status' => 'private',
        ];

        $response = $this->postJson('/api/albums', $payload)
            ->assertCreated()
            ->assertJsonPath('name', 'Casamento 2024')
            ->assertJsonPath('description', 'Fotos do casamento')
            ->assertJsonPath('start_date', '2024-06-01T00:00:00.000000Z')
            ->assertJsonPath('end_date', '2024-06-05T00:00:00.000000Z');

        $this->assertTrue(Album::query()->where('name', 'Casamento 2024')->exists());
    }

    public function test_lista_todos_os_albums(): void
    {
        $album = Album::factory()->create();

        $this->getJson('/api/albums')
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'name', 'description', 'start_date', 'end_date', 'created_at', 'updated_at'],
                ],
            ]);
    }

    public function test_mostra_um_album_especifico(): void
    {
        $album = Album::factory()->create();

        $this->getJson("/api/albums/{$album->id}")
            ->assertOk()
            ->assertJsonPath('name', $album->name);
    }

    public function test_atualiza_um_album_com_sucesso(): void
    {
        $album = Album::factory()->create([
            'name' => 'Album Original',
            'start_date' => '2024-01-01',
            'end_date' => '2024-01-31',
        ]);

        $payload = [
            'name' => 'Album Atualizado',
            'description' => $album->description,
            'start_date' => '2024-01-01',
            'end_date' => '2024-01-31',
            'status' => 'private',
        ];

        $this->patchJson("/api/albums/{$album->id}", $payload)
            ->assertOk()
            ->assertJsonPath('name', 'Album Atualizado');

        $this->assertEquals('Album Atualizado', $album->refresh()->name);
    }

    public function test_deleta_um_album_com_sucesso(): void
    {
        $album = Album::factory()->create();

        $this->deleteJson("/api/albums/{$album->id}")
            ->assertNoContent();

        $this->assertNull(Album::query()->find($album->id));
    }

    public function test_valida_que_o_nome_e_obrigatorio(): void
    {
        $payload = [
            'description' => 'Test',
            'start_date' => '2024-06-01',
            'end_date' => '2024-06-01',
        ];

        $this->postJson('/api/albums', $payload)
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['name']);
    }

    public function test_valida_que_end_date_deve_ser_depois_de_start_date(): void
    {
        $payload = [
            'name' => 'Test',
            'start_date' => '2024-06-01',
            'end_date' => '2024-05-01',
        ];

        $this->postJson('/api/albums', $payload)
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['end_date']);
    }

    public function test_manager_pode_definir_pin_para_album_que_gerencia(): void
    {
        $managerRole = Role::query()->firstOrCreate(['slug' => 'manager'], ['name' => 'Manager']);
        $managerUser = User::factory()->create();
        $managerUser->roles()->attach($managerRole);

        $album = Album::factory()->create(['manager_id' => $managerUser->id]);

        $payload = ['pin' => 'ABC12345'];

        $this->actingAs($managerUser)
            ->patchJson("/api/albums/{$album->id}/pin", $payload)
            ->assertOk()
            ->assertJsonPath('pin', 'ABC12345');

        $this->assertEquals('ABC12345', $album->refresh()->pin);
    }

    public function test_manager_pode_remover_pin_definindo_null(): void
    {
        $managerRole = Role::query()->firstOrCreate(['slug' => 'manager'], ['name' => 'Manager']);
        $managerUser = User::factory()->create();
        $managerUser->roles()->attach($managerRole);

        $album = Album::factory()->create([
            'manager_id' => $managerUser->id,
            'pin' => 'OLD12345',
        ]);

        $payload = ['pin' => null];

        $this->actingAs($managerUser)
            ->patchJson("/api/albums/{$album->id}/pin", $payload)
            ->assertOk()
            ->assertJsonPath('pin', null);

        $this->assertNull($album->refresh()->pin);
    }

    public function test_manager_nao_pode_definir_pin_para_album_que_nao_gerencia(): void
    {
        $managerRole = Role::query()->firstOrCreate(['slug' => 'manager'], ['name' => 'Manager']);
        $managerUser = User::factory()->create();
        $otherManager = User::factory()->create();
        $managerUser->roles()->attach($managerRole);

        $album = Album::factory()->create(['manager_id' => $otherManager->id]);

        $payload = ['pin' => 'ABC12345'];

        $this->actingAs($managerUser)
            ->patchJson("/api/albums/{$album->id}/pin", $payload)
            ->assertForbidden();
    }

    public function test_usuario_sem_role_manager_nao_pode_definir_pin(): void
    {
        $user = User::factory()->create();
        $album = Album::factory()->create(['manager_id' => $user->id]);

        $payload = ['pin' => 'ABC12345'];

        $this->actingAs($user)
            ->patchJson("/api/albums/{$album->id}/pin", $payload)
            ->assertForbidden();
    }

    public function test_valida_que_pin_deve_ter_exatamente_8_caracteres(): void
    {
        $managerRole = Role::query()->firstOrCreate(['slug' => 'manager'], ['name' => 'Manager']);
        $managerUser = User::factory()->create();
        $managerUser->roles()->attach($managerRole);

        $album = Album::factory()->create(['manager_id' => $managerUser->id]);

        $payload = ['pin' => 'ABC123'];

        $this->actingAs($managerUser)
            ->patchJson("/api/albums/{$album->id}/pin", $payload)
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['pin']);
    }

    public function test_valida_que_pin_deve_conter_apenas_letras_e_numeros(): void
    {
        $managerRole = Role::query()->firstOrCreate(['slug' => 'manager'], ['name' => 'Manager']);
        $managerUser = User::factory()->create();
        $managerUser->roles()->attach($managerRole);

        $album = Album::factory()->create(['manager_id' => $managerUser->id]);

        $payload = ['pin' => 'ABC-1234'];

        $this->actingAs($managerUser)
            ->patchJson("/api/albums/{$album->id}/pin", $payload)
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['pin']);
    }

    public function test_pin_pode_conter_letras_minusculas_e_maiusculas(): void
    {
        $managerRole = Role::query()->firstOrCreate(['slug' => 'manager'], ['name' => 'Manager']);
        $managerUser = User::factory()->create();
        $managerUser->roles()->attach($managerRole);

        $album = Album::factory()->create(['manager_id' => $managerUser->id]);

        $payload = ['pin' => 'AbC12345'];

        $this->actingAs($managerUser)
            ->patchJson("/api/albums/{$album->id}/pin", $payload)
            ->assertOk()
            ->assertJsonPath('pin', 'AbC12345');
    }
}
