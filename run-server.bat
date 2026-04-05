@echo off
setlocal enabledelayedexpansion

title ShoeHub Premium Server Launcher

echo ==================================================
echo ShoeHub — Premium Server Launcher
echo ==================================================
echo.

:: 1. Force close any existing PHP processes to prevent conflicts
echo [Step 1] Cleaning up old processes...
taskkill /F /IM php.exe /T >nul 2>nul
timeout /t 2 /nobreak >nul
echo [OK] Environment is clean.

:: 2. Detect best PHP
echo.
echo [Step 2] Selecting best PHP version...
set "PHP_EXE=php"
if exist "G:\xaamp\php\php.exe" (
    set "PHP_EXE=G:\xaamp\php\php.exe"
    set "PATH=G:\xaamp\php;!PATH!"
    set "PHP_BINARY=G:\xaamp\php\php.exe"
    echo [OK] Found XAMPP PHP 8.2 ^(Recommended^)
) else if exist "C:\xampp\php\php.exe" (
    set "PHP_EXE=C:\xampp\php\php.exe"
    set "PATH=C:\xampp\php;!PATH!"
    set "PHP_BINARY=C:\xampp\php\php.exe"
    echo [OK] Found XAMPP PHP
)

echo.
echo [Step 3] Verifying PHP Version...
"!PHP_EXE!" -v
echo.
"!PHP_EXE!" -m | findstr /i "mbstring pdo_mysql openssl"
if %errorlevel% neq 0 (
    echo [!] WARNING: Extensions not found in this PHP version.
)

echo.
echo [Step 4] Starting ShoeHub Server (Direct Boot)...
echo --------------------------------------------------
echo Tip: Keep this window open. 
echo 1. Try: http://127.0.0.1:8000
echo 2. If 8000 fails, try: http://127.0.0.1:8001
echo --------------------------------------------------
echo Running on Port 8000...
start "ShoeHub - Primary (8000)" "!PHP_EXE!" -S 127.0.0.1:8000 -t public server.php
timeout /t 3 /nobreak >nul
echo Attempting backup Port 8001...
"!PHP_EXE!" -S 127.0.0.1:8001 -t public server.php

pause
