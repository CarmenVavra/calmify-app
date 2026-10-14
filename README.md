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
- [ ] Deployment: `composer install --no-dev --optimize-autoloader`, `npm ci && npm run build`, `php artisan migrate --force`, `php artisan optimize` (auf Plesk-Webhosting mit chroot-SSH stattdessen nur `route:cache` und `event:cache`, siehe unten).
- [ ] Regelmäßige, verschlüsselte Backups der Datenbank (`database/database.sqlite`).
- [ ] Webserver-Logs nach der in `CALMIFY_LOG_RETENTION_DAYS` angegebenen Frist löschen (z. B. per logrotate).
- [ ] Nach jeder Änderung an `public/sw.js` die Konstante `CACHE` hochzählen, damit Browser die neue Version laden.

## Deployment auf netcup-Webhosting (Plesk)

Live unter https://calmify.caryssa.at. Platzhalter: `<benutzer>` = SSH-Benutzer aus Plesk, `<server>` = Server-Adresse, `<schluessel>` = SSH-Schlüssel.

### Einmalig in Plesk

- **Dokumentenstamm** der Subdomain auf `<subdomain>/public` setzen, PHP 8.3 wählen.
- **PHP-Einstellungen → open_basedir:** `{WEBSPACEROOT}{/}{:}{TMP}{/}{:}/var/lib/php/sessions` wählen. Der Standardwert erlaubt nur den Dokumentenstamm (`public`) – Laravel braucht aber das ganze Projekt, sonst gibt es Fehler 500 ohne Log-Eintrag.
- **SSL/TLS:** Let's-Encrypt-Zertifikat und permanente HTTP→HTTPS-Weiterleitung.
- **Log-Rotation** auf `CALMIFY_LOG_RETENTION_DAYS` Tage (Standard 14) stellen.

### Erstinstallation (per SSH)

```bash
cd <subdomain>
git init && git remote add origin https://github.com/CarmenVavra/calmify-app.git
git fetch origin main && git checkout -b main --track origin/main
curl -sS https://getcomposer.org/installer | php
php composer.phar install --no-dev --optimize-autoloader
cp .env.example .env   # Produktivwerte und CALMIFY_LEGAL_* eintragen, chmod 600 .env
touch database/database.sqlite
php artisan key:generate --force
php artisan migrate --force
php artisan route:cache && php artisan event:cache
```

**Wichtig – kein `php artisan optimize` / `config:cache`:** Die SSH-Sitzung läuft in einem chroot, dort heißt der Projektordner `/<subdomain>`, für den Webserver aber `/var/www/vhosts/…/<subdomain>`. Der Konfigurations-Cache würde die chroot-Pfade speichern und die Seite mit Fehler 500 lahmlegen. Falls es doch passiert: `php artisan optimize:clear`.

### Gebaute Dateien hochladen (lokal)

Auf dem Webhosting gibt es kein Node.js, deshalb lokal bauen und `public/build` hochladen:

```bash
npm run build
scp -i "$HOME/.ssh/<schluessel>" -r public/build <benutzer>@<server>:<subdomain>/public/
ssh -i "$HOME/.ssh/<schluessel>" <benutzer>@<server> "cd <subdomain>/public && find build -type d -exec chmod 755 {} + && find build -type f -exec chmod 644 {} +"
```

Der zweite Befehl ist nötig, weil `scp` von Windows die Ordner mit Rechten `700` anlegt – der Webserver antwortet dann mit 403 und die Seite erscheint ohne Styling.

### Updates

```bash
git pull
php composer.phar install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan route:cache && php artisan event:cache
```

Danach `public/build` neu bauen und hochladen (siehe oben) und bei Änderungen an `public/sw.js` die Konstante `CACHE` hochzählen.
