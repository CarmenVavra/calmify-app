<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * Anonymous Calmify account: only a self-chosen username and a password.
 *
 * @property Carbon|null $health_data_consented_at
 */
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'username',
        'password',
    ];

    /**
     * New accounts start without consent to storing exercise logs.
     *
     * @var array<string, mixed>
     */
    protected $attributes = [
        'health_data_consented_at' => null,
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'health_data_consented_at' => 'datetime',
        ];
    }

    /**
     * Trusted people the user wants to reach with one tap.
     *
     * @return HasMany<EmergencyContact, $this>
     */
    public function emergencyContacts(): HasMany
    {
        return $this->hasMany(EmergencyContact::class);
    }

    /**
     * Completed grounding exercises.
     *
     * @return HasMany<PanicLog, $this>
     */
    public function panicLogs(): HasMany
    {
        return $this->hasMany(PanicLog::class);
    }

    /**
     * Exercise logs are health data and are only stored with explicit consent.
     */
    public function hasHealthDataConsent(): bool
    {
        return $this->health_data_consented_at !== null;
    }

    public function grantHealthDataConsent(): void
    {
        $this->forceFill(['health_data_consented_at' => now()])->save();
    }

    /**
     * Withdrawing consent also erases everything stored under it.
     */
    public function revokeHealthDataConsent(): void
    {
        DB::transaction(function (): void {
            $this->panicLogs()->delete();
            $this->forceFill(['health_data_consented_at' => null])->save();
        });
    }
}
