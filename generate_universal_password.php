<?php

/**
 * Script Generator Hash Password Universal
 * 
 * Digunakan untuk membuat hash password baru untuk universal password.
 * Hash ini yang akan dimasukkan ke application/config/config.php
 * 
 * Cara menggunakan:
 * 1. Jalankan: php generate_universal_password.php
 * 2. Masukkan password baru yang diinginkan
 * 3. Copy hash yang dihasilkan
 * 4. Paste ke config.php di bagian $config['universal_password_hash']
 * 
 * @author  Support Team
 * @version 1.0
 * @date    2024-11-04
 */

// ASCII Art Banner
echo "\n";
echo "╔═══════════════════════════════════════════════════════════╗\n";
echo "║                                                           ║\n";
echo "║    GENERATOR HASH PASSWORD UNIVERSAL                      ║\n";
echo "║    Aplikasi Perkara Pengadilan Negeri                     ║\n";
echo "║                                                           ║\n";
echo "╚═══════════════════════════════════════════════════════════╝\n";
echo "\n";

echo "Deskripsi:\n";
echo "Script ini akan membuat hash password untuk universal password.\n";
echo "Hash yang dihasilkan harus disimpan di file config.php\n";
echo "\n";

echo "⚠️  PERHATIAN:\n";
echo "- Password universal HANYA untuk role 'user' (operator PN)\n";
echo "- TIDAK bisa digunakan untuk role 'admin' atau 'super_admin'\n";
echo "- Setiap penggunaan akan tercatat di log file\n";
echo "- Ganti password ini secara berkala untuk keamanan\n";
echo "\n";

echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "\n";

// Minta input password
echo "Masukkan password universal baru:\n";
echo "(Rekomendasi: minimal 12 karakter, kombinasi huruf besar/kecil, angka, simbol)\n";
echo "\n";
echo "Password: ";

// Baca input dari user
if (PHP_OS_FAMILY === "Windows") {
    // Windows tidak support readline dengan baik untuk hidden input
    $password = trim(fgets(STDIN));
} else {
    // Linux/Mac bisa gunakan readline
    $password = readline();
}

// Validasi password kosong
if (empty($password)) {
    echo "\n❌ ERROR: Password tidak boleh kosong!\n\n";
    exit(1);
}

// Validasi password terlalu pendek
if (strlen($password) < 8) {
    echo "\n⚠️  WARNING: Password terlalu pendek!\n";
    echo "Rekomendasi: minimal 12 karakter untuk keamanan optimal.\n";
    echo "\nLanjutkan? (y/n): ";
    $confirm = trim(fgets(STDIN));
    if (strtolower($confirm) !== 'y') {
        echo "\n❌ Dibatalkan.\n\n";
        exit(0);
    }
}

echo "\n━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "\n⏳ Generating hash...\n\n";

// Generate hash menggunakan PASSWORD_DEFAULT (bcrypt)
$hash = password_hash($password, PASSWORD_DEFAULT);

// Tampilkan hasil
echo "✅ Hash berhasil dibuat!\n\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "\n";
echo "📋 HASIL:\n";
echo "\n";
echo "Password yang Anda masukkan:\n";
echo "  " . $password . "\n";
echo "\n";
echo "Hash yang dihasilkan:\n";
echo "  " . $hash . "\n";
echo "\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "\n";

// Verifikasi hash berfungsi
if (password_verify($password, $hash)) {
    echo "✅ Verifikasi: Hash valid dan berfungsi dengan baik!\n";
} else {
    echo "❌ ERROR: Hash tidak valid! Mohon coba lagi.\n";
    exit(1);
}

echo "\n━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "\n";
echo "📝 LANGKAH SELANJUTNYA:\n";
echo "\n";
echo "1. Buka file: application/config/config.php\n";
echo "\n";
echo "2. Cari baris:\n";
echo "   \$config['universal_password_hash'] = '...';\n";
echo "\n";
echo "3. Ganti dengan:\n";
echo "   \$config['universal_password_hash'] = '" . $hash . "';\n";
echo "\n";
echo "4. Simpan file config.php\n";
echo "\n";
echo "5. CATAT password ini di tempat aman!\n";
echo "   (Password Manager, dokumen terenkripsi, dll)\n";
echo "\n";
echo "6. JANGAN commit password plaintext ke Git!\n";
echo "\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "\n";

// Tanya apakah ingin save ke file
echo "💾 Simpan hasil ke file? (y/n): ";
$save = trim(fgets(STDIN));

if (strtolower($save) === 'y') {
    $filename = 'universal_password_' . date('Y-m-d_His') . '.txt';

    $content = "═══════════════════════════════════════════════════════════\n";
    $content .= "UNIVERSAL PASSWORD HASH\n";
    $content .= "Generated: " . date('Y-m-d H:i:s') . "\n";
    $content .= "═══════════════════════════════════════════════════════════\n\n";
    $content .= "Password:\n";
    $content .= $password . "\n\n";
    $content .= "Hash:\n";
    $content .= $hash . "\n\n";
    $content .= "Config line:\n";
    $content .= "\$config['universal_password_hash'] = '" . $hash . "';\n\n";
    $content .= "═══════════════════════════════════════════════════════════\n";
    $content .= "PENTING:\n";
    $content .= "- Simpan file ini di tempat AMAN\n";
    $content .= "- JANGAN commit ke Git\n";
    $content .= "- HAPUS file ini setelah dicatat\n";
    $content .= "═══════════════════════════════════════════════════════════\n";

    if (file_put_contents($filename, $content)) {
        echo "\n✅ File berhasil disimpan: " . $filename . "\n";
        echo "⚠️  INGAT: Hapus file ini setelah Anda catat password-nya!\n";
    } else {
        echo "\n❌ ERROR: Gagal menyimpan file!\n";
    }
}

echo "\n";
echo "╔═══════════════════════════════════════════════════════════╗\n";
echo "║                                                           ║\n";
echo "║    Terima kasih telah menggunakan generator ini!         ║\n";
echo "║    Jaga keamanan password universal Anda.                ║\n";
echo "║                                                           ║\n";
echo "╚═══════════════════════════════════════════════════════════╝\n";
echo "\n";

// Informasi tambahan
echo "ℹ️  Informasi Tambahan:\n";
echo "\n";
echo "Untuk testing apakah hash berfungsi:\n";
echo "  Login dengan username user + password yang baru dibuat\n";
echo "  Contoh: username 'pnbanjarbaru' + password universal baru\n";
echo "\n";
echo "Untuk melihat log penggunaan:\n";
echo "  Cek file: application/logs/log-" . date('Y-m-d') . ".php\n";
echo "  Cari: 'Universal password digunakan untuk login'\n";
echo "\n";
echo "Dokumentasi lengkap:\n";
echo "  Baca: UNIVERSAL_PASSWORD_DOCUMENTATION.md\n";
echo "\n";

exit(0);
