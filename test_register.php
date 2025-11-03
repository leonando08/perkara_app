<?php
// Test registrasi sederhana
require_once 'index.php';

try {
    echo "<h1>Test Registrasi System</h1>";

    // Test database connection
    $db_config = include('application/config/database.php');
    echo "<h2>Database Config:</h2>";
    echo "<pre>";
    print_r($db_config['default']);
    echo "</pre>";

    // Test if we can access auth_simple/register
    echo "<h2>Test Link:</h2>";
    echo "<p><a href='index.php/auth_simple/register' target='_blank'>Test Register Form</a></p>";
    echo "<p><a href='index.php/auth_simple/test' target='_blank'>Test Auth Controller</a></p>";
} catch (Exception $e) {
    echo "<p>Error: " . $e->getMessage() . "</p>";
}
