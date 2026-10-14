# Profi-Tipp für Laravel-Entwickler: "Laravel Boost MCP"

Um Claude Code noch mächtiger im Umgang mit Ihrer Datenbank zu machen, empfiehlt sich die Installation des Open-Source-Pakets `laravel/boost` via Composer im Projekt:

```bash
composer require laravel/boost --dev
```

## Dieses Paket registriert sich als sogenannter Model Context Protocol (MCP) Server. Dadurch kann Claude Code direkt mit den Internals Ihrer Laravel-App interagieren. Claude kann dann

- Live Ihre echte lokale Datenbank-Struktur abfragen (ohne die Dateien lesen zu müssen).
- Artisan Tinker-Befehle im Hintergrund ausführen, um Daten direkt zu prüfen.

## Server start and stop script

- Mach im Projektordner eine start.bat, um den Server zu starten
- Mach im Projektordner eine stop.bat, um den Server zu soppen

## Online stellen – Checkliste

### Rechtliches

- [ ] In der `.env` die Angaben für Impressum und Datenschutz eintragen (`CALMIFY_LEGAL_NAME`, `CALMIFY_LEGAL_LOCATION`, `CALMIFY_LEGAL_EMAIL`, `CALMIFY_LEGAL_HOSTER`, `CALMIFY_LOG_RETENTION_DAYS`). Solange dort `[…]`-Platzhalter stehen, sind sie auf `/impressum` und `/datenschutz` sichtbar.
- [ ] Texte unter `resources/views/legal/` prüfen, idealerweise von einer Fachperson gegenlesen lassen (z. B. WKO-Muster, Datenschutzberatung).
- [ ] **Betrieb aus Deutschland:** `CALMIFY_LEGAL_ADDRESS` mit voller Anschrift setzen (§ 5 DDG), im Impressum die Überschrift „Offenlegung gemäß § 25 Mediengesetz“ durch „Angaben gemäß § 5 DDG“ ersetzen und in der Datenschutzerklärung die zuständige Landesdatenschutzbehörde statt der österreichischen DSB nennen.
- [ ] Mit dem Hosting-Anbieter einen Auftragsverarbeitungsvertrag (AVV, Art. 28 DSGVO) abschließen; Server-Standort in der EU.
- [ ] Prüfen, ob eine Datenschutz-Folgenabschätzung (Art. 35 DSGVO) nötig ist – Übungsprotokolle sind Gesundheitsdaten.
- [ ] Markenrecherche für den Namen „Calmify“ (EUIPO / TMview).
- [ ] Notrufnummern und Krisendienste in `config/calmify.php` regelmäßig prüfen.

### Technik

- [ ] `.env`: `APP_ENV=production`, `APP_DEBUG=false`, `APP_URL=https://…`, `SESSION_SECURE_COOKIE=true`, `LOG_LEVEL=warning`.
- [ ] HTTPS einrichten (Pflicht für den Service Worker; HSTS wird bei HTTPS automatisch gesetzt).
- [ ] `php artisan key:generate` einmalig auf dem Server – und den **`APP_KEY` getrennt vom Server sicher aufbewahren**. Ohne ihn sind die verschlüsselten Vertrauenspersonen unwiederbringlich verloren.
- [ ] Deployment: `composer install --no-dev --optimize-autoloader`, `npm ci && npm run build`, `php artisan migrate --force`, `php artisan optimize`.
- [ ] Regelmäßige, verschlüsselte Backups der Datenbank (`database/database.sqlite`).
- [ ] Webserver-Logs nach der in `CALMIFY_LOG_RETENTION_DAYS` angegebenen Frist löschen (z. B. per logrotate).
- [ ] Nach jeder Änderung an `public/sw.js` die Konstante `CACHE` hochzählen, damit Browser die neue Version laden.
