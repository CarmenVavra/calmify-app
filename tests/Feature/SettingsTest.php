<?php

namespace Tests\Feature;

use App\Models\EmergencyContact;
use App\Models\PanicLog;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SettingsTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_see_device_preferences_and_account_options(): void
    {
        $response = $this->get(route('settings'));

        $response->assertStatus(200);
        $response->assertSee('Farbschema');
        $response->assertSee('Nachtblau');
        $response->assertSee('Atemrhythmus');
        $response->assertSee('Box 4-4-4-4');
        $response->assertSee('Vibration beim Tippen');
        $response->assertSee(route('register'));
    }

    public function test_country_choice_is_offered_and_preselected(): void
    {
        config(['calmify.default_country' => 'AT']);

        $response = $this->get(route('settings'));

        $response->assertSee('Land');
        $response->assertSee('Österreich');
        $response->assertSee('Deutschland');
        $response->assertSee('value="AT" x-model="country" checked', false);

        $this->withUnencryptedCookie('calmify_country', 'DE')
            ->get(route('settings'))
            ->assertSee('value="DE" x-model="country" checked', false);
    }

    public function test_users_see_their_account_and_progress(): void
    {
        $user = User::factory()->create(['username' => 'ruhepol']);
        PanicLog::factory()->count(3)->for($user)->create();

        $response = $this->actingAs($user)->get(route('settings'));

        $response->assertSee('ruhepol');
        $response->assertSee('Abgeschlossene Übungen: 3');
        $response->assertSee('Konto löschen');
    }

    public function test_account_deletion_requires_the_password(): void
    {
        $user = User::factory()->create(['password' => 'geheim1234']);

        $this->actingAs($user)
            ->delete(route('account.destroy'), ['password' => 'falsch'])
            ->assertSessionHasErrorsIn('deleteAccount', ['password']);

        $this->assertModelExists($user);
    }

    public function test_account_deletion_removes_all_personal_data(): void
    {
        $user = User::factory()->create(['password' => 'geheim1234']);
        EmergencyContact::factory()->count(2)->for($user)->create();
        PanicLog::factory()->count(2)->for($user)->create();

        $this->actingAs($user)
            ->delete(route('account.destroy'), ['password' => 'geheim1234'])
            ->assertRedirect(route('home'));

        $this->assertGuest();
        $this->assertModelMissing($user);
        $this->assertDatabaseCount('emergency_contacts', 0);
        $this->assertDatabaseCount('panic_logs', 0);
    }
}
