@echo off
setlocal
chcp 65001 >nul
title Calmify Start
cd /d "%~dp0"

set "PORT=8050"

rem --- Port bereits belegt? ---------------------------------------------
netstat -ano | findstr /R /C:":%PORT%  *0\.0\.0\.0:0 " /C:":%PORT%  *\[::\]:0 " >nul
if %errorlevel%==0 (
    echo Port %PORT% ist bereits belegt. Laeuft Calmify schon? Sonst zuerst stop.bat ausfuehren.
    start "" "http://127.0.0.1:%PORT%"
    pause
    exit /b 1
)

rem --- Erstinstallation ---------------------------------------------------
if not exist "vendor\autoload.php" (
    echo Installiere PHP-Abhaengigkeiten ...
    call composer install --no-interaction || goto :error
)
if not exist ".env" (
    copy ".env.example" ".env" >nul
    php artisan key:generate --ansi || goto :error
)
if not exist "database\database.sqlite" (
    type nul > "database\database.sqlite"
)
php artisan migrate --force --ansi || goto :error

if not exist "node_modules" (
    echo Installiere Frontend-Abhaengigkeiten ...
    call npm install || goto :error
)
if not exist "public\build\manifest.json" (
    echo Baue Frontend-Assets ...
    call npm run build || goto :error
)

rem --- Server starten (eigenes Fenster, damit stop.bat es findet) ---------
echo Starte Calmify auf http://127.0.0.1:%PORT% ...
start "Calmify Server" /min php artisan serve --host=127.0.0.1 --port=%PORT%
ping -n 3 127.0.0.1 >nul
start "" "http://127.0.0.1:%PORT%"
echo Calmify laeuft. Zum Beenden stop.bat ausfuehren.
exit /b 0

:error
echo.
echo Start fehlgeschlagen. Details siehe oben.
pause
exit /b 1
