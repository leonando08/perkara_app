<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Akun - Aplikasi Perkara</title>
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
            padding: 20px 0;
        }

        .register-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.25);
            overflow: hidden;
            max-width: 900px;
            width: 100%;
        }

        .register-left {
            padding: 2rem;
        }

        .register-left h2 {
            font-weight: 700;
            font-size: 1.8rem;
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

        .btn-back {
            background: linear-gradient(135deg, #6c757d, #495057);
            border: none;
            border-radius: 12px;
            padding: 12px;
            font-size: 1rem;
            font-weight: 600;
            color: #fff;
            width: 100%;
            transition: 0.3s;
        }

        .btn-back:hover {
            background: linear-gradient(135deg, #495057, #343a40);
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

        .form-text {
            font-size: 0.8rem;
        }
    </style>
</head>

<body>
    <div class="register-card row g-0">
        <div class="col-md-7 register-left">
            <h2 class="text-center">DAFTAR AKUN</h2>
            <hr>
            <p class="text-center text-muted">Sistem Informasi Perkara</p>

            <?= form_open('auth/register', ['id' => 'registerForm']) ?>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" name="nama_lengkap" class="form-control" placeholder="Nama Lengkap" required maxlength="100" value="<?= set_value('nama_lengkap') ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Username <span class="text-danger">*</span></label>
                    <input type="text" name="username" class="form-control" placeholder="Username" required maxlength="50" value="<?= set_value('username') ?>">
                    <div class="form-text">Username hanya boleh huruf, angka, dan underscore</div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control" placeholder="Email" required maxlength="100" value="<?= set_value('email') ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">NIP</label>
                    <input type="text" name="nip" class="form-control" placeholder="NIP (opsional)" maxlength="30" value="<?= set_value('nip') ?>">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Jabatan</label>
                    <input type="text" name="jabatan" class="form-control" placeholder="Jabatan (opsional)" maxlength="50" value="<?= set_value('jabatan') ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Pengadilan <span class="text-danger">*</span></label>
                    <select name="pengadilan_id" class="form-select" required>
                        <option value="">-- Pilih Pengadilan --</option>
                        <?php foreach ($pengadilan_list as $pengadilan): ?>
                            <option value="<?= $pengadilan->id ?>" <?= set_select('pengadilan_id', $pengadilan->id) ?>>
                                <?= $pengadilan->nama_pengadilan ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Password <span class="text-danger">*</span></label>
                    <div class="password-toggle">
                        <input type="password" id="password" name="password" class="form-control" placeholder="Password" required minlength="6" maxlength="100">
                        <button type="button" class="password-toggle-btn" onclick="togglePassword('password')">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                    <div class="form-text">Minimal 6 karakter</div>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Konfirmasi Password <span class="text-danger">*</span></label>
                    <div class="password-toggle">
                        <input type="password" id="confirm_password" name="confirm_password" class="form-control" placeholder="Konfirmasi Password" required minlength="6" maxlength="100">
                        <button type="button" class="password-toggle-btn" onclick="togglePassword('confirm_password')">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <button type="submit" class="btn btn-register" id="register-btn">
                        <span id="register-text">Daftar</span>
                        <span id="register-spinner" class="d-none">
                            <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                            Memproses...
                        </span>
                    </button>
                </div>
                <div class="col-md-6 mb-3">
                    <a href="<?= site_url('auth/login') ?>" class="btn btn-back">
                        <i class="bi bi-arrow-left"></i> Kembali ke Login
                    </a>
                </div>
            </div>
            <?= form_close() ?>

            <div class="mt-3 text-center">
                <small class="text-muted">Sudah punya akun? <a href="<?= site_url('auth/login') ?>" class="text-decoration-none">Login disini</a></small>
            </div>
        </div>
        <div class="col-md-5 register-right">
            <div class="text-center">
                <img src="<?= base_url('assets/logo.png') ?>" alt="Logo Pengadilan" class="mb-3">
                <h5 class="text-success">Bergabunglah dengan Sistem Informasi Perkara</h5>
                <p class="text-muted">Daftarkan akun Anda untuk mengakses sistem pengelolaan perkara banding.</p>
            </div>
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

        document.addEventListener('DOMContentLoaded', function() {
            const registerForm = document.getElementById('registerForm');
            const registerBtn = document.getElementById('register-btn');
            const registerText = document.getElementById('register-text');
            const registerSpinner = document.getElementById('register-spinner');

            // Prevent multiple form submissions
            registerForm.addEventListener('submit', function(e) {
                if (registerBtn.disabled) {
                    e.preventDefault();
                    return false;
                }

                // Validate password match
                const password = document.getElementById('password').value;
                const confirmPassword = document.getElementById('confirm_password').value;

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
                window.location.href = '<?= site_url('auth/login') ?>';
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
    </script>
</body>

</html>
