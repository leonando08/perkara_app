# ========================================================
# Script Generator Universal Password (PowerShell)
# ========================================================

Write-Host ""
Write-Host "===================================================" -ForegroundColor Cyan
Write-Host " Generator Hash Password Universal" -ForegroundColor Cyan
Write-Host " Aplikasi Perkara Pengadilan Negeri" -ForegroundColor Cyan
Write-Host "===================================================" -ForegroundColor Cyan
Write-Host ""

# Cek apakah PHP ada di Laragon
$phpPath = "C:\laragon\bin\php\php-8.1.10-Win32-vs16-x64\php.exe"

if (-not (Test-Path $phpPath)) {
    Write-Host "ERROR: PHP tidak ditemukan di: $phpPath" -ForegroundColor Red
    Write-Host ""
    Write-Host "Silakan sesuaikan `$phpPath di file generate_password.ps1" -ForegroundColor Yellow
    Write-Host "dengan lokasi PHP di komputer Anda." -ForegroundColor Yellow
    Write-Host ""
    Read-Host "Tekan Enter untuk keluar"
    exit 1
}

Write-Host "PHP ditemukan: $phpPath" -ForegroundColor Green
Write-Host ""

# Jalankan script PHP
& $phpPath generate_universal_password.php

Write-Host ""
Read-Host "Tekan Enter untuk keluar"
