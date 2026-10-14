<?php

namespace App\Services;

use Illuminate\Http\Request;

/**
 * Resolves the visitor's country and the matching crisis numbers.
 *
 * Order: the "calmify_country" cookie (chosen on the settings page), then
 * CALMIFY_COUNTRY from .env, then the first configured country.
 */
class CrisisDirectory
{
    /**
     * @return array<string, string> country code => label
     */
    public function countries(): array
    {
        return collect($this->config())->map(fn (array $country): string => $country['label'])->all();
    }

    public function countryFor(Request $request): string
    {
        $chosen = strtoupper((string) $request->cookie(config('calmify.country_cookie')));

        if ($this->isSupported($chosen)) {
            return $chosen;
        }

        $default = strtoupper((string) config('calmify.default_country'));

        return $this->isSupported($default) ? $default : (string) array_key_first($this->config());
    }

    /**
     * @return list<array{name: string, phone: string, note: string, tel: string}>
     */
    public function servicesFor(string $country): array
    {
        return $this->config()[$country]['crisis_services'];
    }

    public function emergencyNumberFor(string $country): string
    {
        return $this->config()[$country]['emergency_number'];
    }

    public function isSupported(string $country): bool
    {
        return array_key_exists($country, $this->config());
    }

    /**
     * @return array<string, array{label: string, emergency_number: string, crisis_services: list<array{name: string, phone: string, note: string, tel: string}>}>
     */
    private function config(): array
    {
        return config('calmify.countries');
    }
}
