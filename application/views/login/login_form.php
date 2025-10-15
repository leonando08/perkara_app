<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Aplikasi Perkara</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap');

        body {
            background: linear-gradient(rgba(15, 27, 15, 0.85), rgba(10, 76, 10, 0.85)),
                url('<?php echo base_url('assets/bg2.jpg'); ?>');
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
            font-family: 'Courier New', monospace;
            font-size: 1.1rem;
            font-weight: bold;
            letter-spacing: 3px;
            background: linear-gradient(135deg, #e6e6e6, #ffffff);
            text-align: center;
            border-radius: 8px;
            padding: 10px;
            margin-bottom: 10px;
            position: relative;
            overflow: hidden;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
            color: #333;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
            user-select: none;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            cursor: default;
            width: 100%;
        }

        .captcha-box::before {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            left: 0;
            top: 0;
            background: repeating-linear-gradient(45deg,
                    transparent,
                    transparent 10px,
                    rgba(0, 0, 0, 0.05) 10px,
                    rgba(0, 0, 0, 0.05) 20px);
            pointer-events: none;
        }

        .captcha-box::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            left: 0;
            top: 0;
            background: linear-gradient(45deg,
                    transparent 25%,
                    rgba(255, 255, 255, 0.1) 25%,
                    rgba(255, 255, 255, 0.1) 50%,
                    transparent 50%,
                    transparent 75%,
                    rgba(255, 255, 255, 0.1) 75%);
            background-size: 4px 4px;
            pointer-events: none;
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

        .password-toggle {
            position: relative;
        }

        .password-toggle-btn {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #6c757d;
            cursor: pointer;
            padding: 0;
            font-size: 1.1rem;
        }

        .password-toggle-btn:hover {
            color: #495057;
        }
    </style>
</head>

<body>
    <div class="login-card row g-0">
        <div class="col-md-6 login-left">
            <h2 class="text-center">LOGIN</h2>
            <hr>
            <p class="text-center text-muted">Sistem Informasi Perkara</p>

            <?= form_open('auth/login') ?>
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" placeholder="Username" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <div class="password-toggle">
                    <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
                    <button type="button" class="password-toggle-btn" onclick="togglePassword('password')">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">CAPTCHA</label>
                <div class="captcha-box"><?= $this->session->userdata('captcha'); ?></div>
                <input type="text" name="captcha" class="form-control" placeholder="Masukkan kode di atas" required>
            </div>
            <button type="submit" class="btn btn-login">Login</button>
            <?= form_close() ?>


            <div class="mt-3 text-center">
                <a href="<?= site_url('auth/register') ?>" class="text-decoration-none">Belum punya akun? Daftar</a>
            </div>
        </div>
        <div class="col-md-6 login-right">
            <img src="<?= base_url('assets/logo.png') ?>" alt="Ilustrasi Login">
        </div>
    </div>

    <script>
        function togglePassword(id) {
            const input = document.getElementById(id);
            const icon = event.currentTarget.querySelector("i");
            if (input.type === "password") {
                input.type = "text";
                icon.classList.replace("bi-eye", "bi-eye-slash");
            } else {
                input.type = "password";
                icon.classList.replace("bi-eye-slash", "bi-eye");
            }
        }

        // SweetAlert notifications
        <?php if (isset($error)): ?>
            Swal.fire({
                icon: 'error',
                title: 'Login Gagal!',
                text: '<?= addslashes($error) ?>',
                confirmButtonColor: '#006400'
            });
        <?php endif; ?>

        <?php if ($this->session->flashdata('success')): ?>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '<?= addslashes($this->session->flashdata('success')) ?>',
                showConfirmButton: true,
                confirmButtonText: 'OK',
                confirmButtonColor: '#28a745',
                allowOutsideClick: false,
                allowEscapeKey: false
            });
        <?php endif; ?>

        // Mencegah akses ke captcha
        document.addEventListener('DOMContentLoaded', function() {
            const captchaBox = document.querySelector('.captcha-box');

            // Mencegah copy
            captchaBox.addEventListener('copy', function(e) {
                e.preventDefault();
                return false;
            });

            // Mencegah cut
            captchaBox.addEventListener('cut', function(e) {
                e.preventDefault();
                return false;
            });

            // Mencegah paste
            captchaBox.addEventListener('paste', function(e) {
                e.preventDefault();
                return false;
            });

            // Mencegah drag
            captchaBox.addEventListener('drag', function(e) {
                e.preventDefault();
                return false;
            });

            // Mencegah drop
            captchaBox.addEventListener('drop', function(e) {
                e.preventDefault();
                return false;
            });

            // Mencegah klik kanan
            captchaBox.addEventListener('contextmenu', function(e) {
                e.preventDefault();
                return false;
            });

            // Mencegah select
            captchaBox.addEventListener('selectstart', function(e) {
                e.preventDefault();
                return false;
            });
        });
    </script>
</body>

</html>