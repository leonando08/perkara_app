<!DOCTYPE html>
<html>

<head>
    <title>Quick Access - Perkara App</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: #f5f5f5;
        }

        .card {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        h1 {
            color: #4CAF50;
            margin-top: 0;
        }

        .btn {
            display: inline-block;
            padding: 15px 30px;
            margin: 10px;
            background: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
        }

        .btn:hover {
            background: #45a049;
        }

        .btn-secondary {
            background: #2196F3;
        }

        .btn-secondary:hover {
            background: #0b7dda;
        }

        .info {
            background: #e8f5e9;
            padding: 15px;
            border-left: 4px solid #4CAF50;
            margin: 20px 0;
        }

        .error {
            background: #ffebee;
            padding: 15px;
            border-left: 4px solid #f44336;
            margin: 20px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background: #4CAF50;
            color: white;
        }
    </style>
</head>

<body>
    <div class="card">
        <h1>🚀 Perkara App - Quick Access</h1>
        <p><strong>Current Time:</strong> <?php echo date('Y-m-d H:i:s'); ?></p>
        <hr>

        <?php
        // Quick checks
        $checks = [];

        // Check PHP
        $checks['PHP Version'] = [
            'status' => version_compare(PHP_VERSION, '7.0', '>='),
            'value' => phpversion()
        ];

        // Check folders
        $checks['Application Folder'] = [
            'status' => is_dir(__DIR__ . '/application'),
            'value' => is_dir(__DIR__ . '/application') ? 'Exists' : 'Not Found'
        ];

        $checks['System Folder'] = [
            'status' => is_dir(__DIR__ . '/system'),
            'value' => is_dir(__DIR__ . '/system') ? 'Exists' : 'Not Found'
        ];

        $checks['Vendor Folder'] = [
            'status' => is_dir(__DIR__ . '/vendor'),
            'value' => is_dir(__DIR__ . '/vendor') ? 'Exists' : 'Not Found'
        ];

        // Check database
        $db_conn = @new mysqli('localhost', 'root', '', 'perkara_db');
        $checks['Database Connection'] = [
            'status' => !$db_conn->connect_error,
            'value' => $db_conn->connect_error ? 'Failed: ' . $db_conn->connect_error : 'Connected'
        ];
        if (!$db_conn->connect_error) {
            $db_conn->close();
        }

        // Display checks
        echo "<table>";
        echo "<tr><th>Check</th><th>Status</th><th>Details</th></tr>";

        $all_passed = true;
        foreach ($checks as $name => $check) {
            $status_icon = $check['status'] ? '✅' : '❌';
            $status_color = $check['status'] ? 'green' : 'red';
            echo "<tr>";
            echo "<td><strong>$name</strong></td>";
            echo "<td style='color: $status_color;'>$status_icon</td>";
            echo "<td>{$check['value']}</td>";
            echo "</tr>";

            if (!$check['status']) {
                $all_passed = false;
            }
        }
        echo "</table>";

        if ($all_passed) {
            echo "<div class='info'>";
            echo "<h3>✅ All checks passed!</h3>";
            echo "<p>System is ready. You can now access the application.</p>";
            echo "</div>";
        } else {
            echo "<div class='error'>";
            echo "<h3>❌ Some checks failed!</h3>";
            echo "<p>Please fix the issues above before proceeding.</p>";
            echo "</div>";
        }
        ?>

        <h2>Quick Access Links</h2>

        <a href="phpinfo_test.php" class="btn btn-secondary">📋 PHP Info Test</a>
        <a href="debug_full.php" class="btn btn-secondary">🔧 Full Debug & Setup</a>
        <br>
        <a href="index.php" class="btn">🏠 Home (index.php)</a>
        <a href="index.php/auth/login" class="btn">🔐 Login Page</a>

        <h2>📝 Login Credentials</h2>
        <div class="info">
            <table>
                <tr>
                    <th>Field</th>
                    <th>Value</th>
                </tr>
                <tr>
                    <td><strong>Username</strong></td>
                    <td><code>pnbanjarbaru</code></td>
                </tr>
                <tr>
                    <td><strong>Password</strong></td>
                    <td><code>banjarbaru123</code></td>
                </tr>
                <tr>
                    <td><strong>Role</strong></td>
                    <td>admin</td>
                </tr>
                <tr>
                    <td><strong>Pengadilan</strong></td>
                    <td>PN BANJARBARU</td>
                </tr>
            </table>
        </div>

        <h2>🛠️ Troubleshooting</h2>
        <ul>
            <li><strong>Internal Server Error?</strong>
                <ul>
                    <li>Run: <a href="phpinfo_test.php">phpinfo_test.php</a> to check basic PHP</li>
                    <li>Check if Laragon MySQL is running (green icon)</li>
                    <li>Check Apache error logs in: <code>c:\laragon\logs\apache_error.log</code></li>
                </ul>
            </li>
            <li><strong>Cannot connect to database?</strong>
                <ul>
                    <li>Make sure MySQL is running in Laragon</li>
                    <li>Create database 'perkara_db' via phpMyAdmin</li>
                    <li>Run: <a href="debug_full.php">debug_full.php</a> to auto-setup</li>
                </ul>
            </li>
            <li><strong>Login failed?</strong>
                <ul>
                    <li>Run: <a href="debug_full.php">debug_full.php</a> to create user</li>
                    <li>Clear browser cache (Ctrl+Shift+Delete)</li>
                    <li>Try incognito/private browsing mode</li>
                </ul>
            </li>
        </ul>

        <h2>📁 File Paths</h2>
        <table>
            <tr>
                <th>Path Type</th>
                <th>Location</th>
            </tr>
            <tr>
                <td>Document Root</td>
                <td><code><?php echo $_SERVER['DOCUMENT_ROOT']; ?></code></td>
            </tr>
            <tr>
                <td>Current Script</td>
                <td><code><?php echo __FILE__; ?></code></td>
            </tr>
            <tr>
                <td>Base URL</td>
                <td><code>http://<?php echo $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']); ?>/</code></td>
            </tr>
        </table>
    </div>
</body>

</html>