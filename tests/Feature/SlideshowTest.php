<?php

namespace Tests\Feature;

use App\Livewire\Albums\PhotoManager;
use App\Models\Album;
use App\Models\Photo;
use App\Models\User;
use Livewire\Livewire;
use Tests\TestCase;

class SlideshowTest extends TestCase
{
    public function test_can_open_slideshow_from_album_header(): void
    {
        $user = User::factory()->create();
        $album = Album::factory()->create(['user_id' => $user->id]);
        $photos = Photo::factory()->count(3)->create(['album_id' => $album->id]);

        $this->actingAs($user);

        Livewire::test(PhotoManager::class, ['album' => $album])
            ->call('openSlideshow', 0)
            ->assertSet('showSlideshow', true)
            ->assertSet('currentSlideIndex', 0)
            ->assertSet('isSlideshowPlaying', true);
    }

    public function test_can_open_slideshow_from_specific_photo_index(): void
    {
        $user = User::factory()->create();
        $album = Album::factory()->create(['user_id' => $user->id]);
        $photos = Photo::factory()->count(3)->create(['album_id' => $album->id]);

        $this->actingAs($user);

        Livewire::test(PhotoManager::class, ['album' => $album])
            ->call('openSlideshow', 2)
            ->assertSet('showSlideshow', true)
            ->assertSet('currentSlideIndex', 2)
            ->assertSet('isSlideshowPlaying', true);
    }

    public function test_can_navigate_slideshow_with_next_slide(): void
    {
        $user = User::factory()->create();
        $album = Album::factory()->create(['user_id' => $user->id]);
        $photos = Photo::factory()->count(3)->create(['album_id' => $album->id]);

        $this->actingAs($user);

        Livewire::test(PhotoManager::class, ['album' => $album])
            ->call('openSlideshow', 0)
            ->call('nextSlide')
            ->assertSet('currentSlideIndex', 1)
            ->call('nextSlide')
            ->assertSet('currentSlideIndex', 2)
            ->call('nextSlide')
            ->assertSet('currentSlideIndex', 0); // Should loop back to first
    }

    public function test_can_navigate_slideshow_with_previous_slide(): void
    {
        $user = User::factory()->create();
        $album = Album::factory()->create(['user_id' => $user->id]);
        $photos = Photo::factory()->count(3)->create(['album_id' => $album->id]);

        $this->actingAs($user);

        Livewire::test(PhotoManager::class, ['album' => $album])
            ->call('openSlideshow', 0)
            ->call('previousSlide')
            ->assertSet('currentSlideIndex', 2) // Should loop to last
            ->call('previousSlide')
            ->assertSet('currentSlideIndex', 1);
    }

    public function test_can_go_to_specific_slide(): void
    {
        $user = User::factory()->create();
        $album = Album::factory()->create(['user_id' => $user->id]);
        $photos = Photo::factory()->count(5)->create(['album_id' => $album->id]);

        $this->actingAs($user);

        Livewire::test(PhotoManager::class, ['album' => $album])
            ->call('openSlideshow', 0)
            ->call('goToSlide', 3)
            ->assertSet('currentSlideIndex', 3);
    }

    public function test_can_toggle_slideshow_play_pause(): void
    {
        $user = User::factory()->create();
        $album = Album::factory()->create(['user_id' => $user->id]);
        $photos = Photo::factory()->count(3)->create(['album_id' => $album->id]);

        $this->actingAs($user);

        Livewire::test(PhotoManager::class, ['album' => $album])
            ->call('openSlideshow', 0)
            ->assertSet('isSlideshowPlaying', true)
            ->call('toggleSlideshowPlay')
            ->assertSet('isSlideshowPlaying', false)
            ->call('toggleSlideshowPlay')
            ->assertSet('isSlideshowPlaying', true);
    }

    public function test_can_close_slideshow(): void
    {
        $user = User::factory()->create();
        $album = Album::factory()->create(['user_id' => $user->id]);
        $photos = Photo::factory()->count(3)->create(['album_id' => $album->id]);

        $this->actingAs($user);

        Livewire::test(PhotoManager::class, ['album' => $album])
            ->call('openSlideshow', 0)
            ->assertSet('showSlideshow', true)
            ->call('closeSlideshow')
            ->assertSet('showSlideshow', false)
            ->assertSet('isSlideshowPlaying', false)
            ->assertSet('currentSlideIndex', 0);
    }

    public function test_does_not_open_slideshow_when_album_has_no_photos(): void
    {
        $user = User::factory()->create();
        $album = Album::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user);

        Livewire::test(PhotoManager::class, ['album' => $album])
            ->call('openSlideshow', 0)
            ->assertSet('showSlideshow', false);
    }

    public function test_shows_slideshow_button_only_when_album_has_photos(): void
    {
        $user = User::factory()->create(['role' => 'admin']);
        $album = Album::factory()->create(['user_id' => $user->id]);
        $photos = Photo::factory()->count(2)->create(['album_id' => $album->id]);

        $this->actingAs($user);

        $this->get("/album/{$album->id}")
            ->assertSee('Slideshow')
            ->assertSee('Iniciar slideshow');
    }
}
