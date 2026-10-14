<?php

namespace Tests\Feature;

use App\Models\EmergencyContact;
use App\Models\PanicLog;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class AccountExportTest extends TestCase
{
    use RefreshDatabase;

    public function test_users_can_download_all_their_data(): void
    {
        Carbon::setTestNow('2026-10-14 12:00:00');
        $user = User::factory()->withHealthDataConsent()->create(['username' => 'ruhepol']);
        EmergencyContact::factory()->for($user)->create([
            'name' => 'Lena',
            'relation' => 'Schwester',
            'phone_number' => '+43 660 0000001',
        ]);
        PanicLog::factory()->for($user)->create(['duration_minutes' => 4]);
        EmergencyContact::factory()->create(['name' => 'Fremde Person']);

        $response = $this->actingAs($user)->get(route('account.export'));

        $response->assertOk();
        $response->assertHeader('Content-Disposition', 'attachment; filename="calmify-daten-2026-10-14.json"');
        $response->assertJsonPath('account.username', 'ruhepol');
        $response->assertJsonPath('emergency_contacts.0.name', 'Lena');
        $response->assertJsonPath('emergency_contacts.0.phone_number', '+43 660 0000001');
        $response->assertJsonCount(1, 'emergency_contacts');
        $response->assertJsonPath('exercise_logs.0.duration_minutes', 4);
        $response->assertDontSee('Fremde Person');
        $response->assertDontSee('password');
    }

    public function test_settings_link_to_the_export(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get(route('settings'))->assertSee(route('account.export'));
    }

    public function test_guests_cannot_export(): void
    {
        $this->get(route('account.export'))->assertRedirect(route('login'));
    }
}
