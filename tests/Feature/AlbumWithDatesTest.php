<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AlbumWithDatesTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_album_with_event_dates(): void
    {
        $adminUser = User::factory()->create(['role' => 'admin']);

        $this->actingAs($adminUser);

        $albumData = [
            'title' => 'Casamento João & Maria',
            'description' => 'Cerimónia de casamento',
            'event_start_date' => '2025-12-01',
            'event_end_date' => '2025-12-01',
            'is_public' => false,
        ];

        $response = $this->postJson('/api/albums', $albumData);

        $response->assertStatus(201);

        $this->assertDatabaseHas('albums', [
            'title' => 'Casamento João & Maria',
            'event_start_date' => '2025-12-01 00:00:00',
            'event_end_date' => '2025-12-01 00:00:00',
            'user_id' => $adminUser->id,
        ]);
    }

    public function test_validates_event_end_date_is_after_start_date(): void
    {
        $adminUser = User::factory()->create(['role' => 'admin']);

        $this->actingAs($adminUser);

        $albumData = [
            'title' => 'Evento Inválido',
            'event_start_date' => '2025-12-03',
            'event_end_date' => '2025-12-01',
        ];

        $response = $this->postJson('/api/albums', $albumData);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['event_end_date']);
    }

    public function test_can_create_album_without_event_dates(): void
    {
        $adminUser = User::factory()->create(['role' => 'admin']);

        $this->actingAs($adminUser);

        $albumData = [
            'title' => 'Álbum Sem Datas',
            'description' => 'Álbum sem datas de evento',
        ];

        $response = $this->postJson('/api/albums', $albumData);

        $response->assertStatus(201);

        $this->assertDatabaseHas('albums', [
            'title' => 'Álbum Sem Datas',
            'event_start_date' => null,
            'event_end_date' => null,
            'user_id' => $adminUser->id,
        ]);
    }
}
