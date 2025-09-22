<?php
$host = "localhost";
$user = "root";   // default user XAMPP
$pass = "";       // default password XAMPP kosong
$db   = "perkara_db";

// Buat koneksi
$conn = new mysqli($host, $user, $pass, $db);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Optional: set charset biar aman untuk UTF-8
$conn->set_charset("utf8mb4");
