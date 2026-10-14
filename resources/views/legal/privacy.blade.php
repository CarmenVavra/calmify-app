<x-layouts.app title="Datenschutz">
    <x-screen title="Datenschutz" subtitle="So wenig Daten wie möglich – und nichts davon für Werbung.">

        <x-legal-section title="Kurz gesagt" id="kurz">
            <ul>
                <li>Ohne Konto speichert Calmify nichts über dich. Deine Einstellungen bleiben auf deinem Gerät.</li>
                <li>Kein Tracking, keine Werbung, keine Analyse-Tools, keine Inhalte von Drittanbietern – auch die Schriften kommen von unserem eigenen Server.</li>
                <li>Ein Konto ist anonym: Benutzername und Passwort genügen, keine E-Mail, kein echter Name.</li>
                <li>Deine Übungen werden nur gespeichert, wenn du ausdrücklich einwilligst.</li>
            </ul>
        </x-legal-section>

        <x-legal-section title="Verantwortlich" id="verantwortlich">
            <p>
                {{ $legal['name'] }}<br>
                {{ $legal['address'] ?: $legal['location'] }}<br>
                E-Mail: <a href="mailto:{{ $legal['email'] }}">{{ $legal['email'] }}</a>
            </p>
        </x-legal-section>

        <x-legal-section title="Hosting und Server-Protokolle" id="hosting">
            <p>
                Calmify wird bei {{ $legal['hoster'] }} betrieben. Bei jedem Aufruf verarbeitet der Server technisch notwendige
                Daten: IP-Adresse, Datum und Uhrzeit, die aufgerufene Adresse und die Kennung deines Browsers.
            </p>
            <p>
                Zweck ist ein sicherer und stabiler Betrieb, etwa die Abwehr von Angriffen. Rechtsgrundlage ist unser
                berechtigtes Interesse (Art. 6 Abs. 1 lit. f DSGVO). Die Protokolle werden nach {{ $legal['log_retention_days'] }} Tagen gelöscht.
                Fehlgeschlagene Anmeldeversuche werden kurz gezählt, um das Erraten von Passwörtern zu verhindern.
            </p>
            <p>
                Der Hosting-Anbieter verarbeitet die Daten ausschließlich in unserem Auftrag (Art. 28 DSGVO) und innerhalb der EU.
            </p>
        </x-legal-section>

        <x-legal-section title="Anonymes Konto" id="konto">
            <p>
                Gespeichert werden dein Benutzername, dein Passwort (nur als sicherer Hash, niemals im Klartext) und der Zeitpunkt
                der Erstellung. Rechtsgrundlage ist die Nutzung des Kontos (Art. 6 Abs. 1 lit. b DSGVO). Die Daten bleiben
                gespeichert, bis du dein Konto löschst. Bitte wähle einen Benutzernamen, der dich nicht erkennbar macht.
            </p>
            <p>Ein Konto ist ab {{ $legal['min_age'] }} Jahren möglich.</p>
        </x-legal-section>

        <x-legal-section title="Vertrauenspersonen" id="kontakte">
            <p>
                Name, Beziehung und Telefonnummer deiner Vertrauenspersonen werden verschlüsselt gespeichert und nur dir angezeigt.
                Für diese Personen ist die Rechtsgrundlage dein berechtigtes Interesse, sie in einer Krise schnell zu erreichen
                (Art. 6 Abs. 1 lit. f DSGVO). Bitte sag ihnen Bescheid, dass du ihre Nummer in Calmify gespeichert hast.
            </p>
            <p>
                Tippst du auf einen Kontakt, öffnet sich die Telefon-App deines Geräts. Das Gespräch läuft über deinen
                Mobilfunkanbieter – Calmify erfährt davon nichts.
            </p>
        </x-legal-section>

        <x-legal-section title="Übungsprotokolle (Gesundheitsdaten)" id="gesundheitsdaten">
            <p>
                Wenn du es möchtest, speichert Calmify Zeitpunkt und Dauer deiner abgeschlossenen Übungen in deinem Konto, damit
                du sehen kannst, wie viele Übungen du schon geschafft hast. Diese Angaben können Rückschlüsse auf deine
                Gesundheit zulassen. Sie werden deshalb nur mit deiner ausdrücklichen Einwilligung gespeichert
                (Art. 9 Abs. 2 lit. a und Art. 6 Abs. 1 lit. a DSGVO).
            </p>
            <p>
                Die Einwilligung ist freiwillig. Du kannst sie jederzeit in den
                <a href="{{ route('settings') }}">Einstellungen</a> widerrufen; alle Protokolle werden dann sofort gelöscht.
                Der Widerruf gilt für die Zukunft. Ohne Konto oder ohne Einwilligung wird keine Übung gespeichert.
            </p>
        </x-legal-section>

        <x-legal-section title="Cookies und Speicher auf deinem Gerät" id="cookies">
            <p>Calmify verwendet nur, was für die App nötig ist oder was du selbst einstellst:</p>
            <ul>
                <li><strong>{{ $sessionCookie }}</strong> – deine Sitzung (Anmeldung, Sicherheit), verschlüsselt. Läuft nach {{ $sessionLifetime }} Minuten ohne Aktivität ab.</li>
                <li><strong>XSRF-TOKEN</strong> – schützt Formulare vor Missbrauch durch fremde Websites. Gleiche Laufzeit wie die Sitzung.</li>
                <li><strong>remember_web_…</strong> – nur mit Konto: hält dich angemeldet, bis du dich abmeldest.</li>
                <li><strong>{{ $countryCookie }}</strong> – nur wenn du in den Einstellungen ein Land wählst: welche Krisendienste angezeigt werden. Ein Jahr gültig.</li>
                <li><strong>Lokaler Speicher „calmify.settings“</strong> – Farbschema, Atemrhythmus, Bewegung und Vibration. Verlässt dein Gerät nie.</li>
                <li><strong>Offline-Speicher</strong> – Startseite, diese Rechtstexte und die Programmdateien, damit die Übung auch ohne Internet startet. Keine persönlichen Daten.</li>
            </ul>
            <p>
                Diese Speicherungen sind unbedingt erforderlich oder von dir ausdrücklich gewünscht
                (§ 165 Abs. 3 TKG 2021 bzw. § 25 Abs. 2 TDDDG). Deshalb gibt es kein Cookie-Banner.
            </p>
        </x-legal-section>

        <x-legal-section title="Weitergabe" id="weitergabe">
            <p>
                Wir verkaufen keine Daten und geben sie nicht weiter. Außer dem Hosting-Anbieter als Auftragsverarbeiter
                erhält niemand Zugriff. Es findet keine Übermittlung in Länder außerhalb der EU bzw. des EWR statt.
            </p>
        </x-legal-section>

        <x-legal-section title="Sicherheit" id="sicherheit">
            <p>
                Verbindungen sind per HTTPS verschlüsselt. Passwörter werden nur als Hash gespeichert, Vertrauenspersonen und
                Sitzungen verschlüsselt, und Anmeldeversuche sind begrenzt.
            </p>
        </x-legal-section>

        <x-legal-section title="Deine Rechte" id="rechte">
            <p>
                Du hast das Recht auf Auskunft (Art. 15 DSGVO), Berichtigung (Art. 16), Löschung (Art. 17), Einschränkung der
                Verarbeitung (Art. 18), Datenübertragbarkeit (Art. 20) und Widerspruch (Art. 21) sowie das Recht, eine
                Einwilligung jederzeit zu widerrufen (Art. 7 Abs. 3).
            </p>
            <p>Das meiste kannst du direkt in den <a href="{{ route('settings') }}">Einstellungen</a> erledigen:</p>
            <ul>
                <li>alle gespeicherten Daten herunterladen,</li>
                <li>Vertrauenspersonen bearbeiten oder löschen,</li>
                <li>die Einwilligung für Übungsprotokolle widerrufen,</li>
                <li>dein Konto mit allen Daten endgültig löschen.</li>
            </ul>
            <p>
                Da wir keine E-Mail-Adresse von dir kennen, können wir Anfragen per E-Mail nur einem Konto zuordnen, wenn du
                nachweisen kannst, dass es deines ist. Am einfachsten sind deshalb die Funktionen in den Einstellungen.
            </p>
            <p>
                Du kannst dich außerdem bei einer Aufsichtsbehörde beschweren, in Österreich bei der
                Österreichischen Datenschutzbehörde, Barichgasse 40–42, 1030 Wien,
                <a href="https://www.dsb.gv.at" rel="noopener">www.dsb.gv.at</a>.
            </p>
        </x-legal-section>

        <p class="px-1 text-[15px] text-calm-muted">Stand: {{ $legal['updated_at'] }}</p>
    </x-screen>
</x-layouts.app>
