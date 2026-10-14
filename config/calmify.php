<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Country
    |--------------------------------------------------------------------------
    |
    | Decides which crisis services and emergency number the SOS screen shows.
    | The default comes from CALMIFY_COUNTRY in .env; every visitor can switch
    | the country on the settings page (stored in the "calmify_country" cookie).
    |
    */

    'default_country' => env('CALMIFY_COUNTRY', 'AT'),

    'country_cookie' => 'calmify_country',

    /*
    |--------------------------------------------------------------------------
    | Crisis services (24/7) and emergency number per country
    |--------------------------------------------------------------------------
    |
    | Add a country by adding a block here (key = ISO country code).
    | `tel` must be a dialable `tel:` URI.
    |
    */

    'countries' => [
        'AT' => [
            'label' => 'Österreich',
            'emergency_number' => '112',
            'crisis_services' => [
                [
                    'name' => 'TelefonSeelsorge',
                    'phone' => '142',
                    'note' => 'kostenlos',
                    'tel' => 'tel:142',
                ],
            ],
        ],
        'DE' => [
            'label' => 'Deutschland',
            'emergency_number' => '112',
            'crisis_services' => [
                [
                    'name' => 'TelefonSeelsorge',
                    'phone' => '0800 111 0 111',
                    'note' => 'kostenlos',
                    'tel' => 'tel:08001110111',
                ],
                [
                    'name' => 'TelefonSeelsorge',
                    'phone' => '0800 111 0 222',
                    'note' => 'kostenlos',
                    'tel' => 'tel:08001110222',
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Device preferences
    |--------------------------------------------------------------------------
    |
    | Choices offered on the settings page. They are stored in the browser's
    | localStorage only; values must match resources/js/settings.js.
    |
    */

    /*
    |--------------------------------------------------------------------------
    | Legal information (Impressum / Datenschutz)
    |--------------------------------------------------------------------------
    |
    | Shown on /impressum, /datenschutz and /ueber. Fill these in via .env
    | before going online; the bracketed defaults are visible placeholders.
    | `address` is optional in Austria (§ 25 MedienG: name + place of
    | residence), but required in Germany (§ 5 DDG: full postal address).
    |
    */

    'legal' => [
        'name' => env('CALMIFY_LEGAL_NAME', '[Vorname Nachname]'),
        'location' => env('CALMIFY_LEGAL_LOCATION', '[Wohnort], Österreich'),
        'address' => env('CALMIFY_LEGAL_ADDRESS'),
        'email' => env('CALMIFY_LEGAL_EMAIL', 'kontakt@example.com'),
        'hoster' => env('CALMIFY_LEGAL_HOSTER', '[Name und Sitz des Hosting-Anbieters]'),
        'log_retention_days' => (int) env('CALMIFY_LOG_RETENTION_DAYS', 14),
        'min_age' => 14,
        'updated_at' => 'Oktober 2026',
    ],

    'preferences' => [
        'theme' => [
            'legend' => 'Farbschema',
            'options' => ['salbei' => 'Salbei', 'nachtblau' => 'Nachtblau'],
        ],
        'rhythm' => [
            'legend' => 'Atemrhythmus',
            'hint' => 'Längeres Ausatmen beruhigt das Nervensystem.',
            'options' => ['4-6' => '4-6', '4-7-8' => '4-7-8', 'box' => 'Box 4-4-4-4'],
        ],
        'motion' => [
            'legend' => 'Bewegung',
            'options' => ['sanft' => 'Sanft', 'reduziert' => 'Reduziert'],
        ],
    ],

];
