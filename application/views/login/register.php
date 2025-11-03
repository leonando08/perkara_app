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

        .form-control,
        .form-select {
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

            <?= form_open('auth_simple/process_register', ['id' => 'registerForm']) ?>

            <div class="mb-3">
                <label class="form-label">Username <span class="text-danger">*</span></label>
                <input type="text" name="username" class="form-control" placeholder="Masukkan username" required maxlength="50" value="<?= set_value('username') ?>">
                <small class="form-text text-muted">Username untuk login ke sistem</small>
            </div>

            <div class="mb-3">
                <label class="form-label">Email <span class="text-danger">*</span></label>
                <input type="email" name="email" class="form-control" placeholder="Masukkan email" required maxlength="100" value="<?= set_value('email') ?>">
                <small class="form-text text-muted">Email harus valid dan belum terdaftar</small>
            </div>

            <div class="mb-3">
                <label class="form-label">Asal Pengadilan <span class="text-danger">*</span></label>
                <select name="pengadilan_id" class="form-select" required>
                    <option value="">-- Pilih Asal Pengadilan --</option>
                    <?php if (isset($pengadilan_list) && !empty($pengadilan_list)): ?>
                        <?php foreach ($pengadilan_list as $pengadilan): ?>
                            <option value="<?= $pengadilan->id ?>" <?= set_select('pengadilan_id', $pengadilan->id) ?>>
                                <?= $pengadilan->nama_pengadilan ?>
                            </option>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <option value="" disabled>Data pengadilan tidak tersedia</option>
                    <?php endif; ?>
                </select>
                <small class="form-text text-muted">Pilih asal pengadilan tempat Anda bertugas</small>
            </div>

            <div class="mb-3">
                <label class="form-label">Password <span class="text-danger">*</span></label>
                <div class="password-toggle">
                    <input type="password" id="password" name="password" class="form-control" placeholder="Password (min. 8 karakter)" required minlength="8">
                    <button type="button" class="password-toggle-btn" onclick="togglePassword('password')">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
                <div id="password-strength" class="mt-2"></div>
                <small class="form-text text-muted">
                    <strong>Password harus memenuhi kriteria:</strong><br>
                    <span id="length-check" class="text-muted">❌ Minimal 8 karakter</span><br>
                    <span id="upper-check" class="text-muted">❌ Minimal 1 huruf besar (A-Z)</span><br>
                    <span id="lower-check" class="text-muted">❌ Minimal 1 huruf kecil (a-z)</span><br>
                    <span id="number-check" class="text-muted">❌ Minimal 1 angka (0-9)</span><br>
                    <span id="special-check" class="text-muted">❌ Minimal 1 karakter khusus (!@#$%^&*)</span>
                </small>
            </div>

            <div class="mb-3">
                <label class="form-label">Konfirmasi Password <span class="text-danger">*</span></label>
                <div class="password-toggle">
                    <input type="password" id="confirm_password" name="confirm_password" class="form-control" placeholder="Ulangi password" required minlength="8">
                    <button type="button" class="password-toggle-btn" onclick="togglePassword('confirm_password')">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
                <small id="confirm-password-feedback" class="form-text text-muted">Konfirmasi password harus sama</small>
            </div> <button type="submit" class="btn btn-register" id="register-btn">
                <span id="register-text">Daftar</span>
                <span id="register-spinner" class="d-none">
                    <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                    Memproses...
                </span>
            </button>
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

        // Validasi password real-time
        function validatePassword(password) {
            const lengthCheck = password.length >= 8;
            const upperCheck = /[A-Z]/.test(password);
            const lowerCheck = /[a-z]/.test(password);
            const numberCheck = /[0-9]/.test(password);
            const specialCheck = /[!@#$%^&*(),.?":{}|<>]/.test(password);

            // Update UI untuk setiap kriteria
            document.getElementById('length-check').className = lengthCheck ? 'text-success' : 'text-danger';
            document.getElementById('length-check').innerHTML = (lengthCheck ? '✅' : '❌') + ' Minimal 8 karakter';

            document.getElementById('upper-check').className = upperCheck ? 'text-success' : 'text-danger';
            document.getElementById('upper-check').innerHTML = (upperCheck ? '✅' : '❌') + ' Minimal 1 huruf besar (A-Z)';

            document.getElementById('lower-check').className = lowerCheck ? 'text-success' : 'text-danger';
            document.getElementById('lower-check').innerHTML = (lowerCheck ? '✅' : '❌') + ' Minimal 1 huruf kecil (a-z)';

            document.getElementById('number-check').className = numberCheck ? 'text-success' : 'text-danger';
            document.getElementById('number-check').innerHTML = (numberCheck ? '✅' : '❌') + ' Minimal 1 angka (0-9)';

            document.getElementById('special-check').className = specialCheck ? 'text-success' : 'text-danger';
            document.getElementById('special-check').innerHTML = (specialCheck ? '✅' : '❌') + ' Minimal 1 karakter khusus (!@#$%^&*)';

            // Password strength indicator
            const strength = [lengthCheck, upperCheck, lowerCheck, numberCheck, specialCheck].filter(Boolean).length;
            const strengthDiv = document.getElementById('password-strength');

            if (strength === 0) {
                strengthDiv.innerHTML = '';
            } else if (strength <= 2) {
                strengthDiv.innerHTML = '<div class="alert alert-danger py-1 px-2 small">Password Lemah</div>';
            } else if (strength <= 4) {
                strengthDiv.innerHTML = '<div class="alert alert-warning py-1 px-2 small">Password Sedang</div>';
            } else {
                strengthDiv.innerHTML = '<div class="alert alert-success py-1 px-2 small">Password Kuat</div>';
            }

            return lengthCheck && upperCheck && lowerCheck && numberCheck && specialCheck;
        }

        document.addEventListener('DOMContentLoaded', function() {
            const passwordInput = document.getElementById('password');
            const confirmPasswordInput = document.getElementById('confirm_password');
            const registerForm = document.getElementById('registerForm');
            const registerBtn = document.getElementById('register-btn');
            const registerText = document.getElementById('register-text');
            const registerSpinner = document.getElementById('register-spinner');

            // Validasi password saat user mengetik
            passwordInput.addEventListener('input', function() {
                validatePassword(this.value);
            });

            // Validasi konfirmasi password saat user mengetik
            confirmPasswordInput.addEventListener('input', function() {
                const password = passwordInput.value;
                const confirmPassword = this.value;
                const feedback = document.getElementById('confirm-password-feedback');

                if (confirmPassword === '') {
                    feedback.className = 'form-text text-muted';
                    feedback.textContent = 'Konfirmasi password harus sama';
                } else if (password === confirmPassword) {
                    feedback.className = 'form-text text-success';
                    feedback.textContent = '✅ Password cocok';
                } else {
                    feedback.className = 'form-text text-danger';
                    feedback.textContent = '❌ Password tidak cocok';
                }
            });

            // Prevent multiple form submissions
            registerForm.addEventListener('submit', function(e) {
                if (registerBtn.disabled) {
                    e.preventDefault();
                    return false;
                }

                // Validate password strength
                const password = passwordInput.value;
                if (!validatePassword(password)) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'Password Tidak Valid!',
                        html: 'Password harus memenuhi semua kriteria:<br>' +
                            '• Minimal 8 karakter<br>' +
                            '• Minimal 1 huruf besar (A-Z)<br>' +
                            '• Minimal 1 huruf kecil (a-z)<br>' +
                            '• Minimal 1 angka (0-9)<br>' +
                            '• Minimal 1 karakter khusus (!@#$%^&*)',
                        confirmButtonColor: '#006400'
                    });
                    return false;
                }

                // Validate password match
                const confirmPassword = confirmPasswordInput.value;
                if (password !== confirmPassword) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'Password Tidak Cocok!',
                        text: 'Password dan konfirmasi password harus sama.',
                        confirmButtonColor: '#006400'
                    });
                    return false;
                }

                // Disable button and show spinner
                registerBtn.disabled = true;
                registerText.classList.add('d-none');
                registerSpinner.classList.remove('d-none');

                // Re-enable after 10 seconds to prevent permanent lock
                setTimeout(() => {
                    registerBtn.disabled = false;
                    registerText.classList.remove('d-none');
                    registerSpinner.classList.add('d-none');
                }, 10000);
            });
        });

        // SweetAlert notifications
        <?php if (validation_errors()): ?>
            Swal.fire({
                icon: 'error',
                title: 'Data Tidak Valid!',
                html: '<?= str_replace(["\n", "\r"], "<br>", addslashes(validation_errors())) ?>',
                confirmButtonColor: '#006400'
            });
        <?php endif; ?>

        <?php if (isset($error)): ?>
            Swal.fire({
                icon: 'error',
                title: 'Registrasi Gagal!',
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
                confirmButtonColor: '#28a745'
            }).then(() => {
                window.location.href = '<?= site_url('auth_simple/login') ?>';
            });
        <?php endif; ?>

        <?php if ($this->session->flashdata('error')): ?>
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '<?= addslashes($this->session->flashdata('error')) ?>',
                confirmButtonColor: '#006400'
            });
        <?php endif; ?>

        <?php if ($this->session->flashdata('info')): ?>
            Swal.fire({
                icon: 'info',
                title: 'Informasi',
                text: '<?= addslashes($this->session->flashdata('info')) ?>',
                confirmButtonColor: '#006400'
            });
        <?php endif; ?>
    </script>
</body>

</html>