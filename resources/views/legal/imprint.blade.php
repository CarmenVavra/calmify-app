<x-layouts.app title="Impressum">
    <x-screen title="Impressum" subtitle="Offenlegung gemäß § 25 Mediengesetz">

        <x-legal-section title="Medieninhaber und Herausgeber">
            <p>
                {{ $legal['name'] }}<br>
                {{ $legal['address'] ?: $legal['location'] }}
            </p>
        </x-legal-section>

        <x-legal-section title="Kontakt">
            <p>E-Mail: <a href="mailto:{{ $legal['email'] }}">{{ $legal['email'] }}</a></p>
            <p class="text-calm-muted">
                In einer Krise wende dich bitte an die TelefonSeelsorge oder den Notruf 112 – E-Mails werden nicht laufend gelesen.
            </p>
        </x-legal-section>

        <x-legal-section title="Grundlegende Richtung">
            <p>
                Calmify ist ein privates, nicht kommerzielles Projekt. Die App bietet Übungen zur Selbsthilfe in akuten
                Angstmomenten sowie einen schnellen Weg zu Vertrauenspersonen und Krisendiensten.
                Calmify ist kein Medizinprodukt – mehr dazu unter <a href="{{ route('legal.about') }}#hinweis">Über Calmify</a>.
            </p>
        </x-legal-section>

        <x-legal-section title="Haftung für Inhalte">
            <p>
                Die Inhalte werden mit Sorgfalt erstellt und gepflegt. Für ihre Richtigkeit, Vollständigkeit und Aktualität –
                auch der angegebenen Telefonnummern – kann dennoch keine Gewähr übernommen werden.
                Für Inhalte verlinkter fremder Websites sind ausschließlich deren Betreiber verantwortlich.
            </p>
        </x-legal-section>
    </x-screen>
</x-layouts.app>
