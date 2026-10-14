<x-layouts.app title="Anmelden">
    <x-screen title="Anmelden"
              subtitle="Mit deinem anonymen Konto siehst du deine Vertrauenspersonen."
              :back="route('sos')"
              back-label="SOS Kontakte">

        <form method="POST" action="{{ route('login') }}" class="flex flex-col gap-6" novalidate>
            @csrf

            <x-form.input name="username"
                          label="Benutzername"
                          autocomplete="username"
                          autocapitalize="none"
                          spellcheck="false"
                          maxlength="30"
                          required
                          autofocus />

            <x-form.input name="password"
                          label="Passwort"
                          type="password"
                          autocomplete="current-password"
                          required />

            <label class="flex min-h-12 cursor-pointer items-center gap-3 px-1 text-[17px] text-calm-text">
                <input type="checkbox" name="remember" value="1" @checked(old('remember', true))
                       class="h-6 w-6 cursor-pointer rounded-md border-calm-line bg-calm-surface accent-calm-accent focus-visible:outline-offset-2">
                Angemeldet bleiben
            </label>

            <div class="mt-2 flex flex-col gap-3.5">
                <x-button type="submit">Anmelden</x-button>
                <x-button :href="route('register')" variant="outline">Anonymes Konto erstellen</x-button>
            </div>
        </form>
    </x-screen>
</x-layouts.app>
