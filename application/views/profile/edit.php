<div class="content-wrapper">
    <!-- Page Header -->
    <div class="content-card mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-1">
                    <i class="fas fa-edit me-2"></i>
                    Edit Profil
                </h4>
                <p class="text-muted mb-0">Perbarui informasi akun Anda</p>
            </div>
            <div>
                <?php if ($this->session->userdata('role') === 'admin'): ?>
                    <a href="<?= site_url('admin/dashboard_admin'); ?>" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-arrow-left me-1"></i> Dashboard
                    </a>
                <?php else: ?>
                    <a href="<?= site_url('user/dashboard_user'); ?>" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-arrow-left me-1"></i> Dashboard
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Flash Messages -->
    <?php if (isset($error)): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <?= $error; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (validation_errors()): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <?= validation_errors(); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="row">
        <!-- Main Form -->
        <div class="col-lg-8 col-md-12">
            <div class="content-card">
                <h5 class="mb-4">
                    <i class="fas fa-user me-2"></i>
                    Informasi Dasar
                </h5>

                <?= form_open('profile/edit', ['class' => 'needs-validation', 'novalidate' => '']); ?>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="username" class="form-label">
                                <i class="fas fa-user me-1"></i>
                                Username <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="username" name="username"
                                value="<?= set_value('username', $user->username); ?>" required>
                            <div class="invalid-feedback">Username harus diisi.</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="email" class="form-label">
                                <i class="fas fa-envelope me-1"></i>
                                Email <span class="text-danger">*</span>
                            </label>
                            <input type="email" class="form-control" id="email" name="email"
                                value="<?= set_value('email', isset($user->email) ? $user->email : ''); ?>" required>
                            <div class="invalid-feedback">Email harus diisi dengan format yang benar.</div>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="nama_lengkap" class="form-label">
                        <i class="fas fa-id-card me-1"></i>
                        Nama Lengkap <span class="text-danger">*</span>
                    </label>
                    <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap"
                        value="<?= set_value('nama_lengkap', isset($user->nama_lengkap) ? $user->nama_lengkap : ''); ?>" required>
                    <div class="invalid-feedback">Nama lengkap harus diisi.</div>
                </div>

                <hr class="my-4">

                <h5 class="mb-3">
                    <i class="fas fa-key me-2"></i>
                    Ubah Password (Opsional)
                </h5>
                <p class="text-muted mb-3">Kosongkan jika tidak ingin mengubah password</p>

                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="current_password" class="form-label">
                                <i class="fas fa-lock me-1"></i>
                                Password Saat Ini
                            </label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="current_password" name="current_password">
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('current_password')">
                                    <i class="fas fa-eye" id="current_password_icon"></i>
                                </button>
                            </div>
                            <div class="form-text">Diperlukan jika ingin mengubah password</div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="password" class="form-label">
                                <i class="fas fa-key me-1"></i>
                                Password Baru
                            </label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="password" name="password" minlength="6">
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password')">
                                    <i class="fas fa-eye" id="password_icon"></i>
                                </button>
                            </div>
                            <div class="form-text">Minimal 6 karakter</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">
                                <i class="fas fa-check-double me-1"></i>
                                Konfirmasi Password Baru
                            </label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('confirm_password')">
                                    <i class="fas fa-eye" id="confirm_password_icon"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-2 pt-3">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>
                        Simpan Perubahan
                    </button>
                    <a href="<?= base_url('profile'); ?>" class="btn btn-secondary">
                        <i class="fas fa-times me-1"></i>
                        Batal
                    </a>
                </div>

                <?= form_close(); ?>
            </div>
        </div>

        <!-- Sidebar Guide -->
        <div class="col-lg-4 col-md-12">
            <div class="content-card">
                <h6 class="card-title mb-3">
                    <i class="fas fa-info-circle me-2 text-info"></i>
                    Panduan
                </h6>
                <div class="guide-content">
                    <div class="guide-item mb-3">
                        <h6 class="mb-1">
                            <i class="fas fa-check-circle text-success me-1"></i>
                            Username
                        </h6>
                        <small class="text-muted">Username harus unik dan akan digunakan untuk login</small>
                    </div>

                    <div class="guide-item mb-3">
                        <h6 class="mb-1">
                            <i class="fas fa-check-circle text-success me-1"></i>
                            Email
                        </h6>
                        <small class="text-muted">Email harus valid dan dapat digunakan untuk komunikasi</small>
                    </div>

                    <div class="guide-item mb-3">
                        <h6 class="mb-1">
                            <i class="fas fa-check-circle text-success me-1"></i>
                            Password
                        </h6>
                        <small class="text-muted">Password minimal 6 karakter, gunakan kombinasi huruf, angka, dan simbol</small>
                    </div>

                    <div class="guide-item">
                        <h6 class="mb-1">
                            <i class="fas fa-exclamation-triangle text-warning me-1"></i>
                            Keamanan
                        </h6>
                        <small class="text-muted">Password lama diperlukan untuk mengubah password baru</small>
                    </div>
                </div>
            </div>

            <!-- Current User Info -->
            <div class="content-card mt-4">
                <h6 class="card-title mb-3">
                    <i class="fas fa-user me-2 text-primary"></i>
                    Info Saat Ini
                </h6>
                <div class="current-info">
                    <div class="info-row mb-2">
                        <small class="text-muted">Username</small>
                        <div class="fw-medium"><?= htmlspecialchars($user->username); ?></div>
                    </div>
                    <div class="info-row mb-2">
                        <small class="text-muted">Email</small>
                        <div class="fw-medium"><?= $user->email ?: 'Belum diatur'; ?></div>
                    </div>
                    <div class="info-row">
                        <small class="text-muted">Role</small>
                        <div>
                            <span class="badge bg-<?= $user->role === 'admin' ? 'danger' : 'primary'; ?>">
                                <?= ucfirst($user->role); ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Toggle password visibility
    function togglePassword(fieldId) {
        const field = document.getElementById(fieldId);
        const icon = document.getElementById(fieldId + '_icon');

        if (field.type === 'password') {
            field.type = 'text';
            icon.className = 'fas fa-eye-slash';
        } else {
            field.type = 'password';
            icon.className = 'fas fa-eye';
        }
    }

    // Bootstrap form validation
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            var forms = document.getElementsByClassName('needs-validation');
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();

    // Password confirmation validation
    document.getElementById('confirm_password').addEventListener('input', function() {
        var password = document.getElementById('password').value;
        var confirmPassword = this.value;

        if (password !== confirmPassword) {
            this.setCustomValidity('Password tidak cocok');
        } else {
            this.setCustomValidity('');
        }
    });

    // Current password requirement when new password is filled
    document.getElementById('password').addEventListener('input', function() {
        var currentPassword = document.getElementById('current_password');

        if (this.value.length > 0) {
            currentPassword.setAttribute('required', '');
        } else {
            currentPassword.removeAttribute('required');
        }
    });
</script>

<style>
    .content-card {
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        padding: 1.5rem;
        border: 1px solid rgba(0, 0, 0, 0.05);
    }

    .card-title {
        font-weight: 600;
        color: #495057;
        margin-bottom: 1rem;
    }

    .guide-item {
        padding: 0.75rem;
        background: rgba(0, 123, 255, 0.05);
        border-left: 3px solid #007bff;
        border-radius: 0.375rem;
    }

    .guide-item h6 {
        font-size: 0.875rem;
        margin: 0;
    }

    .current-info .info-row {
        padding: 0.5rem 0;
        border-bottom: 1px solid rgba(0, 0, 0, 0.1);
    }

    .current-info .info-row:last-child {
        border-bottom: none;
    }

    .input-group .btn {
        border-color: #ced4da;
    }

    .form-control:focus+.btn {
        border-color: #86b7fe;
    }

    @media (max-width: 768px) {
        .d-flex.gap-2 {
            flex-direction: column;
        }

        .d-flex.gap-2 .btn {
            width: 100%;
        }
    }
</style>