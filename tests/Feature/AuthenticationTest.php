<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_and_register_pages_render(): void
    {
        $this->get(route('login'))->assertStatus(200)->assertSee('Anmelden');
        $this->get(route('register'))->assertStatus(200)->assertSee('Anonymes Konto');
    }

    public function test_users_can_register_anonymously(): void
    {
        $response = $this->post(route('register'), [
            'username' => 'Stiller-Fuchs',
            'password' => 'geheim1234',
            'password_confirmation' => 'geheim1234',
            'age_confirmed' => '1',
        ]);

        $response->assertRedirect(route('sos'));
        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', ['username' => 'stiller-fuchs']);
        $this->assertFalse(User::sole()->hasHealthDataConsent());
    }

    public function test_registration_records_optional_health_data_consent(): void
    {
        $this->post(route('register'), [
            'username' => 'ruhepol',
            'password' => 'geheim1234',
            'password_confirmation' => 'geheim1234',
            'age_confirmed' => '1',
            'health_data_consent' => '1',
        ])->assertRedirect(route('sos'));

        $this->assertTrue(User::sole()->hasHealthDataConsent());
    }

    public function test_registration_requires_age_confirmation(): void
    {
        $this->post(route('register'), [
            'username' => 'ruhepol',
            'password' => 'geheim1234',
            'password_confirmation' => 'geheim1234',
        ])->assertSessionHasErrors(['age_confirmed']);

        $this->assertGuest();
        $this->assertDatabaseCount('users', 0);
    }

    public function test_register_page_explains_consent_and_links_legal_pages(): void
    {
        $response = $this->get(route('register'));

        $response->assertSee('name="health_data_consent"', false);
        $this->assertDoesNotMatchRegularExpression('/name="health_data_consent"[^>]*checked/', $response->getContent());
        $response->assertSee('Ich bin mindestens 14 Jahre alt.');
        $response->assertSee('Gesundheitsdaten');
        $response->assertSee(route('legal.privacy'));
        $response->assertSee(route('legal.about').'#nutzung');
    }

    public function test_registration_validates_input(): void
    {
        User::factory()->create(['username' => 'vergeben']);

        $this->post(route('register'), [
            'username' => 'Vergeben',
            'password' => 'kurz',
            'password_confirmation' => 'anders',
        ])->assertSessionHasErrors(['username', 'password']);

        $this->post(route('register'), [
            'username' => 'max mustermann@mail.de',
            'password' => 'geheim1234',
            'password_confirmation' => 'geheim1234',
        ])->assertSessionHasErrors(['username']);

        $this->assertGuest();
    }

    public function test_users_can_login_case_insensitively(): void
    {
        $user = User::factory()->create(['username' => 'ruhepol', 'password' => 'geheim1234']);

        $this->post(route('login'), ['username' => 'RuhePol', 'password' => 'geheim1234'])
            ->assertRedirect(route('sos'));

        $this->assertAuthenticatedAs($user);
    }

    public function test_wrong_password_is_rejected(): void
    {
        User::factory()->create(['username' => 'ruhepol', 'password' => 'geheim1234']);

        $this->post(route('login'), ['username' => 'ruhepol', 'password' => 'falsch'])
            ->assertSessionHasErrors(['username']);

        $this->assertGuest();
    }

    public function test_login_is_rate_limited(): void
    {
        User::factory()->create(['username' => 'ruhepol', 'password' => 'geheim1234']);

        for ($i = 0; $i < 5; $i++) {
            $this->post(route('login'), ['username' => 'ruhepol', 'password' => 'falsch']);
        }

        $this->post(route('login'), ['username' => 'ruhepol', 'password' => 'geheim1234'])
            ->assertSessionHasErrors(['username']);

        $this->assertGuest();
    }

    public function test_users_can_logout(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post(route('logout'))->assertRedirect(route('home'));

        $this->assertGuest();
    }

    public function test_signed_in_users_are_redirected_away_from_guest_pages(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get(route('login'))->assertRedirect();
    }
}
