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
                          hint="Mindestens 8 Zeichen. Ohne E-Mail gibt es kein Zurücksetzen: Vergisst du dein Passwort, sind Konto und Kontakte nicht mehr erreichbar." />

            <x-form.input name="password_confirmation"
                          label="Passwort wiederholen"
                          type="password"
                          autocomplete="new-password"
                          required />

            <x-form.checkbox name="health_data_consent">
                {{ __('consent.health_data') }}
                <span class="block pt-1 text-[15px] text-calm-muted">Freiwillig – ohne Häkchen funktioniert alles genauso, es wird nur nichts protokolliert.</span>
            </x-form.checkbox>

            <x-form.checkbox name="age_confirmed" required>
                Ich bin mindestens {{ $minAge }} Jahre alt.
            </x-form.checkbox>

            <p class="px-1 text-[15px] leading-[1.45] text-calm-muted">
                Es gelten die <a href="{{ route('legal.about') }}#nutzung" class="text-calm-text underline underline-offset-4">Nutzungsbedingungen</a>.
                Wie wir mit deinen Daten umgehen, steht in der <a href="{{ route('legal.privacy') }}" class="text-calm-text underline underline-offset-4">Datenschutzerklärung</a>.
            </p>

            <div class="mt-2 flex flex-col gap-3.5">
                <x-button type="submit">Konto erstellen</x-button>
                <x-button :href="route('login')" variant="outline">Ich habe schon ein Konto</x-button>
            </div>
        </form>
    </x-screen>
</x-layouts.app>
