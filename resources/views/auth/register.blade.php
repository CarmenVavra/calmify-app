<x-layouts.app title="Anonymes Konto erstellen">
    <x-screen title="Anonymes Konto"
              subtitle="Kein echter Name, keine E-Mail. Nur ein Benutzername, den du dir ausdenkst."
              :back="route('login')"
              back-label="Anmelden">

        <form method="POST" action="{{ route('register') }}" class="flex flex-col gap-6" novalidate>
            @csrf

            <x-form.input name="username"
                          label="Benutzername"
                          autocomplete="username"
                          autocapitalize="none"
                          spellcheck="false"
                          maxlength="30"
                          required
                          autofocus
                          hint="3–30 Zeichen: Buchstaben, Zahlen, - und _. Bitte nicht deinen echten Namen." />

            <x-form.input name="password"
                          label="Passwort"
                          type="password"
                          autocomplete="new-password"
                          required
                          hint="Mindestens 8 Zeichen. Ohne E-Mail können wir es nicht zurücksetzen – merk es dir gut." />

            <x-form.input name="password_confirmation"
                          label="Passwort wiederholen"
                          type="password"
                          autocomplete="new-password"
                          required />

            <div class="mt-2 flex flex-col gap-3.5">
                <x-button type="submit">Konto erstellen</x-button>
                <x-button :href="route('login')" variant="outline">Ich habe schon ein Konto</x-button>
            </div>
        </form>
    </x-screen>
</x-layouts.app>
