<?php

namespace App\Actions;

use App\Models\PanicLog;
use App\Models\User;

/**
 * Stores one completed grounding exercise in the anonymous panic log,
 * but only for users who consented to storing health data (Art. 9 GDPR).
 */
class LogPanicEpisode
{
    /**
     * Upper bound for a single episode; longer values are clamped.
     */
    public const MAX_DURATION_MINUTES = 720;

    public function handle(User $user, int $durationMinutes): ?PanicLog
    {
        if (! $user->hasHealthDataConsent()) {
            return null;
        }

        $durationMinutes = max(1, min(self::MAX_DURATION_MINUTES, $durationMinutes));

        return $user->panicLogs()->create([
            'triggered_at' => now()->subMinutes($durationMinutes),
            'duration_minutes' => $durationMinutes,
        ]);
    }
}
