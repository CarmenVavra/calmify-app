<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreHealthDataConsentRequest extends FormRequest
{
    /**
     * Errors land in their own bag so they show up next to the consent form.
     *
     * @var string
     */
    protected $errorBag = 'healthConsent';

    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /**
     * Explicit consent (Art. 9 (2) (a) GDPR): the box must be ticked actively.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'health_data_consent' => ['accepted'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'health_data_consent.accepted' => 'Bitte setze das Häkchen, wenn deine Übungen gespeichert werden sollen.',
        ];
    }
}
