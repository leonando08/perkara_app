<?php

/**
 * DOCKER SETUP & DEBUG SCRIPT
 * URL: http://localhost:8080/docker_debug.php
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<style>
body { font-family: Arial; margin: 20px; background: #f5f5f5; }
.container { max-width: 1000px; margin: 0 auto; }
.card { background: white; padding: 20px; margin: 20px 0; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
h1 { color: #2196F3; margin-top: 0; }
h2 { color: #4CAF50; border-bottom: 2px solid #4CAF50; padding-bottom: 5px; }
.success { color: green; font-weight: bold; }
.error { color: red; font-weight: bold; }
.warning { color: orange; font-weight: bold; }
table { width: 100%; border-collapse: collapse; margin: 10px 0; }
th, td { padding: 10px; text-align: left; border: 1px solid #ddd; }
th { background: #4CAF50; color: white; }
.btn { display: inline-block; padding: 12px 24px; margin: 10px 5px; background: #4CAF50; color: white; text-decoration: none; border-radius: 5px; font-weight: bold; }
.btn:hover { background: #45a049; }
.btn-blue { background: #2196F3; }
.btn-blue:hover { background: #0b7dda; }
.info-box { background: #e3f2fd; border-left: 4px solid #2196F3; padding: 15px; margin: 15px 0; }
.success-box { background: #e8f5e9; border-left: 4px solid #4CAF50; padding: 15px; margin: 15px 0; }
.error-box { background: #ffebee; border-left: 4px solid #f44336; padding: 15px; margin: 15px 0; }
pre { background: #f4f4f4; padding: 15px; border-radius: 5px; overflow-x: auto; }
</style>";

echo "<div class='container'>";
echo "<div class='card'>";
echo "<h1>🐳 DOCKER SETUP & DEBUG - PERKARA APP</h1>";
echo "<p><strong>Current Time:</strong> " . date('Y-m-d H:i:s') . "</p>";
echo "<p><strong>Access URL:</strong> <code>http://localhost:8080/docker_debug.php</code></p>";
echo "</div>";

// ============================================
// 1. ENVIRONMENT CHECK
// ============================================
echo "<div class='card'>";
echo "<h2>1. 🖥️ Environment Check</h2>";
echo "<table>";
echo "<tr><th>Setting</th><th>Value</th></tr>";
echo "<tr><td>PHP Version</td><td>" . phpversion() . "</td></tr>";
echo "<tr><td>Server Software</td><td>" . ($_SERVER['SERVER_SOFTWARE'] ?? 'Unknown') . "</td></tr>";
echo "<tr><td>Server Name</td><td>" . ($_SERVER['SERVER_NAME'] ?? 'Unknown') . "</td></tr>";
echo "<tr><td>Server Port</td><td>" . ($_SERVER['SERVER_PORT'] ?? 'Unknown') . "</td></tr>";
echo "<tr><td>Document Root</td><td>" . ($_SERVER['DOCUMENT_ROOT'] ?? 'Unknown') . "</td></tr>";
echo "<tr><td>Script Path</td><td>" . __FILE__ . "</td></tr>";
echo "<tr><td>Environment</td><td>" . (getenv('CI_ENV') ?: 'development') . "</td></tr>";
echo "</table>";
echo "</div>";

// ============================================
// 2. DOCKER DATABASE CONNECTION TEST
// ============================================
echo "<div class='card'>";
echo "<h2>2. 🗄️ Database Connection Test (Docker)</h2>";

// Test Docker database connection
$docker_configs = [
    'Docker Internal (service name)' => [
        'host' => 'db',
        'user' => 'perkara_user',
        'pass' => 'perkara_pass',
        'db' => 'perkara_db'
    ],
    'Docker Root User' => [
        'host' => 'db',
        'user' => 'root',
        'pass' => 'root',
        'db' => 'perkara_db'
    ],
    'External Docker (localhost:3307)' => [
        'host' => 'localhost',
        'user' => 'perkara_user',
        'pass' => 'perkara_pass',
        'db' => 'perkara_db',
        'port' => 3307
    ]
];

$connected = false;
$active_conn = null;
$working_config = null;

foreach ($docker_configs as $config_name => $config) {
    echo "<strong>Testing: $config_name</strong><br>";

    $port = isset($config['port']) ? $config['port'] : 3306;
    $conn = @new mysqli($config['host'], $config['user'], $config['pass'], $config['db'], $port);

    if ($conn->connect_error) {
        echo "❌ <span class='error'>FAILED: " . $conn->connect_error . "</span><br><br>";
    } else {
        echo "✅ <span class='success'>SUCCESS!</span><br>";
        echo "Server: " . $conn->server_info . "<br>";
        echo "Host Info: " . $conn->host_info . "<br><br>";
        $connected = true;
        $active_conn = $conn;
        $working_config = $config;
        $working_config_name = $config_name;
        break;
    }
}

if (!$connected) {
    echo "<div class='error-box'>";
    echo "<h3>❌ Database Connection Failed!</h3>";
    echo "<p><strong>Possible causes:</strong></p>";
    echo "<ul>";
    echo "<li>Docker containers not running</li>";
    echo "<li>Database container not ready yet</li>";
    echo "<li>Wrong database credentials in docker-compose.yml</li>";
    echo "</ul>";
    echo "<p><strong>Solutions:</strong></p>";
    echo "<ol>";
    echo "<li>Check Docker containers: <code>docker ps</code></li>";
    echo "<li>Start containers: <code>docker-compose up -d</code></li>";
    echo "<li>Check container logs: <code>docker-compose logs db</code></li>";
    echo "<li>Wait 30-60 seconds for MySQL to initialize</li>";
    echo "</ol>";
    echo "</div>";
} else {
    echo "<div class='success-box'>";
    echo "<h3>✅ Database Connected!</h3>";
    echo "<p><strong>Using config:</strong> $working_config_name</p>";
    echo "<p><strong>Host:</strong> {$working_config['host']}</p>";
    echo "<p><strong>User:</strong> {$working_config['user']}</p>";
    echo "<p><strong>Database:</strong> {$working_config['db']}</p>";
    echo "</div>";
}
echo "</div>";

// ============================================
// 3. FILE STRUCTURE CHECK
// ============================================
echo "<div class='card'>";
echo "<h2>3. 📁 File Structure Check</h2>";

$critical_files = [
    'index.php' => 'Main entry point',
    'application/config/config.php' => 'Main configuration',
    'application/config/database.php' => 'Database configuration',
    'application/controllers/Auth.php' => 'Authentication controller',
    'application/models/User_model.php' => 'User model',
    'vendor/autoload.php' => 'Composer autoloader',
    '.htaccess' => 'URL rewrite rules'
];

echo "<table>";
echo "<tr><th>File</th><th>Status</th><th>Description</th></tr>";

foreach ($critical_files as $file => $desc) {
    $exists = file_exists(__DIR__ . '/' . $file);
    $status = $exists ? "✅ Exists" : "❌ Missing";
    $status_class = $exists ? 'success' : 'error';

    echo "<tr>";
    echo "<td><code>$file</code></td>";
    echo "<td><span class='$status_class'>$status</span></td>";
    echo "<td>$desc</td>";
    echo "</tr>";
}
echo "</table>";
echo "</div>";

// ============================================
// 4. DOCKER-SPECIFIC SETUP
// ============================================
if ($connected) {
    echo "<div class='card'>";
    echo "<h2>4. 🛠️ Docker Database Setup</h2>";

    // Check tables
    $tables = ['users', 'pengadilan', 'perkara_banding', 'jenis_perkara'];
    echo "<h3>Table Status:</h3>";
    echo "<table>";
    echo "<tr><th>Table</th><th>Status</th><th>Rows</th></tr>";

    $tables_exist = [];
    foreach ($tables as $table) {
        $check = $active_conn->query("SHOW TABLES LIKE '$table'");
        if ($check && $check->num_rows > 0) {
            $count_result = $active_conn->query("SELECT COUNT(*) as count FROM `$table`");
            $count = $count_result ? $count_result->fetch_assoc()['count'] : 'Error';
            echo "<tr><td>$table</td><td class='success'>✅ Exists</td><td>$count</td></tr>";
            $tables_exist[$table] = true;
        } else {
            echo "<tr><td>$table</td><td class='error'>❌ Missing</td><td>-</td></tr>";
            $tables_exist[$table] = false;
        }
    }
    echo "</table>";

    // Auto-create missing tables
    if (!$tables_exist['pengadilan']) {
        echo "<h3>Creating pengadilan table...</h3>";
        $sql = "CREATE TABLE IF NOT EXISTS `pengadilan` (
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
            echo "✅ <span class='success'>Table pengadilan created</span><br>";
        } else {
            echo "❌ <span class='error'>Error: " . $active_conn->error . "</span><br>";
        }

        // Insert sample data
        $sql = "INSERT IGNORE INTO `pengadilan` (`kode_pengadilan`, `nama_pengadilan`, `alamat`, `telepon`, `email`) VALUES
        ('PN-BJB', 'PN BANJARBARU', 'Jl. A. Yani Km. 35, Banjarbaru', '0511-1234567', 'info@pn-banjarbaru.go.id'),
        ('PN-JKT', 'Pengadilan Negeri Jakarta Pusat', 'Jl. Gajah Mada No. 17, Jakarta Pusat', '021-12345678', 'info@pn-jakpus.go.id')";

        if ($active_conn->query($sql)) {
            echo "✅ <span class='success'>Sample pengadilan data inserted</span><br>";
        }
    }

    // Add columns to users table if missing
    echo "<h3>Checking users table structure...</h3>";
    $columns_to_add = [
        'pengadilan_id' => "ALTER TABLE `users` ADD COLUMN `pengadilan_id` int(11) DEFAULT NULL AFTER `role`",
        'nip' => "ALTER TABLE `users` ADD COLUMN `nip` varchar(50) DEFAULT NULL AFTER `pengadilan_id`",
        'jabatan' => "ALTER TABLE `users` ADD COLUMN `jabatan` varchar(100) DEFAULT NULL AFTER `nip`",
        'nama' => "ALTER TABLE `users` ADD COLUMN `nama` varchar(100) DEFAULT NULL AFTER `nama_lengkap`"
    ];

    foreach ($columns_to_add as $col_name => $sql) {
        $check = $active_conn->query("SHOW COLUMNS FROM `users` LIKE '$col_name'");
        if (!$check || $check->num_rows == 0) {
            if ($active_conn->query($sql)) {
                echo "✅ <span class='success'>Column $col_name added</span><br>";
            } else {
                echo "❌ <span class='error'>Error adding $col_name: " . $active_conn->error . "</span><br>";
            }
        } else {
            echo "✅ Column $col_name already exists<br>";
        }
    }

    // Create/Update user pnbanjarbaru
    echo "<h3>Creating/Updating user: pnbanjarbaru...</h3>";

    $pengadilan_result = $active_conn->query("SELECT id FROM pengadilan WHERE kode_pengadilan = 'PN-BJB' LIMIT 1");
    $pengadilan_id = $pengadilan_result ? $pengadilan_result->fetch_assoc()['id'] : 1;

    $password_hash = password_hash('banjarbaru123', PASSWORD_DEFAULT);

    $check_user = $active_conn->query("SELECT id FROM users WHERE username = 'pnbanjarbaru'");

    if ($check_user && $check_user->num_rows > 0) {
        // Update existing user
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

        if ($active_conn->query($sql)) {
            echo "✅ <span class='success'>User pnbanjarbaru updated</span><br>";
        } else {
            echo "❌ <span class='error'>Error updating user: " . $active_conn->error . "</span><br>";
        }
    } else {
        // Create new user
        $sql = "INSERT INTO `users` (
            `username`, `password`, `role`, `email`, `nama_lengkap`, `nama`,
            `pengadilan_id`, `nip`, `jabatan`, `created_at`
        ) VALUES (
            'pnbanjarbaru', '$password_hash', 'admin', 'admin@pn-banjarbaru.go.id',
            'Administrator PN Banjarbaru', 'Admin Banjarbaru',
            $pengadilan_id, '198501012010011001', 'Administrator', NOW()
        )";

        if ($active_conn->query($sql)) {
            echo "✅ <span class='success'>User pnbanjarbaru created</span><br>";
        } else {
            echo "❌ <span class='error'>Error creating user: " . $active_conn->error . "</span><br>";
        }
    }

    echo "</div>";
}

// ============================================
// 5. CONFIGURATION STATUS
// ============================================
echo "<div class='card'>";
echo "<h2>5. ⚙️ Configuration Status</h2>";

// Check config files
$config_status = [];

// Database config
if (file_exists(__DIR__ . '/application/config/database.php')) {
    require_once __DIR__ . '/application/config/database.php';
    $config_status['Database Config'] = [
        'file' => 'application/config/database.php',
        'hostname' => $db['default']['hostname'] ?? 'Not set',
        'username' => $db['default']['username'] ?? 'Not set',
        'database' => $db['default']['database'] ?? 'Not set'
    ];
}

// Main config
if (file_exists(__DIR__ . '/application/config/config.php')) {
    $config_content = file_get_contents(__DIR__ . '/application/config/config.php');
    preg_match('/\$config\[\'base_url\'\]\s*=\s*[\'"]([^\'"]+)[\'"]/', $config_content, $matches);
    $base_url = $matches[1] ?? 'Not found';

    $config_status['Main Config'] = [
        'file' => 'application/config/config.php',
        'base_url' => $base_url
    ];
}

echo "<table>";
echo "<tr><th>Config Type</th><th>Setting</th><th>Value</th></tr>";

foreach ($config_status as $type => $settings) {
    $first = true;
    foreach ($settings as $key => $value) {
        if ($key === 'file') continue;

        echo "<tr>";
        if ($first) {
            echo "<td rowspan='" . (count($settings) - 1) . "'><strong>$type</strong><br><code>{$settings['file']}</code></td>";
            $first = false;
        }
        echo "<td>$key</td>";
        echo "<td><code>$value</code></td>";
        echo "</tr>";
    }
}
echo "</table>";
echo "</div>";

// ============================================
// 6. FINAL VERIFICATION & LOGIN
// ============================================
if ($connected) {
    echo "<div class='card'>";
    echo "<h2>6. 🎯 Final Verification & Login</h2>";

    // Verify user
    $verify = $active_conn->query("
    SELECT 
        u.id, u.username, u.role, u.email, u.nama_lengkap, u.nama,
        u.nip, u.jabatan, p.nama_pengadilan, p.kode_pengadilan
    FROM users u
    LEFT JOIN pengadilan p ON p.id = u.pengadilan_id
    WHERE u.username = 'pnbanjarbaru'
    ");

    if ($verify && $verify->num_rows > 0) {
        $user = $verify->fetch_assoc();

        echo "<div class='success-box'>";
        echo "<h3>✅ User Verification Success!</h3>";
        echo "<table>";
        echo "<tr><th>Field</th><th>Value</th></tr>";
        foreach ($user as $key => $value) {
            echo "<tr><td><strong>$key</strong></td><td>" . ($value ?? '<em>NULL</em>') . "</td></tr>";
        }
        echo "</table>";
        echo "</div>";

        // Password verification
        $password_test = 'banjarbaru123';
        $hash_result = $active_conn->query("SELECT password FROM users WHERE username = 'pnbanjarbaru'");
        if ($hash_result) {
            $stored_hash = $hash_result->fetch_assoc()['password'];

            echo "<h3>Password Verification:</h3>";
            if (password_verify($password_test, $stored_hash)) {
                echo "<p>✅ <span class='success' style='font-size: 18px;'>Password verification SUCCESS!</span></p>";

                // Show login info
                echo "<div class='info-box'>";
                echo "<h3>🚀 Ready to Login!</h3>";
                echo "<p><strong>Login URL:</strong> <a href='http://localhost:8080/index.php/auth/login' target='_blank' style='font-size: 16px;'>http://localhost:8080/index.php/auth/login</a></p>";
                echo "<table style='margin-top: 15px;'>";
                echo "<tr><th>Field</th><th>Value</th></tr>";
                echo "<tr><td><strong>Username</strong></td><td><code style='font-size: 16px;'>pnbanjarbaru</code></td></tr>";
                echo "<tr><td><strong>Password</strong></td><td><code style='font-size: 16px;'>banjarbaru123</code></td></tr>";
                echo "<tr><td><strong>Role</strong></td><td>admin</td></tr>";
                echo "<tr><td><strong>Pengadilan</strong></td><td>PN BANJARBARU</td></tr>";
                echo "</table>";
                echo "<p style='margin-top: 20px;'>";
                echo "<a href='http://localhost:8080/index.php/auth/login' target='_blank' class='btn btn-blue' style='font-size: 18px; padding: 15px 30px;'>🔐 LOGIN NOW</a>";
                echo "</p>";
                echo "</div>";
            } else {
                echo "<p>❌ <span class='error'>Password verification FAILED!</span></p>";
            }
        }
    } else {
        echo "<div class='error-box'>";
        echo "<h3>❌ User Verification Failed</h3>";
        echo "<p>User 'pnbanjarbaru' not found or cannot be created.</p>";
        echo "</div>";
    }

    $active_conn->close();
    echo "</div>";
}

// ============================================
// 7. DOCKER COMMANDS
// ============================================
echo "<div class='card'>";
echo "<h2>7. 🐳 Useful Docker Commands</h2>";
echo "<div class='info-box'>";
echo "<h3>Container Management:</h3>";
echo "<pre>";
echo "# Start containers\n";
echo "docker-compose up -d\n\n";
echo "# Stop containers\n";
echo "docker-compose down\n\n";
echo "# Check running containers\n";
echo "docker ps\n\n";
echo "# View container logs\n";
echo "docker-compose logs web\n";
echo "docker-compose logs db\n\n";
echo "# Restart specific service\n";
echo "docker-compose restart web\n";
echo "docker-compose restart db\n\n";
echo "# Access MySQL from outside container\n";
echo "mysql -h localhost -P 3307 -u perkara_user -p perkara_db\n";
echo "# Password: perkara_pass\n";
echo "</pre>";
echo "</div>";

echo "<h3>Quick Links:</h3>";
echo "<p>";
echo "<a href='http://localhost:8080/' class='btn'>🏠 Home</a>";
echo "<a href='http://localhost:8080/index.php/auth/login' class='btn btn-blue'>🔐 Login</a>";
echo "<a href='http://localhost:8080/docker_debug.php' class='btn'>🔄 Refresh Debug</a>";
echo "</p>";
echo "</div>";

echo "</div>"; // End container
