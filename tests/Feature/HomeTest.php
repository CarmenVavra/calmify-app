<?php

namespace Tests\Feature;

use App\Livewire\GroundingExercise;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomeTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_is_reachable_without_login(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSeeLivewire(GroundingExercise::class);
        $response->assertSee('Calmify Me');
        $response->assertSee('Übung starten');
        $response->assertSee('Du bist hier sicher.', false);
        $response->assertSee(route('sos'));
    }

    public function test_home_contains_the_exercise_and_completion_screens(): void
    {
        $response = $this->get('/');

        $response->assertSee('aria-label="Tippe, sobald du ein Ding benannt hast"', false);
        $response->assertSee('aria-label="Übung beenden"', false);
        $response->assertSee('aria-live="polite"', false);
        $response->assertSee('Du hast es geschafft.');
        $response->assertSee('Noch eine Runde');
        $response->assertSee('Zur Startseite');
    }

    public function test_layout_is_german_and_sets_security_headers(): void
    {
        $response = $this->get('/');

        $response->assertSee('<html lang="de">', false);
        $response->assertHeader('X-Content-Type-Options', 'nosniff');
        $response->assertHeader('X-Frame-Options', 'DENY');
        $response->assertHeader('Referrer-Policy', 'no-referrer');
    }

    public function test_pwa_files_are_served(): void
    {
        $this->assertFileExists(public_path('manifest.webmanifest'));
        $this->assertFileExists(public_path('sw.js'));
        $this->assertFileExists(public_path('icon.svg'));
    }
}
