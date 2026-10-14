<?php

namespace App\Http\Requests;

use App\Models\EmergencyContact;

class UpdateEmergencyContactRequest extends StoreEmergencyContactRequest
{
    public function authorize(): bool
    {
        $contact = $this->route('contact');

        return $contact instanceof EmergencyContact
            && $this->user()?->can('update', $contact) === true;
    }
}
