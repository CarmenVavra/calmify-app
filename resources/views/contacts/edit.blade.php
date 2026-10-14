<x-layouts.app title="Kontakt bearbeiten">
    <x-screen title="Kontakt bearbeiten"
              :back="route('contacts.index')"
              back-label="Kontakte">

        <form method="POST" action="{{ route('contacts.update', $contact) }}" class="flex flex-col gap-6" novalidate>
            @csrf
            @method('PUT')

            @include('contacts._fields', ['contact' => $contact])

            <div class="mt-2 flex flex-col gap-3.5">
                <x-button type="submit">Speichern</x-button>
                <x-button :href="route('contacts.index')" variant="outline">Abbrechen</x-button>
            </div>
        </form>
    </x-screen>
</x-layouts.app>
