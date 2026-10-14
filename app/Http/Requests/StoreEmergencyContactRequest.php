<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreEmergencyContactRequest extends FormRequest
{
    /**
     * Digits, spaces and the usual separators; optional leading "+".
     */
    public const PHONE_PATTERN = '/^\+?[0-9][0-9 ()\/.\-]{2,28}$/';

    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'name' => trim((string) $this->input('name')),
            'relation' => trim((string) $this->input('relation')) ?: null,
            'phone_number' => trim((string) $this->input('phone_number')),
        ]);
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:60'],
            'relation' => ['nullable', 'string', 'max:60'],
            'phone_number' => ['required', 'string', 'max:30', 'regex:'.self::PHONE_PATTERN],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'phone_number.regex' => 'Bitte gib eine gültige Telefonnummer ein, z. B. +49 170 1234567.',
        ];
    }
}
