<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines (German)
    |--------------------------------------------------------------------------
    |
    | Only the rules used by Calmify are translated; everything else falls
    | back to the English defaults (APP_FALLBACK_LOCALE).
    |
    */

    'alpha_dash' => ':Attribute darf nur Buchstaben, Zahlen, Binde- und Unterstriche enthalten.',
    'boolean' => ':Attribute muss wahr oder falsch sein.',
    'confirmed' => ':Attribute und Wiederholung stimmen nicht überein.',
    'current_password' => 'Das Passwort ist nicht richtig.',
    'integer' => ':Attribute muss eine ganze Zahl sein.',
    'max' => [
        'numeric' => ':Attribute darf nicht größer als :max sein.',
        'string' => ':Attribute darf höchstens :max Zeichen haben.',
    ],
    'min' => [
        'numeric' => ':Attribute muss mindestens :min sein.',
        'string' => ':Attribute muss mindestens :min Zeichen haben.',
    ],
    'password' => [
        'letters' => ':Attribute muss mindestens einen Buchstaben enthalten.',
        'mixed' => ':Attribute muss Groß- und Kleinbuchstaben enthalten.',
        'numbers' => ':Attribute muss mindestens eine Zahl enthalten.',
        'symbols' => ':Attribute muss mindestens ein Sonderzeichen enthalten.',
        'uncompromised' => ':Attribute ist in einem Datenleck aufgetaucht. Bitte wähle ein anderes.',
    ],
    'regex' => 'Das Format von :attribute ist ungültig.',
    'required' => 'Bitte fülle „:attribute“ aus.',
    'string' => ':Attribute muss ein Text sein.',
    'unique' => 'Dieser :attribute ist schon vergeben.',

    'attributes' => [
        'username' => 'Benutzername',
        'password' => 'Passwort',
        'name' => 'Name',
        'relation' => 'Beziehung',
        'phone_number' => 'Telefonnummer',
        'duration_minutes' => 'Dauer',
    ],

];
