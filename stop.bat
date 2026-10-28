@echo off
setlocal
chcp 65001 >nul
cd /d "%~dp0"

set "PORT=8050"

rem Server-Fenster (inkl. Kindprozesse) beenden
taskkill /FI "WINDOWTITLE eq Calmify Server*" /T /F >nul 2>&1

rem Falls noch ein Prozess auf dem Port lauscht: gezielt beenden
for /f "tokens=5" %%P in ('netstat -ano ^| findstr /R /C:":%PORT%  *0\.0\.0\.0:0 " /C:":%PORT%  *\[::\]:0 "') do (
    taskkill /PID %%P /T /F >nul 2>&1
)

echo Calmify-Server auf Port %PORT% wurde gestoppt.
ping -n 3 127.0.0.1 >nul
