<?php
session_start();
include("../../config/database.php");

// Generate CAPTCHA sederhana
if (empty($_SESSION['captcha'])) {
    $_SESSION['captcha'] = rand(1000, 9999); // angka 4 digit
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $captcha_input = $_POST['captcha'];

    // Cek CAPTCHA
    if ($captcha_input != $_SESSION['captcha']) {
        $error = "Kode CAPTCHA salah!";
    } else {
        // Ambil user dari database
        $sql = "SELECT * FROM users WHERE username=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            // Cek password
            if (password_verify($password, $user['password'])) {
                $_SESSION['user'] = $user;

                // Reset CAPTCHA
                unset($_SESSION['captcha']);

                // Redirect berdasarkan role
                if ($user['role'] === 'admin') {
                    header("Location: ../admin/dashboard_admin.php");
                } else {
                    header("Location: ../user/dashboard_user1.php");
                }
                exit();
            } else {
                $error = "Username atau password salah!";
            }
        } else {
            $error = "Username atau password salah!";
        }
    }

    // Generate ulang CAPTCHA setiap POST
    $_SESSION['captcha'] = rand(1000, 9999);
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Aplikasi Perkara</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap');

        body {
            background: linear-gradient(rgba(20, 21, 20, 0.85), rgba(2, 87, 2, 0.85)), url('https://i.pinimg.com/originals/12/83/86/12838649a270c20c3d402fcc5ee9ca16.jpg');
            background-size: cover;
            background-position: center;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Poppins', sans-serif;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.25);
            overflow: hidden;
            max-width: 850px;
            width: 100%;
        }

        .login-left {
            padding: 2.5rem;
        }

        .login-left h2 {
            font-weight: 700;
            font-size: 2rem;
            margin-bottom: 0.5rem;
            color: #006400;
            text-transform: uppercase;
        }

        .login-left p {
            color: #555;
            font-size: 0.9rem;
            margin-bottom: 1.5rem;
        }

        .form-control {
            border-radius: 12px;
            padding: 12px;
            font-size: 0.95rem;
        }

        .btn-login {
            background: linear-gradient(135deg, #00b300, #006400);
            border: none;
            border-radius: 12px;
            padding: 12px;
            font-size: 1rem;
            font-weight: 600;
            color: #fff;
            width: 100%;
            transition: 0.3s;
        }

        .btn-login:hover {
            background: linear-gradient(135deg, #009900, #004d00);
            transform: scale(1.03);
        }

        .captcha-box {
            font-size: 1.5rem;
            font-weight: bold;
            letter-spacing: 5px;
            background: #e6ffe6;
            text-align: center;
            border-radius: 8px;
            padding: 8px;
            margin-bottom: 10px;
        }

        .login-right {
            background: rgba(248, 255, 248, 0.7);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .login-right img {
            max-width: 80%;
            height: auto;
            filter: drop-shadow(0px 6px 10px rgba(0, 0, 0, 0.2));
        }

        a {
            color: #008000;
            font-weight: 600;
        }

        a:hover {
            color: #004d00;
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="login-card row g-0">
        <!-- Kolom kiri -->
        <div class="col-md-6 login-left">
            <h2 class="text-center">LOGIN</h2>
            <hr>
            <p class="text-center text-muted">Sistem Informasi Perkara</p>

            <?php if (isset($error)): ?>
                <div class="alert alert-danger text-center"><?= $error ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" name="username" id="username" class="form-control" placeholder="Username" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
                        <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password')">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">CAPTCHA</label>
                    <div class="captcha-box"><?= $_SESSION['captcha'] ?></div>
                    <input type="text" name="captcha" class="form-control" placeholder="Masukkan kode di atas" required>
                </div>
                <button type="submit" class="btn btn-login">Login</button>
            </form>

            <div class="mt-3 text-center">
                <a href="register.php" class="text-decoration-none">Belum punya akun? Daftar</a>
            </div>
        </div>

        <!-- Kolom kanan -->
        <div class="col-md-6 login-right">
            <img src="../../assets/logo.png" alt="Ilustrasi Login">
        </div>
    </div>

    <script>
        function togglePassword(id) {
            const input = document.getElementById(id);
            const icon = event.currentTarget.querySelector("i");
            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove("bi-eye");
                icon.classList.add("bi-eye-slash");
            } else {
                input.type = "password";
                icon.classList.remove("bi-eye-slash");
                icon.classList.add("bi-eye");
            }
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>