<?php

namespace Tests\Feature;

use App\Models\PanicLog;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HealthDataConsentTest extends TestCase
{
    use RefreshDatabase;

    public function test_settings_offer_consent_when_none_is_given(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('settings'));

        $response->assertSee('Übungsprotokoll');
        $response->assertSee('Derzeit wird keine Übung gespeichert.');
        $response->assertSee(route('consent.store'));
        $response->assertDontSee('Abgeschlossene Übungen');
    }

    public function test_users_can_give_consent_in_the_settings(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->put(route('consent.store'), ['health_data_consent' => '1'])
            ->assertRedirect(route('settings'))
            ->assertSessionHas('status');

        $this->assertTrue($user->fresh()->hasHealthDataConsent());
    }

    public function test_consent_must_be_given_actively(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->put(route('consent.store'), [])
            ->assertSessionHasErrorsIn('healthConsent', ['health_data_consent']);

        $this->assertFalse($user->fresh()->hasHealthDataConsent());
    }

    public function test_revoking_consent_deletes_all_exercise_logs(): void
    {
        $user = User::factory()->withHealthDataConsent()->create();
        PanicLog::factory()->count(3)->for($user)->create();
        $other = PanicLog::factory()->for(User::factory()->withHealthDataConsent())->create();

        $this->actingAs($user)
            ->delete(route('consent.destroy'))
            ->assertRedirect(route('settings'));

        $this->assertFalse($user->fresh()->hasHealthDataConsent());
        $this->assertSame(0, $user->panicLogs()->count());
        $this->assertModelExists($other);
    }

    public function test_settings_show_revoke_option_with_consent(): void
    {
        $user = User::factory()->withHealthDataConsent()->create();

        $this->actingAs($user)
            ->get(route('settings'))
            ->assertSee('Einwilligung widerrufen')
            ->assertSee(route('consent.destroy'));
    }

    public function test_guests_cannot_change_consent(): void
    {
        $this->put(route('consent.store'), ['health_data_consent' => '1'])->assertRedirect(route('login'));
        $this->delete(route('consent.destroy'))->assertRedirect(route('login'));
    }
}
