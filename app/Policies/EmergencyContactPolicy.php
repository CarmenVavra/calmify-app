<?php

namespace App\Policies;

use App\Models\EmergencyContact;
use App\Models\User;

/**
 * Users may only ever touch their own trusted contacts.
 */
class EmergencyContactPolicy
{
    public function update(User $user, EmergencyContact $contact): bool
    {
        return $user->id === $contact->user_id;
    }

    public function delete(User $user, EmergencyContact $contact): bool
    {
        return $user->id === $contact->user_id;
    }
}
