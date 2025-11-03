<?php

/**
 * Simple PHP Info Test
 * URL: http://localhost/Perkara_app/phpinfo_test.php
 */

echo "<h1>PHP Info Test</h1>";
echo "<hr>";

// Test 1: PHP Version
echo "<h2>1. PHP is Working!</h2>";
echo "PHP Version: " . phpversion() . "<br>";
echo "Server: " . $_SERVER['SERVER_SOFTWARE'] . "<br>";
echo "Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "<br>";
echo "<hr>";

// Test 2: Database Connection
echo "<h2>2. Database Connection Test</h2>";
$conn = @new mysqli('localhost', 'root', '', 'perkara_db');
if ($conn->connect_error) {
    echo "❌ Connection failed: " . $conn->connect_error . "<br>";
} else {
    echo "✅ Database connected successfully!<br>";
    echo "MySQL Version: " . $conn->server_info . "<br>";
    $conn->close();
}
echo "<hr>";

// Test 3: Check if application folder exists
echo "<h2>3. Folder Structure Test</h2>";
$folders = ['application', 'system', 'assets', 'vendor'];
foreach ($folders as $folder) {
    if (is_dir(__DIR__ . '/' . $folder)) {
        echo "✅ Folder '$folder' exists<br>";
    } else {
        echo "❌ Folder '$folder' NOT found<br>";
    }
}
echo "<hr>";

// Test 4: Check critical files
echo "<h2>4. Critical Files Test</h2>";
$files = [
    'index.php',
    'application/config/config.php',
    'application/config/database.php',
    'application/controllers/Auth.php'
];
foreach ($files as $file) {
    if (file_exists(__DIR__ . '/' . $file)) {
        echo "✅ File '$file' exists<br>";
    } else {
        echo "❌ File '$file' NOT found<br>";
    }
}
echo "<hr>";

// Test 5: Try to load CodeIgniter
echo "<h2>5. CodeIgniter Bootstrap Test</h2>";
try {
    define('ENVIRONMENT', 'development');

    if (file_exists(__DIR__ . '/application/config/database.php')) {
        require_once __DIR__ . '/application/config/database.php';
        echo "✅ database.php loaded<br>";

        if (isset($db['default'])) {
            echo "✅ Database config exists<br>";
            echo "Hostname: " . $db['default']['hostname'] . "<br>";
            echo "Username: " . $db['default']['username'] . "<br>";
            echo "Database: " . $db['default']['database'] . "<br>";
        }
    } else {
        echo "❌ database.php not found<br>";
    }
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>";
}
echo "<hr>";

echo "<h2>6. Next Steps</h2>";
echo "<p>If all tests above passed, try:</p>";
echo "<ul>";
echo "<li><a href='index.php/auth/login'>index.php/auth/login</a></li>";
echo "<li><a href='debug_full.php'>debug_full.php</a></li>";
echo "</ul>";

// phpinfo();
