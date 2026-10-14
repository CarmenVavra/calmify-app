<?php

namespace Tests\Feature;

use App\Models\EmergencyContact;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SosPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_see_austrian_crisis_services_by_default(): void
    {
        config(['calmify.default_country' => 'AT']);

        $response = $this->get(route('sos'));

        $response->assertStatus(200);
        $response->assertSee('SOS Kontakte');
        $response->assertSee('Ein Tipp genügt. Du musst nichts erklären.');
        $response->assertSee('TelefonSeelsorge');
        $response->assertSee('href="tel:142"', false);
        $response->assertDontSee('href="tel:08001110111"', false);
        $response->assertSee('href="tel:112"', false);
        $response->assertSee('Notruf 112');
        $response->assertSee(route('login'));
    }

    public function test_country_cookie_switches_to_german_numbers(): void
    {
        $response = $this->withUnencryptedCookie('calmify_country', 'DE')->get(route('sos'));

        $response->assertSee('href="tel:08001110111"', false);
        $response->assertSee('href="tel:08001110222"', false);
        $response->assertDontSee('href="tel:142"', false);
        $response->assertSee('href="tel:112"', false);
    }

    public function test_env_default_country_is_used_without_cookie(): void
    {
        config(['calmify.default_country' => 'DE']);

        $this->get(route('sos'))->assertSee('href="tel:08001110111"', false);
    }

    public function test_unknown_country_cookie_falls_back_to_default(): void
    {
        config(['calmify.default_country' => 'AT']);

        $this->withUnencryptedCookie('calmify_country', "XX' OR 1=1")
            ->get(route('sos'))
            ->assertStatus(200)
            ->assertSee('href="tel:142"', false);
    }

    public function test_users_see_only_their_own_contacts(): void
    {
        $user = User::factory()->create();
        EmergencyContact::factory()->for($user)->create([
            'name' => 'Lena',
            'relation' => 'Schwester',
            'phone_number' => '+49 170 0000001',
        ]);
        EmergencyContact::factory()->create(['name' => 'Fremde Person']);

        $response = $this->actingAs($user)->get(route('sos'));

        $response->assertStatus(200);
        $response->assertSee('Lena');
        $response->assertSee('Schwester');
        $response->assertSee('href="tel:+491700000001"', false);
        $response->assertDontSee('Fremde Person');
        $response->assertSee(route('contacts.create'));
        $response->assertSee(route('contacts.index'));
    }

    public function test_contact_names_are_escaped(): void
    {
        $user = User::factory()->create();
        EmergencyContact::factory()->for($user)->create(['name' => '<script>alert(1)</script>']);

        $response = $this->actingAs($user)->get(route('sos'));

        $response->assertDontSee('<script>alert(1)</script>', false);
        $response->assertSee('&lt;script&gt;alert(1)&lt;/script&gt;', false);
    }
}
