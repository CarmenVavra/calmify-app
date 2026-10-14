<?php

namespace Tests\Feature;

use App\Actions\LogPanicEpisode;
use App\Livewire\GroundingExercise;
use App\Models\PanicLog;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Livewire\Livewire;
use Tests\TestCase;

class GroundingExerciseTest extends TestCase
{
    use RefreshDatabase;

    public function test_completion_is_logged_for_signed_in_users(): void
    {
        Carbon::setTestNow('2026-10-14 12:00:00');
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(GroundingExercise::class)
            ->call('complete', 3)
            ->assertHasNoErrors();

        $log = PanicLog::sole();
        $this->assertSame($user->id, $log->user_id);
        $this->assertSame(3, $log->duration_minutes);
        $this->assertTrue($log->triggered_at->equalTo(Carbon::parse('2026-10-14 11:57:00')));
    }

    public function test_guests_complete_anonymously_without_a_log(): void
    {
        Livewire::test(GroundingExercise::class)
            ->call('complete', 2)
            ->assertHasNoErrors();

        $this->assertDatabaseCount('panic_logs', 0);
    }

    public function test_duration_is_clamped_to_a_sensible_range(): void
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(GroundingExercise::class)
            ->call('complete', 0)
            ->call('complete', 99999);

        $this->assertEqualsCanonicalizing(
            [1, LogPanicEpisode::MAX_DURATION_MINUTES],
            PanicLog::pluck('duration_minutes')->all(),
        );
    }

    public function test_non_numeric_duration_is_rejected(): void
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(GroundingExercise::class)
            ->call('complete', 'drop table users')
            ->assertHasErrors(['duration_minutes' => 'integer']);

        $this->assertDatabaseCount('panic_logs', 0);
    }
}
