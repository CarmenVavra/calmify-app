@echo off
setlocal
rem Vite-Dev-Server (falls "npm run dev" laeuft): fester Port, siehe vite.config.js
set "VITE_PORT=5900"
for /f "tokens=5" %%v in ('netstat -ano ^| findstr /R /C:":%VITE_PORT%  *0\.0\.0\.0:0 " /C:":%VITE_PORT%  *\[::\]:0 "') do taskkill /PID %%v /T /F >nul 2>&1
if exist "%~dp0public\hot" del /q "%~dp0public\hot" >nul 2>&1
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
