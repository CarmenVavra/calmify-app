<x-layouts.app title="Einstellungen">
    <x-screen title="Einstellungen"
              subtitle="Diese Einstellungen bleiben nur auf diesem Gerät."
              :back="route('sos')"
              back-label="SOS Kontakte">

        {{-- Country for the SOS numbers (cookie, read by the server) --}}
        <fieldset x-data="countryPicker(@js($country), @js($countryCookie))" class="flex flex-col gap-3">
            <legend class="mb-3 px-1 text-[14px] uppercase tracking-[.14em] text-calm-muted">Land</legend>
            <div class="flex flex-wrap gap-3">
                @foreach ($countries as $code => $label)
                    <label class="cursor-pointer">
                        <input type="radio" name="country" value="{{ $code }}" x-model="country" @checked($code === $country) class="peer sr-only">
                        <span class="flex min-h-12 items-center rounded-full border-[1.5px] border-calm-line px-5 text-[17px] text-calm-text peer-checked:border-transparent peer-checked:bg-calm-btn peer-checked:font-medium peer-focus-visible:outline peer-focus-visible:outline-[3px] peer-focus-visible:outline-offset-4 peer-focus-visible:outline-calm-accent">
                            {{ $label }}
                        </span>
                    </label>
                @endforeach
            </div>
            <p class="px-1 text-[15px] leading-[1.45] text-calm-muted">Bestimmt die Krisendienste und den Notruf auf der SOS-Seite.</p>
        </fieldset>

        {{-- Device preferences (localStorage via Alpine `settingsForm`) --}}
        <div x-data="settingsForm" class="flex flex-col gap-7">
            @foreach ($preferences as $key => $preference)
                <fieldset class="flex flex-col gap-3">
                    <legend class="mb-3 px-1 text-[14px] uppercase tracking-[.14em] text-calm-muted">{{ $preference['legend'] }}</legend>
                    <div class="flex flex-wrap gap-3">
                        @foreach ($preference['options'] as $value => $label)
                            <label class="cursor-pointer">
                                <input type="radio" name="{{ $key }}" value="{{ $value }}" x-model="settings.{{ $key }}" class="peer sr-only">
                                <span class="flex min-h-12 items-center rounded-full border-[1.5px] border-calm-line px-5 text-[17px] text-calm-text peer-checked:border-transparent peer-checked:bg-calm-btn peer-checked:font-medium peer-focus-visible:outline peer-focus-visible:outline-[3px] peer-focus-visible:outline-offset-4 peer-focus-visible:outline-calm-accent">
                                    {{ $label }}
                                </span>
                            </label>
                        @endforeach
                    </div>
                    @isset($preference['hint'])
                        <p class="px-1 text-[15px] leading-[1.45] text-calm-muted">{{ $preference['hint'] }}</p>
                    @endisset
                </fieldset>
            @endforeach

            <label class="flex min-h-[60px] cursor-pointer items-center justify-between gap-4 rounded-[24px] bg-calm-surface py-2 pl-5 pr-3">
                <span class="text-[17px] text-calm-text">Vibration beim Tippen</span>
                <input type="checkbox" role="switch" x-model="settings.haptics" class="peer sr-only">
                <span aria-hidden="true"
                      class="grid h-11 min-w-[72px] place-items-center rounded-full border-[1.5px] border-calm-line px-3 text-[16px] peer-checked:border-transparent peer-checked:bg-calm-btn peer-focus-visible:outline peer-focus-visible:outline-[3px] peer-focus-visible:outline-offset-4 peer-focus-visible:outline-calm-accent"
                      x-text="settings.haptics ? 'An' : 'Aus'">An</span>
            </label>
        </div>

        {{-- Anonymous account --}}
        <div class="flex flex-col gap-3">
            <x-section-label>Konto</x-section-label>

            @if ($user)
                <div class="flex flex-col gap-1 rounded-[24px] bg-calm-surface px-5 py-4">
                    <p class="text-[17px]">Angemeldet als <span class="font-medium">{{ $user->username }}</span></p>
                    <p class="text-[15px] text-calm-muted">Abgeschlossene Übungen: {{ $completedExercises }}</p>
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-button type="submit" variant="outline">Abmelden</x-button>
                </form>

                <details class="group mt-2 rounded-[24px] border-[1.5px] border-calm-line px-5 py-1" @if ($errors->deleteAccount->isNotEmpty()) open @endif>
                    <summary class="flex min-h-12 cursor-pointer list-none items-center justify-between text-[17px] text-calm-text">
                        Konto löschen
                        <span aria-hidden="true" class="text-calm-muted transition-transform group-open:rotate-90">›</span>
                    </summary>
                    <form method="POST"
                          action="{{ route('account.destroy') }}"
                          class="flex flex-col gap-5 pb-4 pt-2"
                          x-data
                          x-on:submit="if (! confirm('Konto, Kontakte und Protokolle endgültig löschen?')) $event.preventDefault()"
                          novalidate>
                        @csrf
                        @method('DELETE')
                        <p class="text-[15px] leading-[1.45] text-calm-muted">
                            Dein Konto, alle Vertrauenspersonen und alle Protokolle werden endgültig gelöscht.
                        </p>
                        <x-form.input name="password"
                                      label="Passwort zur Bestätigung"
                                      type="password"
                                      autocomplete="current-password"
                                      bag="deleteAccount"
                                      required />
                        <x-button type="submit" variant="danger">Konto endgültig löschen</x-button>
                    </form>
                </details>
            @else
                <p class="px-1 text-[17px] leading-[1.45] text-calm-muted">
                    Ohne Konto bleibt alles auf diesem Gerät. Mit einem anonymen Konto kannst du Vertrauenspersonen speichern.
                </p>
                <x-button :href="route('login')">Anmelden</x-button>
                <x-button :href="route('register')" variant="outline">Anonymes Konto erstellen</x-button>
            @endif
        </div>
    </x-screen>
</x-layouts.app>
