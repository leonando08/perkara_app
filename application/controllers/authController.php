<?php
session_start();
include("../config/database.php");

// LOGIN
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = hash('sha256', $_POST['password']);

    $sql = "SELECT * FROM users WHERE username=? AND password=? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        $_SESSION['user'] = $user;

        // Redirect berdasarkan role
        if ($user['role'] === 'admin') {
            header("Location: ../views/dashboard_admin.php");
        } else {
            header("Location: ../views/dashboard_user.php");
        }
        exit();
    } else {
        $error = "Username atau password salah!";
        $_SESSION['error'] = $error;
        header("Location: ../public/index.php");
        exit();
    }
}

// LOGOUT
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: ../public/index.php");
    exit();
}
