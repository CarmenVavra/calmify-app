<?php

namespace App\Actions;

use App\Models\PanicLog;
use App\Models\User;

/**
 * Stores one completed grounding exercise in the anonymous panic log.
 */
class LogPanicEpisode
{
    /**
     * Upper bound for a single episode; longer values are clamped.
     */
    public const MAX_DURATION_MINUTES = 720;

    public function handle(User $user, int $durationMinutes): PanicLog
    {
        $durationMinutes = max(1, min(self::MAX_DURATION_MINUTES, $durationMinutes));

        return $user->panicLogs()->create([
            'triggered_at' => now()->subMinutes($durationMinutes),
            'duration_minutes' => $durationMinutes,
        ]);
    }
}
