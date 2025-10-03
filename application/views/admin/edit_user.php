<?php $this->load->view('navbar/header'); ?>

<div class="content-wrapper">
    <!-- Page Header -->
    <div class="content-card mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-1">
                    <i class="fas fa-user-edit me-2 text-warning"></i>
                    Edit User
                </h4>
                <p class="text-muted mb-0">Ubah informasi pengguna: <?= htmlspecialchars($user->username) ?></p>
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
            <!-- Alert Messages -->
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <?= $error ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (!empty($success)): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    <?= $success ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- Form -->
            <form method="post" action="<?= site_url('admin/edit_user/' . $user->id) ?>" id="editUserForm">
                <div class="row">
                    <!-- Current Info Card -->
                    <div class="col-md-4 mb-4">
                        <div class="card bg-light">
                            <div class="card-body text-center">
                                <i class="fas fa-user-circle fa-5x text-secondary mb-3"></i>
                                <h5><?= htmlspecialchars($user->username) ?></h5>
                                <p class="mb-1">
                                    <?php if ($user->role == 'admin'): ?>
                                        <span class="badge bg-primary">
                                            <i class="fas fa-user-shield me-1"></i>
                                            Administrator
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-success">
                                            <i class="fas fa-user me-1"></i>
                                            User
                                        </span>
                                    <?php endif; ?>
                                </p>
                                <small class="text-muted">
                                    <i class="fas fa-calendar me-1"></i>
                                    Dibuat: <?= date('d/m/Y', strtotime($user->created_at)) ?>
                                </small>
                            </div>
                        </div>
                    </div>

                    <!-- Form Fields -->
                    <div class="col-md-8">
                        <!-- Username Field -->
                        <div class="mb-3">
                            <label for="username" class="form-label">
                                <i class="fas fa-user me-1"></i>
                                Username <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                class="form-control"
                                id="username"
                                name="username"
                                value="<?= htmlspecialchars($user->username) ?>"
                                placeholder="Masukkan username"
                                required>
                            <div class="form-text">
                                <i class="fas fa-info-circle me-1"></i>
                                Username harus unik dan minimal 3 karakter
                            </div>
                        </div>

                        <!-- Role Field -->
                        <div class="mb-3">
                            <label for="role" class="form-label">
                                <i class="fas fa-user-tag me-1"></i>
                                Role <span class="text-danger">*</span>
                            </label>
                            <select class="form-select" id="role" name="role" required>
                                <option value="admin" <?= $user->role == 'admin' ? 'selected' : '' ?>>
                                    Administrator
                                </option>
                                <option value="user" <?= $user->role == 'user' ? 'selected' : '' ?>>
                                    User Biasa
                                </option>
                            </select>
                            <div class="form-text">
                                <i class="fas fa-info-circle me-1"></i>
                                Admin memiliki akses penuh, User hanya dapat mengelola data sendiri
                            </div>
                        </div>

                        <!-- Password Section -->
                        <div class="card border-warning mb-3">
                            <div class="card-header bg-warning text-dark">
                                <h6 class="mb-0">
                                    <i class="fas fa-lock me-1"></i>
                                    Ubah Password (Opsional)
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <!-- Password Field -->
                                    <div class="col-md-6 mb-3">
                                        <label for="password" class="form-label">
                                            <i class="fas fa-key me-1"></i>
                                            Password Baru
                                        </label>
                                        <div class="input-group">
                                            <input type="password"
                                                class="form-control"
                                                id="password"
                                                name="password"
                                                placeholder="Kosongkan jika tidak diubah">
                                            <button class="btn btn-outline-secondary"
                                                type="button"
                                                id="togglePassword">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                        <div class="form-text">
                                            <i class="fas fa-info-circle me-1"></i>
                                            Minimal 6 karakter jika ingin mengubah password
                                        </div>
                                    </div>

                                    <!-- Confirm Password Field -->
                                    <div class="col-md-6 mb-3">
                                        <label for="confirm_password" class="form-label">
                                            <i class="fas fa-lock me-1"></i>
                                            Konfirmasi Password
                                        </label>
                                        <div class="input-group">
                                            <input type="password"
                                                class="form-control"
                                                id="confirm_password"
                                                name="confirm_password"
                                                placeholder="Ulangi password baru">
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
                                    Update User
                                </button>
                            </div>
                        </div>
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
                Catatan Penting
            </h6>
            <div class="row">
                <div class="col-md-4">
                    <div class="d-flex align-items-center mb-2">
                        <i class="fas fa-shield-alt text-warning me-2"></i>
                        <strong>Keamanan</strong>
                    </div>
                    <small class="text-muted">
                        Password akan di-enkripsi secara otomatis. Kosongkan jika tidak ingin mengubah password.
                    </small>
                </div>
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
        const form = document.getElementById('editUserForm');
        const submitBtn = document.getElementById('submitBtn');

        form.addEventListener('submit', function(e) {
            const username = document.getElementById('username').value.trim();
            const role = document.getElementById('role').value;
            const passwordVal = password.value;
            const confirmPasswordVal = confirmPassword.value;

            // Basic validation
            if (username.length < 3) {
                e.preventDefault();
                alert('Username minimal 3 karakter!');
                return false;
            }

            // Password validation hanya jika diisi
            if (passwordVal || confirmPasswordVal) {
                if (passwordVal.length < 6) {
                    e.preventDefault();
                    alert('Password minimal 6 karakter!');
                    return false;
                }

                if (passwordVal !== confirmPasswordVal) {
                    e.preventDefault();
                    alert('Password dan konfirmasi password tidak sama!');
                    return false;
                }
            }

            if (!role) {
                e.preventDefault();
                alert('Pilih role untuk user!');
                return false;
            }

            // Show loading state
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Mengupdate...';
            submitBtn.disabled = true;
        });

        // Real-time password match validation
        confirmPassword.addEventListener('input', function() {
            if (password.value && this.value !== password.value) {
                this.setCustomValidity('Password tidak sama');
                this.classList.add('is-invalid');
            } else {
                this.setCustomValidity('');
                this.classList.remove('is-invalid');
                if (this.value) this.classList.add('is-valid');
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