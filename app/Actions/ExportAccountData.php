<?php

namespace App\Actions;

use App\Models\EmergencyContact;
use App\Models\PanicLog;
use App\Models\User;

/**
 * Collects everything Calmify stores about an account (Art. 15 and 20 GDPR).
 */
class ExportAccountData
{
    /**
     * @return array<string, mixed>
     */
    public function handle(User $user): array
    {
        $user->load([
            'emergencyContacts' => fn ($query) => $query->orderBy('id'),
            'panicLogs' => fn ($query) => $query->orderBy('triggered_at'),
        ]);

        return [
            'exported_at' => now()->toIso8601String(),
            'account' => [
                'username' => $user->username,
                'created_at' => $user->created_at?->toIso8601String(),
                'health_data_consented_at' => $user->health_data_consented_at?->toIso8601String(),
            ],
            'emergency_contacts' => $user->emergencyContacts->map(fn (EmergencyContact $contact) => [
                'name' => $contact->name,
                'relation' => $contact->relation,
                'phone_number' => $contact->phone_number,
                'created_at' => $contact->created_at?->toIso8601String(),
            ])->all(),
            'exercise_logs' => $user->panicLogs->map(fn (PanicLog $log) => [
                'triggered_at' => $log->triggered_at->toIso8601String(),
                'duration_minutes' => $log->duration_minutes,
            ])->all(),
        ];
    }
}
