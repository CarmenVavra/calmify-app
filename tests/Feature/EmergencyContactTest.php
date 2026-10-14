<?php

namespace Tests\Feature;

use App\Models\EmergencyContact;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class EmergencyContactTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_to_login(): void
    {
        $this->get(route('contacts.index'))->assertRedirect(route('login'));
        $this->get(route('contacts.create'))->assertRedirect(route('login'));
        $this->post(route('contacts.store'), [])->assertRedirect(route('login'));
    }

    public function test_pages_render_for_users(): void
    {
        $user = User::factory()->create();
        $contact = EmergencyContact::factory()->for($user)->create(['name' => 'Lena']);

        $this->actingAs($user)->get(route('contacts.index'))->assertStatus(200)->assertSee('Lena');
        $this->actingAs($user)->get(route('contacts.create'))->assertStatus(200)->assertSee('Kontakt hinzufügen');
        $this->actingAs($user)->get(route('contacts.edit', $contact))->assertStatus(200)->assertSee('value="Lena"', false);
    }

    public function test_a_contact_can_be_stored_encrypted(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('contacts.store'), [
            'name' => '  Lena ',
            'relation' => 'Schwester',
            'phone_number' => '+49 170 0000001',
        ]);

        $response->assertRedirect(route('sos'));
        $response->assertSessionHas('status', 'Kontakt gespeichert.');

        $contact = $user->emergencyContacts()->sole();
        $this->assertSame('Lena', $contact->name);
        $this->assertSame('Schwester', $contact->relation);
        $this->assertSame('+49 170 0000001', $contact->phone_number);
        $this->assertSame('tel:+491700000001', $contact->telHref());

        $raw = DB::table('emergency_contacts')->where('id', $contact->id)->first();
        $this->assertNotSame('Lena', $raw->name);
        $this->assertNotSame('+49 170 0000001', $raw->phone_number);
        $this->assertStringNotContainsString('0000001', $raw->phone_number);
    }

    public function test_store_validates_input(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('contacts.store'), [
                'name' => '',
                'phone_number' => 'javascript:alert(1)',
            ])
            ->assertSessionHasErrors(['name', 'phone_number']);

        $this->actingAs($user)
            ->post(route('contacts.store'), [
                'name' => str_repeat('a', 61),
                'phone_number' => '0170 123',
            ])
            ->assertSessionHasErrors(['name'])
            ->assertSessionDoesntHaveErrors(['phone_number']);

        $this->assertDatabaseCount('emergency_contacts', 0);
    }

    public function test_relation_is_optional(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('contacts.store'), ['name' => 'Tom', 'relation' => '', 'phone_number' => '030 1234567'])
            ->assertSessionHasNoErrors();

        $this->assertNull($user->emergencyContacts()->sole()->relation);
    }

    public function test_a_contact_can_be_updated(): void
    {
        $user = User::factory()->create();
        $contact = EmergencyContact::factory()->for($user)->create();

        $this->actingAs($user)
            ->put(route('contacts.update', $contact), [
                'name' => 'Dr. Berger',
                'relation' => 'Therapeutin',
                'phone_number' => '+49 170 0000002',
            ])
            ->assertRedirect(route('contacts.index'));

        $this->assertSame('Dr. Berger', $contact->fresh()?->name);
    }

    public function test_a_contact_can_be_deleted(): void
    {
        $user = User::factory()->create();
        $contact = EmergencyContact::factory()->for($user)->create();

        $this->actingAs($user)
            ->delete(route('contacts.destroy', $contact))
            ->assertRedirect(route('contacts.index'));

        $this->assertModelMissing($contact);
    }

    public function test_users_cannot_touch_contacts_of_others(): void
    {
        $user = User::factory()->create();
        $foreign = EmergencyContact::factory()->create();

        $this->actingAs($user)->get(route('contacts.edit', $foreign))->assertForbidden();
        $this->actingAs($user)
            ->put(route('contacts.update', $foreign), ['name' => 'X', 'phone_number' => '0170 1234567'])
            ->assertForbidden();
        $this->actingAs($user)->delete(route('contacts.destroy', $foreign))->assertForbidden();

        $this->assertModelExists($foreign);
    }
}
