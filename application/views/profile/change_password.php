<div class="content-wrapper">
    <!-- Page Header -->
    <div class="content-card mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-1">
                    <i class="fas fa-key me-2"></i>
                    Ubah Password
                </h4>
                <p class="text-muted mb-0">Ganti password untuk keamanan akun Anda</p>
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
        <div class="col-lg-6 col-md-8 mx-auto">
            <div class="content-card">
                <div class="text-center mb-4">
                    <div class="mb-3">
                        <i class="fas fa-shield-alt text-warning" style="font-size: 3rem;"></i>
                    </div>
                    <h5>Keamanan Akun</h5>
                    <p class="text-muted">Pastikan password baru Anda kuat dan mudah diingat</p>
                </div>

                <?= form_open('profile/change_password', ['class' => 'needs-validation', 'novalidate' => '']); ?>

                <div class="mb-4">
                    <label for="current_password" class="form-label">
                        <i class="fas fa-lock me-1"></i>
                        Password Saat Ini <span class="text-danger">*</span>
                    </label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="current_password" name="current_password" required>
                        <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('current_password')">
                            <i class="fas fa-eye" id="current_password_icon"></i>
                        </button>
                    </div>
                    <div class="invalid-feedback">Password saat ini harus diisi.</div>
                </div>

                <div class="mb-4">
                    <label for="new_password" class="form-label">
                        <i class="fas fa-key me-1"></i>
                        Password Baru <span class="text-danger">*</span>
                    </label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="new_password" name="new_password" minlength="6" required>
                        <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('new_password')">
                            <i class="fas fa-eye" id="new_password_icon"></i>
                        </button>
                    </div>
                    <div class="invalid-feedback">Password baru minimal 6 karakter.</div>
                    <div class="form-text">
                        <div id="password-strength" class="mt-2"></div>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="confirm_password" class="form-label">
                        <i class="fas fa-check-double me-1"></i>
                        Konfirmasi Password Baru <span class="text-danger">*</span>
                    </label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                        <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('confirm_password')">
                            <i class="fas fa-eye" id="confirm_password_icon"></i>
                        </button>
                    </div>
                    <div class="invalid-feedback">Konfirmasi password harus sama dengan password baru.</div>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-warning btn-lg">
                        <i class="fas fa-key me-1"></i>
                        Ubah Password
                    </button>
                    <a href="<?= base_url('profile'); ?>" class="btn btn-outline-secondary">
                        <i class="fas fa-times me-1"></i>
                        Batal
                    </a>
                </div>

                <?= form_close(); ?>
            </div>
        </div>

        <!-- Security Tips Sidebar -->
        <div class="col-lg-4 col-md-12 mt-4 mt-lg-0">
            <div class="content-card">
                <h6 class="card-title mb-3">
                    <i class="fas fa-shield-check me-2 text-success"></i>
                    Tips Keamanan Password
                </h6>
                <div class="security-tips">
                    <div class="tip-item mb-3">
                        <div class="d-flex align-items-start">
                            <i class="fas fa-check-circle text-success me-2 mt-1"></i>
                            <div>
                                <h6 class="mb-1">Minimal 6 Karakter</h6>
                                <small class="text-muted">Gunakan password yang cukup panjang</small>
                            </div>
                        </div>
                    </div>

                    <div class="tip-item mb-3">
                        <div class="d-flex align-items-start">
                            <i class="fas fa-check-circle text-success me-2 mt-1"></i>
                            <div>
                                <h6 class="mb-1">Kombinasi Karakter</h6>
                                <small class="text-muted">Campurkan huruf besar, kecil, angka, dan simbol</small>
                            </div>
                        </div>
                    </div>

                    <div class="tip-item mb-3">
                        <div class="d-flex align-items-start">
                            <i class="fas fa-check-circle text-success me-2 mt-1"></i>
                            <div>
                                <h6 class="mb-1">Hindari Informasi Pribadi</h6>
                                <small class="text-muted">Jangan gunakan nama, tanggal lahir, atau info personal</small>
                            </div>
                        </div>
                    </div>

                    <div class="tip-item mb-3">
                        <div class="d-flex align-items-start">
                            <i class="fas fa-exclamation-triangle text-warning me-2 mt-1"></i>
                            <div>
                                <h6 class="mb-1">Password Unik</h6>
                                <small class="text-muted">Gunakan password yang berbeda untuk setiap akun</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- User Info -->
            <div class="content-card mt-4">
                <h6 class="card-title mb-3">
                    <i class="fas fa-info-circle me-2 text-info"></i>
                    Informasi Akun
                </h6>
                <div class="account-info">
                    <div class="info-row mb-2">
                        <small class="text-muted">Username</small>
                        <div class="fw-medium"><?= htmlspecialchars($user->username); ?></div>
                    </div>
                    <div class="info-row mb-2">
                        <small class="text-muted">Email</small>
                        <div class="fw-medium"><?= $user->email ?: 'Belum diatur'; ?></div>
                    </div>
                    <div class="info-row">
                        <small class="text-muted">Terakhir Login</small>
                        <div class="fw-medium">
                            <?php
                            if ($this->session->userdata('login_time')) {
                                echo date('d M Y, H:i', $this->session->userdata('login_time'));
                            } else {
                                echo 'Tidak diketahui';
                            }
                            ?>
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
        var newPassword = document.getElementById('new_password').value;
        var confirmPassword = this.value;

        if (newPassword !== confirmPassword) {
            this.setCustomValidity('Password tidak cocok');
        } else {
            this.setCustomValidity('');
        }
    });

    // Password strength indicator
    document.getElementById('new_password').addEventListener('input', function() {
        const password = this.value;
        const strengthDiv = document.getElementById('password-strength');

        let strength = 0;
        let feedback = [];

        if (password.length >= 6) strength++;
        else feedback.push('Minimal 6 karakter');

        if (/[a-z]/.test(password)) strength++;
        else feedback.push('Huruf kecil');

        if (/[A-Z]/.test(password)) strength++;
        else feedback.push('Huruf besar');

        if (/[0-9]/.test(password)) strength++;
        else feedback.push('Angka');

        if (/[^A-Za-z0-9]/.test(password)) strength++;
        else feedback.push('Simbol');

        let strengthText = '';
        let strengthClass = '';
        let progressWidth = '';

        switch (strength) {
            case 0:
            case 1:
                strengthText = 'Sangat Lemah';
                strengthClass = 'text-danger';
                progressWidth = '20%';
                break;
            case 2:
                strengthText = 'Lemah';
                strengthClass = 'text-warning';
                progressWidth = '40%';
                break;
            case 3:
                strengthText = 'Sedang';
                strengthClass = 'text-info';
                progressWidth = '60%';
                break;
            case 4:
                strengthText = 'Kuat';
                strengthClass = 'text-success';
                progressWidth = '80%';
                break;
            case 5:
                strengthText = 'Sangat Kuat';
                strengthClass = 'text-success fw-bold';
                progressWidth = '100%';
                break;
        }

        if (password.length > 0) {
            strengthDiv.innerHTML = `
            <div class="d-flex justify-content-between align-items-center mb-1">
                <small class="${strengthClass}">Kekuatan: ${strengthText}</small>
                <small class="text-muted">${strength}/5</small>
            </div>
            <div class="progress" style="height: 4px;">
                <div class="progress-bar ${strengthClass.replace('text-', 'bg-')}" 
                     style="width: ${progressWidth}; transition: width 0.3s ease;"></div>
            </div>
            ${feedback.length > 0 ? '<small class="text-muted d-block mt-1">Perlu: ' + feedback.join(', ') + '</small>' : ''}
        `;
        } else {
            strengthDiv.innerHTML = '';
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

    .tip-item {
        padding: 0.75rem;
        background: rgba(40, 167, 69, 0.05);
        border-left: 3px solid #28a745;
        border-radius: 0.375rem;
    }

    .tip-item h6 {
        font-size: 0.875rem;
        margin: 0;
    }

    .account-info .info-row {
        padding: 0.5rem 0;
        border-bottom: 1px solid rgba(0, 0, 0, 0.1);
    }

    .account-info .info-row:last-child {
        border-bottom: none;
    }

    .input-group .btn {
        border-color: #ced4da;
    }

    .form-control:focus+.btn {
        border-color: #86b7fe;
    }

    .progress {
        background-color: rgba(0, 0, 0, 0.1);
        border-radius: 0.25rem;
    }

    @media (max-width: 768px) {
        .col-lg-6.mx-auto {
            margin-left: 0 !important;
            margin-right: 0 !important;
        }
    }
</style>