<?php

/**
 * COMPREHENSIVE DEBUG SCRIPT - PERKARA APP
 * URL: http://localhost/Perkara_app/debug_full.php
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<style>
body { font-family: Arial; margin: 20px; }
h2 { background: #4CAF50; color: white; padding: 10px; }
h3 { background: #2196F3; color: white; padding: 8px; }
.success { color: green; font-weight: bold; }
.error { color: red; font-weight: bold; }
.warning { color: orange; font-weight: bold; }
table { border-collapse: collapse; width: 100%; margin: 10px 0; }
th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
th { background-color: #4CAF50; color: white; }
pre { background: #f4f4f4; padding: 10px; border-radius: 5px; }
.box { background: #f9f9f9; padding: 15px; border-left: 4px solid #4CAF50; margin: 10px 0; }
</style>";

echo "<h2>🔍 COMPREHENSIVE DEBUG - PERKARA APP</h2>";
echo "<p><strong>Time:</strong> " . date('Y-m-d H:i:s') . "</p>";
echo "<hr>";

// ============================================
// 1. PHP ENVIRONMENT CHECK
// ============================================
echo "<h3>1. PHP Environment</h3>";
echo "<table>";
echo "<tr><th>Setting</th><th>Value</th></tr>";
echo "<tr><td>PHP Version</td><td>" . phpversion() . "</td></tr>";
echo "<tr><td>Server Software</td><td>" . $_SERVER['SERVER_SOFTWARE'] . "</td></tr>";
echo "<tr><td>Document Root</td><td>" . $_SERVER['DOCUMENT_ROOT'] . "</td></tr>";
echo "<tr><td>Script Path</td><td>" . __FILE__ . "</td></tr>";
echo "<tr><td>Base URL</td><td>http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/</td></tr>";
echo "</table>";

// ============================================
// 2. DATABASE CONNECTION TEST
// ============================================
echo "<h3>2. Database Connection Test</h3>";

// Test 1: Direct connection (Laragon)
$configs = [
    'Laragon (root, no password)' => [
        'host' => 'localhost',
        'user' => 'root',
        'pass' => '',
        'db' => 'perkara_db'
    ],
    'Laragon (root, with password)' => [
        'host' => 'localhost',
        'user' => 'root',
        'pass' => 'root',
        'db' => 'perkara_db'
    ],
    'Docker setup' => [
        'host' => 'db',
        'user' => 'perkara_user',
        'pass' => 'perkara_pass',
        'db' => 'perkara_db'
    ],
];

$connected = false;
$active_conn = null;

foreach ($configs as $config_name => $config) {
    echo "<strong>Testing: $config_name</strong><br>";
    $conn = @new mysqli($config['host'], $config['user'], $config['pass'], $config['db']);

    if ($conn->connect_error) {
        echo "❌ <span class='error'>FAILED: " . $conn->connect_error . "</span><br><br>";
    } else {
        echo "✅ <span class='success'>SUCCESS!</span><br>";
        echo "Server: " . $conn->server_info . "<br>";
        echo "Host Info: " . $conn->host_info . "<br><br>";
        $connected = true;
        $active_conn = $conn;
        $working_config = $config;
        break;
    }
}

if (!$connected) {
    echo "<div class='box' style='border-color: red;'>";
    echo "<h3 class='error'>❌ DATABASE CONNECTION FAILED!</h3>";
    echo "<p>Kemungkinan penyebab:</p>";
    echo "<ul>";
    echo "<li>MySQL service tidak running (cek Laragon)</li>";
    echo "<li>Database 'perkara_db' belum dibuat</li>";
    echo "<li>Username/password salah</li>";
    echo "</ul>";
    echo "<p><strong>Solusi:</strong></p>";
    echo "<ol>";
    echo "<li>Buka Laragon, pastikan MySQL running (icon hijau)</li>";
    echo "<li>Klik 'Database' di Laragon, buka phpMyAdmin</li>";
    echo "<li>Buat database 'perkara_db' jika belum ada</li>";
    echo "<li>Refresh halaman ini</li>";
    echo "</ol>";
    echo "</div>";
    exit;
}

echo "<div class='box'>";
echo "✅ <strong class='success'>Connected using: " . array_search($working_config, $configs) . "</strong><br>";
echo "Host: {$working_config['host']}<br>";
echo "User: {$working_config['user']}<br>";
echo "Database: {$working_config['db']}<br>";
echo "</div>";

// ============================================
// 3. CHECK TABLES
// ============================================
echo "<h3>3. Database Tables Check</h3>";

$tables = ['users', 'pengadilan', 'perkara_banding', 'jenis_perkara'];
$tables_status = [];

echo "<table>";
echo "<tr><th>Table Name</th><th>Status</th><th>Rows</th></tr>";

foreach ($tables as $table) {
    $check = $active_conn->query("SHOW TABLES LIKE '$table'");
    if ($check->num_rows > 0) {
        $count = $active_conn->query("SELECT COUNT(*) as count FROM `$table`")->fetch_assoc()['count'];
        echo "<tr><td>$table</td><td class='success'>✅ Exists</td><td>$count</td></tr>";
        $tables_status[$table] = true;
    } else {
        echo "<tr><td>$table</td><td class='error'>❌ Missing</td><td>-</td></tr>";
        $tables_status[$table] = false;
    }
}
echo "</table>";

// ============================================
// 4. CHECK USERS TABLE STRUCTURE
// ============================================
if ($tables_status['users']) {
    echo "<h3>4. Users Table Structure</h3>";
    $columns = $active_conn->query("SHOW COLUMNS FROM users");
    echo "<table>";
    echo "<tr><th>Column</th><th>Type</th><th>Null</th><th>Key</th></tr>";
    while ($col = $columns->fetch_assoc()) {
        echo "<tr>";
        echo "<td>{$col['Field']}</td>";
        echo "<td>{$col['Type']}</td>";
        echo "<td>{$col['Null']}</td>";
        echo "<td>{$col['Key']}</td>";
        echo "</tr>";
    }
    echo "</table>";

    // Check required columns
    $required_cols = ['pengadilan_id', 'nip', 'jabatan', 'nama'];
    $missing_cols = [];

    $columns = $active_conn->query("SHOW COLUMNS FROM users");
    $existing_cols = [];
    while ($col = $columns->fetch_assoc()) {
        $existing_cols[] = $col['Field'];
    }

    foreach ($required_cols as $req_col) {
        if (!in_array($req_col, $existing_cols)) {
            $missing_cols[] = $req_col;
        }
    }

    if (!empty($missing_cols)) {
        echo "<div class='box' style='border-color: orange;'>";
        echo "<h4 class='warning'>⚠️ Missing Columns</h4>";
        echo "<p>Kolom berikut belum ada: <strong>" . implode(', ', $missing_cols) . "</strong></p>";
        echo "<p>Akan ditambahkan otomatis di step berikutnya...</p>";
        echo "</div>";
    }
}

// ============================================
// 5. CHECK USER pnbanjarbaru
// ============================================
echo "<h3>5. Check User: pnbanjarbaru</h3>";

if ($tables_status['users']) {
    $user_check = $active_conn->query("SELECT * FROM users WHERE username = 'pnbanjarbaru'");

    if ($user_check->num_rows > 0) {
        echo "✅ <span class='success'>User exists</span><br><br>";

        $user = $user_check->fetch_assoc();
        echo "<table>";
        echo "<tr><th>Field</th><th>Value</th></tr>";
        foreach ($user as $key => $value) {
            if ($key == 'password') {
                $value = substr($value, 0, 30) . "... (hash)";
            }
            echo "<tr><td><strong>$key</strong></td><td>$value</td></tr>";
        }
        echo "</table>";

        // Test password
        $password = 'banjarbaru123';
        $stored_hash = $active_conn->query("SELECT password FROM users WHERE username = 'pnbanjarbaru'")->fetch_assoc()['password'];

        echo "<h4>Password Verification Test</h4>";
        echo "Test Password: <strong>$password</strong><br>";

        if (password_verify($password, $stored_hash)) {
            echo "✅ <span class='success'>Password verification SUCCESS!</span><br>";
        } else {
            echo "❌ <span class='error'>Password verification FAILED!</span><br>";
            echo "<p>Password hash akan di-reset...</p>";
        }
    } else {
        echo "❌ <span class='error'>User NOT found</span><br>";
        echo "<p>User akan dibuat otomatis di step berikutnya...</p>";
    }
}

// ============================================
// 6. AUTO-FIX: CREATE/UPDATE ALL
// ============================================
echo "<h3>6. Auto-Fix: Create/Update</h3>";

// Create pengadilan table if not exists
if (!$tables_status['pengadilan']) {
    echo "<strong>Creating table: pengadilan...</strong><br>";
    $sql = "CREATE TABLE `pengadilan` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `kode_pengadilan` varchar(20) NOT NULL,
      `nama_pengadilan` varchar(255) NOT NULL,
      `alamat` text,
      `telepon` varchar(20),
      `email` varchar(100),
      `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
      PRIMARY KEY (`id`),
      UNIQUE KEY `kode_pengadilan` (`kode_pengadilan`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

    if ($active_conn->query($sql)) {
        echo "✅ Table created<br>";
    } else {
        echo "❌ Error: " . $active_conn->error . "<br>";
    }
}

// Insert PN Banjarbaru
echo "<strong>Insert/Update: PN BANJARBARU...</strong><br>";
$sql = "INSERT INTO `pengadilan` (`kode_pengadilan`, `nama_pengadilan`, `alamat`, `telepon`, `email`)
VALUES ('PN-BJB', 'PN BANJARBARU', 'Jl. A. Yani Km. 35, Banjarbaru', '0511-1234567', 'info@pn-banjarbaru.go.id')
ON DUPLICATE KEY UPDATE nama_pengadilan = 'PN BANJARBARU'";

if ($active_conn->query($sql)) {
    echo "✅ Pengadilan data saved<br>";
} else {
    echo "❌ Error: " . $active_conn->error . "<br>";
}

// Add columns to users table
$columns_to_add = [
    'pengadilan_id' => "ALTER TABLE `users` ADD COLUMN `pengadilan_id` int(11) DEFAULT NULL AFTER `role`",
    'nip' => "ALTER TABLE `users` ADD COLUMN `nip` varchar(50) DEFAULT NULL AFTER `pengadilan_id`",
    'jabatan' => "ALTER TABLE `users` ADD COLUMN `jabatan` varchar(100) DEFAULT NULL AFTER `nip`",
    'nama' => "ALTER TABLE `users` ADD COLUMN `nama` varchar(100) DEFAULT NULL AFTER `nama_lengkap`"
];

foreach ($columns_to_add as $col_name => $sql) {
    $check = $active_conn->query("SHOW COLUMNS FROM `users` LIKE '$col_name'");
    if ($check->num_rows == 0) {
        echo "<strong>Adding column: $col_name...</strong><br>";
        if ($active_conn->query($sql)) {
            echo "✅ Column added<br>";
        } else {
            echo "❌ Error: " . $active_conn->error . "<br>";
        }
    } else {
        echo "✅ Column $col_name already exists<br>";
    }
}

// Get pengadilan_id
$pengadilan_id = $active_conn->query("SELECT id FROM pengadilan WHERE kode_pengadilan = 'PN-BJB'")->fetch_assoc()['id'];

// Create/Update user
$password_hash = password_hash('banjarbaru123', PASSWORD_DEFAULT);
$check_user = $active_conn->query("SELECT id FROM users WHERE username = 'pnbanjarbaru'");

if ($check_user->num_rows > 0) {
    echo "<strong>Updating user: pnbanjarbaru...</strong><br>";
    $sql = "UPDATE `users` SET
        `password` = '$password_hash',
        `role` = 'admin',
        `email` = 'admin@pn-banjarbaru.go.id',
        `nama_lengkap` = 'Administrator PN Banjarbaru',
        `nama` = 'Admin Banjarbaru',
        `pengadilan_id` = $pengadilan_id,
        `nip` = '198501012010011001',
        `jabatan` = 'Administrator'
    WHERE `username` = 'pnbanjarbaru'";
} else {
    echo "<strong>Creating user: pnbanjarbaru...</strong><br>";
    $sql = "INSERT INTO `users` (
        `username`, `password`, `role`, `email`, `nama_lengkap`, `nama`,
        `pengadilan_id`, `nip`, `jabatan`, `created_at`
    ) VALUES (
        'pnbanjarbaru', '$password_hash', 'admin', 'admin@pn-banjarbaru.go.id',
        'Administrator PN Banjarbaru', 'Admin Banjarbaru',
        $pengadilan_id, '198501012010011001', 'Administrator', NOW()
    )";
}

if ($active_conn->query($sql)) {
    echo "✅ <span class='success'>User saved successfully!</span><br>";
} else {
    echo "❌ Error: " . $active_conn->error . "<br>";
}

// ============================================
// 7. FINAL VERIFICATION
// ============================================
echo "<h3>7. Final Verification</h3>";

$verify = $active_conn->query("
SELECT 
    u.id, u.username, u.role, u.email, u.nama_lengkap, u.nama,
    u.nip, u.jabatan, p.nama_pengadilan, p.kode_pengadilan
FROM users u
LEFT JOIN pengadilan p ON p.id = u.pengadilan_id
WHERE u.username = 'pnbanjarbaru'
");

if ($verify->num_rows > 0) {
    $user = $verify->fetch_assoc();
    echo "<table>";
    echo "<tr><th>Field</th><th>Value</th></tr>";
    foreach ($user as $key => $value) {
        echo "<tr><td><strong>$key</strong></td><td>" . ($value ?? '<em>NULL</em>') . "</td></tr>";
    }
    echo "</table>";

    // Password test
    $password = 'banjarbaru123';
    $hash = $active_conn->query("SELECT password FROM users WHERE username = 'pnbanjarbaru'")->fetch_assoc()['password'];

    echo "<h4>Final Password Test</h4>";
    if (password_verify($password, $hash)) {
        echo "✅ <span class='success' style='font-size: 18px;'>PASSWORD VERIFICATION SUCCESS!</span><br>";
    } else {
        echo "❌ <span class='error' style='font-size: 18px;'>PASSWORD VERIFICATION FAILED!</span><br>";
    }
}

// ============================================
// 8. UPDATE CONFIG FILE
// ============================================
echo "<h3>8. Update Config File</h3>";

$config_file = __DIR__ . '/application/config/database.php';
$config_content = file_get_contents($config_file);

// Check if config needs update
if (
    strpos($config_content, "'hostname' => 'db'") !== false ||
    strpos($config_content, "'username' => 'perkara_user'") !== false
) {

    echo "<strong>Config needs update...</strong><br>";

    $new_config = str_replace(
        ["'hostname' => 'db'", "'username' => 'perkara_user'", "'password' => 'perkara_pass'"],
        ["'hostname' => 'localhost'", "'username' => 'root'", "'password' => ''"],
        $config_content
    );

    if (file_put_contents($config_file, $new_config)) {
        echo "✅ <span class='success'>Config file updated!</span><br>";
    } else {
        echo "❌ <span class='error'>Failed to update config!</span><br>";
    }
} else {
    echo "✅ Config file already correct<br>";
}

// ============================================
// 9. LOGIN INSTRUCTIONS
// ============================================
echo "<h3>9. 🎯 LOGIN SEKARANG!</h3>";

$base_url = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
$login_url = $base_url . "/index.php/auth/login";

echo "<div class='box' style='border-color: #4CAF50; background: #e8f5e9;'>";
echo "<h2 style='background: #4CAF50; color: white; padding: 15px; margin: -15px -15px 15px -15px;'>
✅ SETUP COMPLETE! SIAP LOGIN</h2>";

echo "<p style='font-size: 16px;'><strong>URL Login:</strong></p>";
echo "<p style='font-size: 18px;'><a href='$login_url' target='_blank' style='color: #4CAF50; text-decoration: none; font-weight: bold;'>
$login_url</a></p>";

echo "<table style='margin-top: 20px;'>";
echo "<tr><th>Field</th><th>Value</th></tr>";
echo "<tr><td><strong>Username</strong></td><td><code style='font-size: 16px; background: #fff; padding: 5px;'>pnbanjarbaru</code></td></tr>";
echo "<tr><td><strong>Password</strong></td><td><code style='font-size: 16px; background: #fff; padding: 5px;'>banjarbaru123</code></td></tr>";
echo "<tr><td><strong>Role</strong></td><td>admin</td></tr>";
echo "<tr><td><strong>Pengadilan</strong></td><td>PN BANJARBARU</td></tr>";
echo "</table>";

echo "<p style='margin-top: 20px;'><a href='$login_url' target='_blank' style='
    display: inline-block;
    background: #4CAF50;
    color: white;
    padding: 15px 30px;
    text-decoration: none;
    border-radius: 5px;
    font-size: 18px;
    font-weight: bold;
'>🚀 KLIK DI SINI UNTUK LOGIN</a></p>";

echo "</div>";

// ============================================
// 10. TROUBLESHOOTING
// ============================================
echo "<h3>10. Troubleshooting</h3>";
echo "<ul>";
echo "<li>Jika tetap tidak bisa login, <strong>clear browser cache dan cookies</strong></li>";
echo "<li>Jika ada captcha cooldown, tunggu 3 menit atau akses: <a href='$base_url/index.php/auth/clear_cooldown'>Clear Cooldown</a></li>";
echo "<li>Pastikan password diketik: <code>banjarbaru123</code> (huruf kecil semua)</li>";
echo "<li>Jika masih error, jalankan script ini lagi: <a href=''>Refresh</a></li>";
echo "</ul>";

$active_conn->close();

echo "<hr>";
echo "<p style='text-align: center;'><strong>Debug completed at: " . date('Y-m-d H:i:s') . "</strong></p>";
