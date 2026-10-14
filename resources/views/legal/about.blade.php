<x-layouts.app title="Über Calmify">
    <x-screen title="Über Calmify" subtitle="Eine ruhige Begleitung für schwere Momente.">

        <x-legal-section title="Wichtiger Hinweis" id="hinweis">
            <x-medical-notice />
        </x-legal-section>

        <x-legal-section title="Was Calmify ist" id="was">
            <p>
                Calmify verbindet einen sanften Atem-Taktgeber mit der 5-4-3-2-1-Übung, die deine Aufmerksamkeit Schritt für
                Schritt zurück zu deinen Sinnen lenkt. Über die SOS-Seite erreichst du deine Vertrauenspersonen und
                Krisendienste mit einem Tipp. Calmify ist kostenlos, werbefrei und funktioniert auch ohne Konto.
            </p>
        </x-legal-section>

        <x-legal-section title="Nutzungsbedingungen" id="nutzung">
            <ul>
                <li>Calmify ist kostenlos. Es besteht kein Anspruch darauf, dass die App jederzeit verfügbar ist; Funktionen können sich ändern oder eingestellt werden.</li>
                <li>Calmify ersetzt keine ärztliche oder psychotherapeutische Hilfe. Die Nummern der Krisendienste werden sorgfältig gepflegt – in akuter Gefahr wähle bitte immer direkt den Notruf.</li>
                <li>Ein Konto ist ab {{ $legal['min_age'] }} Jahren möglich. Halte dein Passwort geheim: Ohne E-Mail kann es nicht zurückgesetzt werden.</li>
                <li>Speichere nur Kontakte von Menschen, die damit einverstanden sind.</li>
                <li>Bitte nutze Calmify nicht missbräuchlich, etwa durch automatisierte Zugriffe oder Angriffe. In solchen Fällen kann ein Konto gesperrt oder gelöscht werden.</li>
                <li>Du kannst dein Konto jederzeit in den <a href="{{ route('settings') }}">Einstellungen</a> löschen.</li>
                <li>Wir haften nur für Vorsatz und grobe Fahrlässigkeit. Das gilt nicht für Personenschäden und nicht, soweit zwingendes Recht – etwa das Konsumentenschutzgesetz – etwas anderes vorsieht.</li>
                <li>Es gilt österreichisches Recht. Zwingende Verbraucherschutzvorschriften deines Wohnsitzstaates bleiben unberührt.</li>
            </ul>
        </x-legal-section>

        <x-legal-section title="Barrierefreiheit" id="barrierefreiheit">
            <p>
                Calmify soll auch in angespannten Momenten für alle gut bedienbar sein. Wir orientieren uns an den
                WCAG 2.2 (Stufe AA): gut lesbare Schrift in mindestens 14 px, große Tippflächen, vollständige Bedienung per
                Tastatur, Unterstützung für Screenreader, eine Option für reduzierte Bewegung und zwei ruhige Farbschemata.
            </p>
            <p>
                Eine formale Prüfung durch Dritte hat noch nicht stattgefunden. Wenn dir eine Barriere auffällt, schreib uns
                bitte – wir kümmern uns darum.
            </p>
        </x-legal-section>

        <x-legal-section title="Kontakt und Rückmeldung" id="kontakt">
            <p>
                Fragen, Ideen oder ein Fehler, etwa eine falsche Telefonnummer? Schreib an
                <a href="mailto:{{ $legal['email'] }}">{{ $legal['email'] }}</a>.
            </p>
            <p class="text-calm-muted">
                Bitte schick uns keine Gesundheitsinformationen per E-Mail. In einer Krise wende dich an die
                TelefonSeelsorge oder den Notruf – E-Mails werden nicht laufend gelesen.
            </p>
        </x-legal-section>
    </x-screen>
</x-layouts.app>
