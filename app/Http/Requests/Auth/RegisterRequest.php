<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Usernames are case-insensitive and stored in lower case.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'username' => mb_strtolower(trim((string) $this->input('username'))),
        ]);
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'username' => ['required', 'string', 'alpha_dash:ascii', 'min:3', 'max:30', 'unique:users,username'],
            'password' => ['required', 'string', 'confirmed', Password::min(8)],
            'age_confirmed' => ['accepted'],
            // Optional and unticked by default: storing exercise logs is health data.
            'health_data_consent' => ['nullable', 'boolean'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'age_confirmed.accepted' => 'Calmify-Konten sind ab '.config('calmify.legal.min_age').' Jahren möglich. Bitte bestätige dein Alter.',
        ];
    }
}
