<?php $this->load->view('navbar/header'); ?>

<div class="content-wrapper">
    <!-- Page Header -->
    <div class="content-card mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-1">
                    <i class="fas fa-user-plus me-2 text-primary"></i>
                    Tambah User Baru
                </h4>
                <p class="text-muted mb-0">Buat akun pengguna baru untuk sistem</p>
            </div>
            <a href="<?= site_url('admin/kelola_user') ?>" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i>
                Kembali
            </a>
        </div>
    </div>

    <!-- Form Card -->
    <div class="content-card">
        <div class="card-body">
            <!-- Alert Messages with SweetAlert -->
            <?php if (!empty($error)): ?>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            html: '<?= addslashes($error) ?>',
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#dc3545'
                        });
                    });
                </script>
            <?php endif; ?>

            <?php if (!empty($success)): ?>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: '<?= addslashes($success) ?>',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            toast: true,
                            position: 'top-end'
                        });
                    });
                </script>
            <?php endif; ?>

            <!-- Form -->
            <form method="post" action="<?= site_url('admin/tambah_user') ?>" id="userForm">
                <div class="row">
                    <!-- Username Field -->
                    <div class="col-md-6 mb-3">
                        <label for="username" class="form-label">
                            <i class="fas fa-user me-1"></i>
                            Username <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                            class="form-control"
                            id="username"
                            name="username"
                            value="<?= set_value('username') ?>"
                            placeholder="Masukkan username"
                            required>
                        <div class="form-text">
                            <i class="fas fa-info-circle me-1"></i>
                            Username harus unik dan minimal 3 karakter
                        </div>
                    </div>

                    <!-- Role Field -->
                    <div class="col-md-6 mb-3">
                        <label for="role" class="form-label">
                            <i class="fas fa-user-tag me-1"></i>
                            Role <span class="text-danger">*</span>
                        </label>
                        <select class="form-select" id="role" name="role" required>
                            <option value="">Pilih Role</option>
                            <option value="admin" <?= set_select('role', 'admin') ?>>
                                <i class="fas fa-user-shield"></i> Administrator
                            </option>
                            <option value="user" <?= set_select('role', 'user') ?>>
                                <i class="fas fa-user"></i> User Biasa
                            </option>
                        </select>
                        <div class="form-text">
                            <i class="fas fa-info-circle me-1"></i>
                            Admin memiliki akses penuh, User hanya dapat mengelola data sendiri
                        </div>
                    </div>

                    <!-- Password Field -->
                    <div class="col-md-6 mb-3">
                        <label for="password" class="form-label">
                            <i class="fas fa-lock me-1"></i>
                            Password <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <input type="password"
                                class="form-control"
                                id="password"
                                name="password"
                                placeholder="Masukkan password"
                                required>
                            <button class="btn btn-outline-secondary"
                                type="button"
                                id="togglePassword">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <div class="form-text">
                            <i class="fas fa-info-circle me-1"></i>
                            Password minimal 6 karakter untuk keamanan
                        </div>
                    </div>

                    <!-- Confirm Password Field -->
                    <div class="col-md-6 mb-3">
                        <label for="confirm_password" class="form-label">
                            <i class="fas fa-lock me-1"></i>
                            Konfirmasi Password <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <input type="password"
                                class="form-control"
                                id="confirm_password"
                                name="confirm_password"
                                placeholder="Ulangi password"
                                required>
                            <button class="btn btn-outline-secondary"
                                type="button"
                                id="toggleConfirmPassword">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <div class="form-text">
                            <i class="fas fa-info-circle me-1"></i>
                            Pastikan password sama dengan yang di atas
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="d-flex justify-content-between mt-4 pt-3 border-top">
                    <a href="<?= site_url('admin/kelola_user') ?>" class="btn btn-secondary">
                        <i class="fas fa-times me-1"></i>
                        Batal
                    </a>
                    <div>
                        <button type="reset" class="btn btn-outline-warning me-2">
                            <i class="fas fa-undo me-1"></i>
                            Reset
                        </button>
                        <button type="submit" class="btn btn-primary" id="submitBtn">
                            <i class="fas fa-save me-1"></i>
                            Simpan User
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Info Card -->
    <div class="content-card mt-4">
        <div class="card-body">
            <h6 class="card-title">
                <i class="fas fa-info-circle text-info me-2"></i>
                Informasi Tambahan
            </h6>
            <div class="row">
                <div class="col-md-4">
                    <div class="d-flex align-items-center mb-2">
                        <i class="fas fa-user-shield text-primary me-2"></i>
                        <strong>Administrator</strong>
                    </div>
                    <small class="text-muted">
                        Dapat mengelola semua data perkara, user, dan pengaturan sistem
                    </small>
                </div>
                <div class="col-md-4">
                    <div class="d-flex align-items-center mb-2">
                        <i class="fas fa-user text-success me-2"></i>
                        <strong>User Biasa</strong>
                    </div>
                    <small class="text-muted">
                        Hanya dapat mengelola data perkara yang dibuat sendiri
                    </small>
                </div>
                <div class="col-md-4">
                    <div class="d-flex align-items-center mb-2">
                        <i class="fas fa-shield-alt text-warning me-2"></i>
                        <strong>Keamanan</strong>
                    </div>
                    <small class="text-muted">
                        Password akan di-enkripsi secara otomatis untuk keamanan
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Custom JavaScript -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle password visibility
        const togglePassword = document.getElementById('togglePassword');
        const password = document.getElementById('password');
        const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
        const confirmPassword = document.getElementById('confirm_password');

        togglePassword.addEventListener('click', function() {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.innerHTML = type === 'password' ? '<i class="fas fa-eye"></i>' : '<i class="fas fa-eye-slash"></i>';
        });

        toggleConfirmPassword.addEventListener('click', function() {
            const type = confirmPassword.getAttribute('type') === 'password' ? 'text' : 'password';
            confirmPassword.setAttribute('type', type);
            this.innerHTML = type === 'password' ? '<i class="fas fa-eye"></i>' : '<i class="fas fa-eye-slash"></i>';
        });

        // Form validation
        const form = document.getElementById('userForm');
        const submitBtn = document.getElementById('submitBtn');

        form.addEventListener('submit', function(e) {
            const username = document.getElementById('username').value.trim();
            const role = document.getElementById('role').value;
            const passwordVal = password.value;
            const confirmPasswordVal = confirmPassword.value;

            // Basic validation dengan SweetAlert
            if (username.length < 3) {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Username Tidak Valid',
                    text: 'Username minimal 3 karakter!',
                    confirmButtonColor: '#ffc107'
                });
                return false;
            }

            if (passwordVal.length < 6) {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Password Tidak Valid',
                    text: 'Password minimal 6 karakter!',
                    confirmButtonColor: '#ffc107'
                });
                return false;
            }

            if (passwordVal !== confirmPasswordVal) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Password Tidak Sama',
                    text: 'Password dan konfirmasi password tidak sama!',
                    confirmButtonColor: '#dc3545'
                });
                return false;
            }

            if (!role) {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Role Belum Dipilih',
                    text: 'Pilih role untuk user!',
                    confirmButtonColor: '#ffc107'
                });
                return false;
            }

            // Show loading state dengan SweetAlert
            Swal.fire({
                title: 'Menyimpan User...',
                text: 'Mohon tunggu sebentar',
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
        });

        // Real-time password match validation
        confirmPassword.addEventListener('input', function() {
            if (this.value !== password.value) {
                this.setCustomValidity('Password tidak sama');
                this.classList.add('is-invalid');
            } else {
                this.setCustomValidity('');
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
            }
        });

        password.addEventListener('input', function() {
            if (confirmPassword.value && this.value !== confirmPassword.value) {
                confirmPassword.setCustomValidity('Password tidak sama');
                confirmPassword.classList.add('is-invalid');
            } else if (confirmPassword.value) {
                confirmPassword.setCustomValidity('');
                confirmPassword.classList.remove('is-invalid');
                confirmPassword.classList.add('is-valid');
            }
        });
    });
</script>

<?php $this->load->view('navbar/footer'); ?>