@echo off
REM ============================================================================
REM Vendio - TikTok Shop Background Sync Windows Batch Runner
REM Digunakan untuk Windows Task Scheduler
REM
REM Penggunaan:
REM   cron_sync.bat [job_name]
REM
REM Contoh:
REM   cron_sync.bat pull_orders
REM   cron_sync.bat pull_packages
REM   cron_sync.bat pull_returns_cancellations
REM   cron_sync.bat refresh_token
REM   cron_sync.bat pull_statements
REM   cron_sync.bat sync_all
REM ============================================================================

setlocal enabledelayedexpansion

REM Pindah ke direktori skrip ini berada
cd /d "%~dp0"

REM Tentukan job yang akan dijalankan
set "JOB=%~1"
if "%JOB%"=="" set "JOB=sync_all"

REM Cari path executable PHP (XAMPP default atau environment PATH)
set "PHP_BIN="
if exist "C:\xampp\php\php.exe" (
    set "PHP_BIN=C:\xampp\php\php.exe"
) else (
    where php >nul 2>nul
    if %errorlevel% equ 0 (
        set "PHP_BIN=php"
    )
)

if "%PHP_BIN%"=="" (
    echo [ERROR] PHP executable tidak ditemukan! Pastikan XAMPP terpasang di C:\xampp atau php terdaftar di PATH.
    exit /b 1
)

echo [INFO] Menjalankan Cron Job: %JOB% ...
"%PHP_BIN%" cron.php %JOB%

exit /b %errorlevel%
