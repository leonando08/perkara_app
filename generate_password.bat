@echo off
REM ========================================================
REM Script Generator Universal Password (Windows Batch)
REM ========================================================

echo.
echo ===================================================
echo  Generator Hash Password Universal
echo  Aplikasi Perkara Pengadilan Negeri
echo ===================================================
echo.

REM Cek apakah PHP ada di Laragon
SET PHP_PATH=C:\laragon\bin\php\php-8.1.10-Win32-vs16-x64\php.exe

if not exist "%PHP_PATH%" (
    echo ERROR: PHP tidak ditemukan di: %PHP_PATH%
    echo.
    echo Silakan sesuaikan PHP_PATH di file generate_password.bat
    echo dengan lokasi PHP di komputer Anda.
    echo.
    pause
    exit /b 1
)

echo PHP ditemukan: %PHP_PATH%
echo.

REM Jalankan script PHP
"%PHP_PATH%" generate_universal_password.php

echo.
pause
