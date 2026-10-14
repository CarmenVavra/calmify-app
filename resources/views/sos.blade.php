<x-layouts.app title="SOS Kontakte">
    <x-screen title="SOS Kontakte" subtitle="Ein Tipp genügt. Du musst nichts erklären.">

        <div class="flex flex-col gap-3">
            <x-section-label id="trusted-label">Vertrauenspersonen</x-section-label>

            @if ($contacts->isNotEmpty())
                <ul role="list" aria-labelledby="trusted-label" class="flex flex-col gap-3">
                    @foreach ($contacts as $contact)
                        <li>
                            <x-contact-card :href="$contact->telHref()"
                                            :name="$contact->name"
                                            :detail="$contact->relation ?: $contact->phone_number" />
                        </li>
                    @endforeach
                </ul>
            @endif

            <a href="{{ auth()->check() ? route('contacts.create') : route('login') }}"
               class="grid min-h-[60px] place-items-center rounded-[24px] border-[1.5px] border-dashed border-calm-line bg-transparent px-5 text-center text-[17px] text-calm-muted no-underline focus-visible:outline-offset-[3px]">
                + Kontakt hinzufügen
            </a>

            @auth
                @if ($contacts->isNotEmpty())
                    <a href="{{ route('contacts.index') }}" class="self-center px-3 py-3 text-[15px] text-calm-muted underline underline-offset-4">
                        Kontakte bearbeiten
                    </a>
                @endif
            @else
                <p class="px-1 text-[15px] leading-[1.45] text-calm-muted">
                    Eigene Vertrauenspersonen speicherst du mit einem anonymen Konto – ohne Namen, ohne E-Mail.
                </p>
            @endauth
        </div>

        <div class="flex flex-col gap-3">
            <x-section-label id="services-label">Krisendienste · 24/7</x-section-label>

            <ul role="list" aria-labelledby="services-label" class="flex flex-col gap-3">
                @foreach ($services as $service)
                    <li>
                        <x-contact-card variant="outline"
                                        :href="$service['tel']"
                                        :name="$service['name']"
                                        :detail="$service['phone'].' · '.$service['note']" />
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="mt-auto flex flex-col items-center gap-4 text-center">
            <p class="text-[15px] leading-normal text-calm-muted">
                Bei akuter Gefahr:
                <a href="tel:{{ $emergencyNumber }}" class="font-semibold text-calm-text">Notruf {{ $emergencyNumber }}</a>
            </p>
            <x-medical-notice collapsible :emergency-number="$emergencyNumber" />
            <a href="{{ route('settings') }}" class="px-3 py-3 text-[15px] text-calm-muted underline underline-offset-4">
                Einstellungen &amp; Konto
            </a>
        </div>
    </x-screen>
</x-layouts.app>
