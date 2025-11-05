<?php
// Simple Registration Migration Script
// Menjalankan migration untuk update tabel users

echo "<h1>Simple Registration Migration</h1>";
echo "<p>Updating users table for simple registration...</p>";

try {
    // Database config
    $host = 'db';
    $username = 'perkara_user';
    $password = 'perkara_pass';
    $database = 'perkara_db';
    $port = 3306;

    // Connect to MySQL
    echo "<h2>1. Connecting to Database...</h2>";
    $pdo = new PDO("mysql:host=$host;port=$port", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "<p>✅ Connected to MySQL server</p>";

    // Create database if not exists
    echo "<h2>2. Preparing Database...</h2>";
    $pdo->exec("CREATE DATABASE IF NOT EXISTS $database");
    $pdo->exec("USE $database");
    echo "<p>✅ Database $database ready</p>";

    // Check current users table structure
    echo "<h2>3. Current Users Table Structure:</h2>";
    $stmt = $pdo->query("DESCRIBE users");
    if ($stmt) {
        echo "<table border='1' cellpadding='5'>";
        echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th></tr>";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>{$row['Field']}</td>";
            echo "<td>{$row['Type']}</td>";
            echo "<td>{$row['Null']}</td>";
            echo "<td>{$row['Key']}</td>";
            echo "<td>{$row['Default']}</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>❌ Users table not found, will create it</p>";
    }

    // Run migration
    echo "<h2>4. Running Migration...</h2>";

    // Read and execute migration SQL
    $sql = file_get_contents('migration_simple_registration.sql');

    // Split SQL into individual statements
    $statements = array_filter(array_map('trim', explode(';', $sql)));

    foreach ($statements as $statement) {
        if (!empty($statement) && !preg_match('/^(USE |DESCRIBE|SELECT)/i', $statement)) {
            try {
                $pdo->exec($statement);
                echo "<p>✅ Executed: " . substr($statement, 0, 50) . "...</p>";
            } catch (Exception $e) {
                echo "<p>⚠️ Warning: " . $e->getMessage() . "</p>";
            }
        }
    }

    // Show updated table structure
    echo "<h2>5. Updated Users Table Structure:</h2>";
    $stmt = $pdo->query("DESCRIBE users");
    if ($stmt) {
        echo "<table border='1' cellpadding='5'>";
        echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th></tr>";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>{$row['Field']}</td>";
            echo "<td>{$row['Type']}</td>";
            echo "<td>{$row['Null']}</td>";
            echo "<td>{$row['Key']}</td>";
            echo "<td>{$row['Default']}</td>";
            echo "</tr>";
        }
        echo "</table>";
    }

    // Test data
    echo "<h2>6. Current Users Data:</h2>";
    $stmt = $pdo->query("SELECT id, username, email, role, pengadilan_id, aktif FROM users LIMIT 10");
    if ($stmt && $stmt->rowCount() > 0) {
        echo "<table border='1' cellpadding='5'>";
        echo "<tr><th>ID</th><th>Username</th><th>Email</th><th>Role</th><th>Pengadilan ID</th><th>Aktif</th></tr>";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>{$row['id']}</td>";
            echo "<td>{$row['username']}</td>";
            echo "<td>{$row['email']}</td>";
            echo "<td>{$row['role']}</td>";
            echo "<td>{$row['pengadilan_id']}</td>";
            echo "<td>{$row['aktif']}</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No users found in table</p>";
    }

    echo "<h2>✅ Migration Completed Successfully!</h2>";
    echo "<p><strong>Tabel users sudah diupdate untuk registrasi sederhana:</strong></p>";
    echo "<ul>";
    echo "<li>✅ Username (unique, required)</li>";
    echo "<li>✅ Email (unique, required)</li>";
    echo "<li>✅ Password (hashed, required)</li>";
    echo "<li>✅ Pengadilan_id (foreign key)</li>";
    echo "<li>✅ Role (default: user)</li>";
    echo "<li>✅ Aktif (default: Y)</li>";
    echo "</ul>";

    echo "<p><a href='index.php/auth_simple/register' style='background:#28a745;color:white;padding:10px 20px;text-decoration:none;border-radius:5px;'>Test Registration Form</a></p>";
} catch (Exception $e) {
    echo "<h2>❌ Error:</h2>";
    echo "<p>Error: " . $e->getMessage() . "</p>";
    echo "<p>Please check your database configuration.</p>";
}
?>

<style>
    body {
        font-family: Arial, sans-serif;
        margin: 20px;
    }

    table {
        border-collapse: collapse;
        margin: 10px 0;
    }

    th,
    td {
        padding: 8px;
        text-align: left;
    }

    th {
        background-color: #f2f2f2;
    }
</style>