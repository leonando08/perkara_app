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

        .captcha-container {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 10px;
        }

        .captcha-image {
            border: 2px solid #ddd;
            border-radius: 8px;
            cursor: pointer;
            transition: border-color 0.3s;
        }

        .captcha-image:hover {
            border-color: #006400;
        }

        .captcha-refresh {
            background: #006400;
            border: none;
            border-radius: 8px;
            color: white;
            padding: 12px 16px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s ease;
            white-space: nowrap;
        }

        .captcha-refresh:hover {
            background: #004d00;
            transform: scale(1.05);
        }

        .captcha-refresh:active {
            transform: scale(0.95);
        }

        .captcha-refresh:disabled {
            background: #ccc !important;
            cursor: not-allowed !important;
            transform: none !important;
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

        /* Disabled states untuk cooldown */
        .btn-login:disabled {
            background: #6c757d !important;
            border-color: #6c757d !important;
            cursor: not-allowed !important;
            opacity: 0.7;
        }

        .form-control:disabled {
            background-color: #e9ecef;
            opacity: 0.7;
            cursor: not-allowed;
        }

        .captcha-refresh:disabled {
            background: #6c757d !important;
            cursor: not-allowed !important;
            opacity: 0.7;
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

            <?= form_open('auth_simple/login', ['id' => 'loginForm']) ?>

            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" placeholder="Username" required autocomplete="username" maxlength="50">
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <div class="password-toggle">
                    <input type="password" id="password" name="password" class="form-control" placeholder="Password" required autocomplete="current-password" maxlength="100">
                    <button type="button" class="password-toggle-btn" onclick="togglePassword('password')">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">CAPTCHA <span class="text-danger">*</span></label>
                <div class="captcha-container">
                    <img src="<?= site_url('auth/captcha') ?>?t=<?= time() ?>" alt="CAPTCHA" class="captcha-image" id="captcha-image" width="180" height="50" <?= isset($cooldown) && $cooldown ? 'style="opacity: 0.5;"' : '' ?>>
                    <button type="button" class="captcha-refresh" onclick="refreshCaptcha()" title="Klik untuk refresh captcha" <?= isset($cooldown) && $cooldown ? 'disabled' : '' ?>>
                        <i class="bi bi-arrow-clockwise"></i> Refresh
                    </button>
                </div>
                <input type="text" name="captcha" id="captcha-input" class="form-control" placeholder="<?= isset($cooldown) && $cooldown ? 'Captcha dinonaktifkan sementara' : 'Masukkan kode di atas' ?>" <?= isset($cooldown) && $cooldown ? 'disabled' : 'required' ?> autocomplete="off" maxlength="10" style="text-transform: uppercase;">
                <?php if (isset($cooldown) && $cooldown): ?>
                    <small class="text-danger"><i class="bi bi-clock"></i> Captcha dinonaktifkan karena terlalu banyak kesalahan</small>
                <?php else: ?>
                    <small class="text-muted">Klik gambar atau tombol refresh untuk mengganti captcha</small>
                <?php endif; ?>
            </div>
            <button type="submit" class="btn btn-login" id="login-btn" <?= isset($cooldown) && $cooldown ? 'disabled' : '' ?>>
                <span id="login-text"><?= isset($cooldown) && $cooldown ? 'Login Dinonaktifkan' : 'Login' ?></span>
                <span id="login-spinner" class="d-none">
                    <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                    Memproses...
                </span>
            </button>
            <?= form_close() ?>


            <div class="mt-3 text-center">
                <a href="<?= base_url('index.php/auth_simple/register') ?>" class="text-decoration-none">
                    Belum punya akun? Daftar di sini
                </a>
            </div>
        </div>
        <div class="col-md-6 login-right">
            <img src="<?= base_url('assets/logo.png') ?>" alt="Ilustrasi Login">
        </div>
    </div>

    <script>
        // Security: Disable F12, Ctrl+Shift+I, Ctrl+U
        document.addEventListener('keydown', function(e) {
            if (e.key === 'F12' ||
                (e.ctrlKey && e.shiftKey && e.key === 'I') ||
                (e.ctrlKey && e.key === 'u')) {
                e.preventDefault();
            }
        });

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

        function refreshCaptcha() {
            const captchaImage = document.getElementById('captcha-image');
            const captchaInput = document.getElementById('captcha-input');
            const refreshBtn = document.querySelector('.captcha-refresh');
            const timestamp = new Date().getTime();

            console.log('Refreshing captcha with timestamp:', timestamp);

            // Visual feedback - disable button temporarily
            refreshBtn.disabled = true;
            refreshBtn.style.opacity = '0.5';

            // Clear captcha input
            captchaInput.value = '';

            // Add loading effect
            captchaImage.style.opacity = '0.5';

            // Use dedicated refresh endpoint
            const newSrc = '<?= site_url('auth/refresh_captcha') ?>?' + timestamp;
            console.log('Loading new captcha:', newSrc);

            captchaImage.onload = function() {
                console.log('Captcha refreshed successfully');
                captchaImage.style.opacity = '1';
                refreshBtn.disabled = false;
                refreshBtn.style.opacity = '1';
            };

            captchaImage.onerror = function() {
                console.error('Failed to refresh captcha, trying fallback');
                // Fallback to regular captcha endpoint
                captchaImage.src = '<?= site_url('auth/captcha') ?>?' + timestamp;
                captchaImage.style.opacity = '1';
                refreshBtn.disabled = false;
                refreshBtn.style.opacity = '1';
            };

            captchaImage.src = newSrc;
        }

        // Auto uppercase captcha input
        document.addEventListener('DOMContentLoaded', function() {
            const captchaInput = document.getElementById('captcha-input');
            const captchaImage = document.getElementById('captcha-image');
            const loginForm = document.getElementById('loginForm');
            const loginBtn = document.getElementById('login-btn');
            const loginText = document.getElementById('login-text');
            const loginSpinner = document.getElementById('login-spinner');

            // Auto uppercase
            captchaInput.addEventListener('input', function() {
                this.value = this.value.toUpperCase();
            });

            // Refresh captcha on image click
            captchaImage.addEventListener('click', function() {
                console.log('Captcha image clicked - refreshing...');
                refreshCaptcha();
            });

            // Also add refresh on button click (redundant but safe)
            const refreshBtn = document.querySelector('.captcha-refresh');
            refreshBtn.addEventListener('click', function(e) {
                e.preventDefault();
                console.log('Refresh button clicked');
                refreshCaptcha();
            });

            // Handle captcha load error
            captchaImage.addEventListener('error', function() {
                console.log('Captcha failed to load, retrying in 2 seconds...');
                setTimeout(() => {
                    const timestamp = new Date().getTime();
                    captchaImage.src = '<?= site_url('auth/captcha') ?>?' + timestamp;
                }, 2000);
            });

            // Handle captcha load success
            captchaImage.addEventListener('load', function() {
                console.log('Captcha loaded successfully:', captchaImage.src);
            });

            // Prevent multiple form submissions
            loginForm.addEventListener('submit', function(e) {
                if (loginBtn.disabled) {
                    e.preventDefault();
                    return false;
                }

                // Disable button and show spinner
                loginBtn.disabled = true;
                loginText.classList.add('d-none');
                loginSpinner.classList.remove('d-none');

                // Re-enable after 10 seconds to prevent permanent lock
                setTimeout(() => {
                    loginBtn.disabled = false;
                    loginText.classList.remove('d-none');
                    loginSpinner.classList.add('d-none');
                }, 10000);
            }); // Security: Clear form on page visibility change
            document.addEventListener('visibilitychange', function() {
                if (document.hidden) {
                    // Optional: Clear sensitive data when tab is hidden
                    // document.getElementById('password').value = '';
                }
            });

            // Auto-refresh captcha every 4 minutes
            setInterval(refreshCaptcha, 240000);
        });

        // SweetAlert notifications
        <?php if (isset($error)): ?>
            <?php if (isset($cooldown) && $cooldown): ?>
                // Special handling untuk cooldown
                Swal.fire({
                    icon: 'warning',
                    title: 'Captcha Dinonaktifkan!',
                    text: '<?= addslashes($error) ?>',
                    confirmButtonColor: '#006400',
                    confirmButtonText: 'Mengerti',
                    timer: 8000,
                    timerProgressBar: true,
                    allowOutsideClick: false
                }).then(() => {
                    // Start countdown timer
                    startCooldownTimer(180); // 3 menit = 180 detik
                });
            <?php else: ?>
                Swal.fire({
                    icon: 'error',
                    title: 'Login Gagal!',
                    text: '<?= addslashes($error) ?>',
                    confirmButtonColor: '#006400',
                    timer: 5000,
                    timerProgressBar: true
                }).then(() => {
                    refreshCaptcha(); // Auto refresh captcha after error
                });
            <?php endif; ?>
        <?php endif; ?>

        function startCooldownTimer(seconds) {
            const loginBtn = document.getElementById('login-btn');
            const loginText = document.getElementById('login-text');
            const captchaInput = document.getElementById('captcha-input');

            const countdown = setInterval(() => {
                const minutes = Math.floor(seconds / 60);
                const secs = seconds % 60;

                loginText.textContent = `Menunggu ${minutes}:${secs.toString().padStart(2, '0')}`;
                captchaInput.placeholder = `Tunggu ${minutes}:${secs.toString().padStart(2, '0')} untuk mencoba lagi`;

                seconds--;

                if (seconds < 0) {
                    clearInterval(countdown);
                    // Update UI untuk menunjukkan cooldown selesai
                    loginText.textContent = 'Cooldown selesai, memuat ulang...';
                    captchaInput.placeholder = 'Memuat ulang halaman...';

                    // Delay reload untuk memastikan server reset attempts
                    setTimeout(() => {
                        window.location.reload();
                    }, 2000); // 2 detik delay
                }
            }, 1000);
        }

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

        <?php if ($this->session->flashdata('info')): ?>
            Swal.fire({
                icon: 'info',
                title: 'Informasi',
                text: '<?= addslashes($this->session->flashdata('info')) ?>',
                showConfirmButton: true,
                confirmButtonText: 'OK',
                confirmButtonColor: '#006400'
            });
        <?php endif; ?>
    </script>
</body>

</html>