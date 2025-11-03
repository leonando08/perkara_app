<?php

/**
 * Script untuk test dan create user pnbanjarbaru
 * Jalankan di browser: http://localhost/Perkara_app/test_login_pnbanjarbaru.php
 */

// Load CodeIgniter bootstrap
define('BASEPATH', TRUE);
require_once 'application/config/database.php';

// Connect to database
$db_config = $db['default'];
$conn = new mysqli(
    $db_config['hostname'],
    $db_config['username'],
    $db_config['password'],
    $db_config['database']
);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "<h2>Test Login PN Banjarbaru</h2>";
echo "<hr>";

// Generate password hash
$password = 'banjarbaru123';
$password_hash = password_hash($password, PASSWORD_DEFAULT);

echo "<h3>1. Password Hash Generation</h3>";
echo "Password: <strong>$password</strong><br>";
echo "Hash: <code>$password_hash</code><br><br>";

// Check if pengadilan table exists
$check_pengadilan = $conn->query("SHOW TABLES LIKE 'pengadilan'");
if ($check_pengadilan->num_rows == 0) {
    echo "<h3>2. Create Table Pengadilan</h3>";

    $create_pengadilan = "
    CREATE TABLE `pengadilan` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `kode_pengadilan` varchar(20) NOT NULL,
      `nama_pengadilan` varchar(255) NOT NULL,
      `alamat` text,
      `telepon` varchar(20),
      `email` varchar(100),
      `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
      PRIMARY KEY (`id`),
      UNIQUE KEY `kode_pengadilan` (`kode_pengadilan`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    ";

    if ($conn->query($create_pengadilan)) {
        echo "✅ Tabel pengadilan berhasil dibuat<br><br>";
    } else {
        echo "❌ Error: " . $conn->error . "<br><br>";
    }
}

// Insert PN Banjarbaru
echo "<h3>3. Insert Pengadilan PN Banjarbaru</h3>";
$insert_pengadilan = "
INSERT INTO `pengadilan` (`kode_pengadilan`, `nama_pengadilan`, `alamat`, `telepon`, `email`)
VALUES ('PN-BJB', 'PN BANJARBARU', 'Jl. A. Yani Km. 35, Banjarbaru, Kalimantan Selatan', '0511-1234567', 'info@pn-banjarbaru.go.id')
ON DUPLICATE KEY UPDATE nama_pengadilan = 'PN BANJARBARU';
";

if ($conn->query($insert_pengadilan)) {
    echo "✅ Pengadilan PN BANJARBARU berhasil ditambahkan<br><br>";
} else {
    echo "❌ Error: " . $conn->error . "<br><br>";
}

// Get pengadilan_id
$pengadilan_result = $conn->query("SELECT id FROM pengadilan WHERE kode_pengadilan = 'PN-BJB'");
$pengadilan_id = $pengadilan_result->fetch_assoc()['id'];

echo "ID Pengadilan: <strong>$pengadilan_id</strong><br><br>";

// Check if users table has required columns
echo "<h3>4. Add Columns to Users Table</h3>";
$add_columns = [
    "ALTER TABLE `users` ADD COLUMN IF NOT EXISTS `pengadilan_id` int(11) DEFAULT NULL AFTER `role`",
    "ALTER TABLE `users` ADD COLUMN IF NOT EXISTS `nip` varchar(50) DEFAULT NULL AFTER `pengadilan_id`",
    "ALTER TABLE `users` ADD COLUMN IF NOT EXISTS `jabatan` varchar(100) DEFAULT NULL AFTER `nip`",
    "ALTER TABLE `users` ADD COLUMN IF NOT EXISTS `nama` varchar(100) DEFAULT NULL AFTER `nama_lengkap`"
];

foreach ($add_columns as $sql) {
    // MySQL versi lama tidak support IF NOT EXISTS, jadi kita gunakan cara lain
    $column = '';
    if (strpos($sql, 'pengadilan_id') !== false) $column = 'pengadilan_id';
    elseif (strpos($sql, 'nip') !== false) $column = 'nip';
    elseif (strpos($sql, 'jabatan') !== false) $column = 'jabatan';
    elseif (strpos($sql, 'nama') !== false) $column = 'nama';

    // Check if column exists
    $check = $conn->query("SHOW COLUMNS FROM `users` LIKE '$column'");
    if ($check->num_rows == 0) {
        $sql_without_if = str_replace('IF NOT EXISTS ', '', $sql);
        if ($conn->query($sql_without_if)) {
            echo "✅ Kolom $column berhasil ditambahkan<br>";
        } else {
            echo "⚠️ Kolom $column: " . $conn->error . "<br>";
        }
    } else {
        echo "✅ Kolom $column sudah ada<br>";
    }
}
echo "<br>";

// Create/Update user pnbanjarbaru
echo "<h3>5. Create/Update User pnbanjarbaru</h3>";

// Check if user exists
$check_user = $conn->query("SELECT id FROM users WHERE username = 'pnbanjarbaru'");

if ($check_user->num_rows > 0) {
    // Update existing user
    $update_sql = "
    UPDATE `users` SET
        `password` = '$password_hash',
        `role` = 'admin',
        `email` = 'admin@pn-banjarbaru.go.id',
        `nama_lengkap` = 'Administrator PN Banjarbaru',
        `nama` = 'Admin Banjarbaru',
        `pengadilan_id` = $pengadilan_id,
        `nip` = '198501012010011001',
        `jabatan` = 'Administrator'
    WHERE `username` = 'pnbanjarbaru'
    ";

    if ($conn->query($update_sql)) {
        echo "✅ User pnbanjarbaru berhasil diupdate<br><br>";
    } else {
        echo "❌ Error update: " . $conn->error . "<br><br>";
    }
} else {
    // Insert new user
    $insert_sql = "
    INSERT INTO `users` (
        `username`, 
        `password`, 
        `role`, 
        `email`, 
        `nama_lengkap`,
        `nama`,
        `pengadilan_id`,
        `nip`,
        `jabatan`,
        `created_at`
    ) VALUES (
        'pnbanjarbaru',
        '$password_hash',
        'admin',
        'admin@pn-banjarbaru.go.id',
        'Administrator PN Banjarbaru',
        'Admin Banjarbaru',
        $pengadilan_id,
        '198501012010011001',
        'Administrator',
        NOW()
    )
    ";

    if ($conn->query($insert_sql)) {
        echo "✅ User pnbanjarbaru berhasil dibuat<br><br>";
    } else {
        echo "❌ Error insert: " . $conn->error . "<br><br>";
    }
}

// Verify user
echo "<h3>6. Verifikasi User</h3>";
$verify_sql = "
SELECT 
    u.id,
    u.username,
    u.role,
    u.email,
    u.nama_lengkap,
    u.nama,
    u.nip,
    u.jabatan,
    p.nama_pengadilan,
    p.kode_pengadilan
FROM users u
LEFT JOIN pengadilan p ON p.id = u.pengadilan_id
WHERE u.username = 'pnbanjarbaru'
";

$result = $conn->query($verify_sql);
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    echo "<table border='1' cellpadding='10' style='border-collapse: collapse;'>";
    echo "<tr><th>Field</th><th>Value</th></tr>";
    foreach ($user as $key => $value) {
        echo "<tr><td><strong>$key</strong></td><td>$value</td></tr>";
    }
    echo "</table><br>";

    // Test password verification
    echo "<h3>7. Test Password Verification</h3>";
    $stored_hash = $conn->query("SELECT password FROM users WHERE username = 'pnbanjarbaru'")->fetch_assoc()['password'];

    echo "Stored Hash: <code>" . substr($stored_hash, 0, 50) . "...</code><br>";
    echo "Test Password: <strong>$password</strong><br>";

    if (password_verify($password, $stored_hash)) {
        echo "✅ <strong style='color: green;'>Password verification SUCCESS!</strong><br><br>";
    } else {
        echo "❌ <strong style='color: red;'>Password verification FAILED!</strong><br><br>";
    }
} else {
    echo "❌ User tidak ditemukan!<br><br>";
}

// Show login instructions
echo "<h3>8. Cara Login</h3>";
echo "<div style='background: #f0f0f0; padding: 15px; border-radius: 5px;'>";
echo "<strong>URL Login:</strong> <a href='" . dirname($_SERVER['PHP_SELF']) . "/index.php/auth/login' target='_blank'>Klik di sini untuk login</a><br>";
echo "<strong>Username:</strong> pnbanjarbaru<br>";
echo "<strong>Password:</strong> banjarbaru123<br>";
echo "</div><br>";

echo "<h3>9. Troubleshooting</h3>";
echo "<ul>";
echo "<li>Jika tetap tidak bisa login, clear browser cache dan cookies</li>";
echo "<li>Pastikan tidak ada cooldown captcha aktif</li>";
echo "<li>Cek bahwa password diketik dengan benar (huruf kecil semua)</li>";
echo "<li>Jika ada error database, jalankan script ini lagi</li>";
echo "</ul>";

$conn->close();

echo "<hr>";
echo "<p><small>Script selesai dijalankan pada: " . date('Y-m-d H:i:s') . "</small></p>";
