<x-layouts.app title="Kontakt hinzufügen">
    <x-screen title="Kontakt hinzufügen"
              subtitle="Wen möchtest du im Notfall mit einem Tipp erreichen?"
              :back="route('sos')"
              back-label="SOS Kontakte">

        <form method="POST" action="{{ route('contacts.store') }}" class="flex flex-col gap-6" novalidate>
            @csrf

            @include('contacts._fields', ['contact' => null])

            <div class="mt-2 flex flex-col gap-3.5">
                <x-button type="submit">Speichern</x-button>
                <x-button :href="route('sos')" variant="outline">Abbrechen</x-button>
            </div>
        </form>
    </x-screen>
</x-layouts.app>
