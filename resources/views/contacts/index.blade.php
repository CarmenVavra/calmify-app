<x-layouts.app title="Kontakte bearbeiten">
    <x-screen title="Kontakte bearbeiten"
              subtitle="Deine Kontakte werden verschlüsselt gespeichert."
              :back="route('sos')"
              back-label="SOS Kontakte">

        @if ($contacts->isEmpty())
            <p class="px-1 text-[17px] leading-[1.45] text-calm-muted">Du hast noch keine Vertrauenspersonen gespeichert.</p>
        @else
            <ul role="list" class="flex flex-col gap-3">
                @foreach ($contacts as $contact)
                    <li class="flex flex-col gap-4 rounded-[24px] bg-calm-surface px-5 py-4">
                        <div class="flex min-w-0 flex-col gap-[3px]">
                            <span class="break-words text-[19px] font-medium">{{ $contact->name }}</span>
                            <span class="break-words text-[15px] text-calm-muted">
                                @if ($contact->relation){{ $contact->relation }} · @endif{{ $contact->phone_number }}
                            </span>
                        </div>
                        <div class="flex gap-3">
                            <a href="{{ route('contacts.edit', $contact) }}"
                               class="grid min-h-12 flex-1 place-items-center rounded-full bg-calm-btn px-4 text-[16px] font-medium text-calm-text no-underline hover:text-calm-text focus-visible:outline-offset-[3px]">
                                Bearbeiten<span class="sr-only">: {{ $contact->name }}</span>
                            </a>
                            <form method="POST"
                                  action="{{ route('contacts.destroy', $contact) }}"
                                  class="flex flex-1"
                                  x-data
                                  x-on:submit="if (! confirm(@js('Kontakt „'.$contact->name.'“ wirklich löschen?'))) $event.preventDefault()">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="min-h-12 flex-1 cursor-pointer rounded-full border-[1.5px] border-calm-line bg-transparent px-4 text-[16px] text-calm-text focus-visible:outline-offset-[3px]">
                                    Löschen<span class="sr-only">: {{ $contact->name }}</span>
                                </button>
                            </form>
                        </div>
                    </li>
                @endforeach
            </ul>
        @endif

        <x-button :href="route('contacts.create')" variant="outline">+ Kontakt hinzufügen</x-button>
    </x-screen>
</x-layouts.app>
