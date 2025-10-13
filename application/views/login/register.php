<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register - Aplikasi Perkara</title>
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

        .register-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.25);
            overflow: hidden;
            max-width: 850px;
            width: 100%;
        }

        .register-left {
            padding: 2.5rem;
        }

        .register-left h2 {
            font-weight: 700;
            font-size: 2rem;
            margin-bottom: 0.5rem;
            color: #006400;
            text-transform: uppercase;
        }

        .register-left p {
            color: #555;
            font-size: 0.9rem;
            margin-bottom: 1.5rem;
        }

        .form-control {
            border-radius: 12px;
            padding: 12px;
            font-size: 0.95rem;
        }

        .btn-register {
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

        .btn-register:hover {
            background: linear-gradient(135deg, #009900, #004d00);
            transform: scale(1.03);
        }

        .register-right {
            background: rgba(248, 255, 248, 0.7);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .register-right img {
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
    <div class="register-card row g-0">
        <div class="col-md-6 register-left">
            <h2 class="text-center">REGISTER</h2>
            <hr>
            <p class="text-center text-muted">Daftar Akun Baru</p>

            <?= form_open('auth/register') ?>
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" placeholder="Username" value="<?= set_value('username') ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <div class="password-toggle">
                    <input type="password" id="password" name="password" class="form-control" placeholder="Password (min. 6 karakter)" required>
                    <button type="button" class="password-toggle-btn" onclick="togglePassword('password')">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Konfirmasi Password</label>
                <div class="password-toggle">
                    <input type="password" id="confirm_password" name="confirm_password" class="form-control" placeholder="Konfirmasi Password" required>
                    <button type="button" class="password-toggle-btn" onclick="togglePassword('confirm_password')">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
            </div>
            <button type="submit" class="btn btn-register">Daftar</button>
            <?= form_close() ?>

            <div class="mt-3 text-center">
                <a href="<?= site_url('auth/login') ?>" class="text-decoration-none">Sudah punya akun? Login</a>
            </div>
        </div>
        <div class="col-md-6 register-right">
            <img src="<?= base_url('assets/logo.png') ?>" alt="Ilustrasi Register">
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
                title: 'Registrasi Gagal!',
                text: '<?= addslashes($error) ?>',
                confirmButtonColor: '#006400'
            });
        <?php endif; ?>

        <?php if (validation_errors()): ?>
            Swal.fire({
                icon: 'error',
                title: 'Validasi Gagal!',
                html: '<?= addslashes(str_replace(array("\n", "\r"), '<br>', validation_errors())) ?>',
                confirmButtonColor: '#006400'
            });
        <?php endif; ?>
    </script>
</body>

</html>