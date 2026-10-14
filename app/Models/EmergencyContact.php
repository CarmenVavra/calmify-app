<?php

namespace App\Models;

use Database\Factories\EmergencyContactFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * A trusted person. Every personal field is stored encrypted.
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string|null $relation
 * @property string $phone_number
 */
class EmergencyContact extends Model
{
    /** @use HasFactory<EmergencyContactFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'relation',
        'phone_number',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'name' => 'encrypted',
            'relation' => 'encrypted',
            'phone_number' => 'encrypted',
        ];
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Dialable `tel:` link: keeps digits and a leading plus sign only.
     */
    public function telHref(): string
    {
        $number = trim($this->phone_number);
        $digits = preg_replace('/\D+/', '', $number) ?? '';

        return 'tel:'.(str_starts_with($number, '+') ? '+' : '').$digits;
    }
}
