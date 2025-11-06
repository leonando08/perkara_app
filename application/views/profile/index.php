<div class="content-wrapper">
    <!-- Page Header -->
    <div class="content-card mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-1">
                    <i class="fas fa-user-circle me-2"></i>
                    Profil Pengguna
                </h4>
                <p class="text-muted mb-0">Kelola informasi akun Anda</p>
            </div>
            <div class="d-flex gap-2">
                <a href="<?= site_url('profile/edit'); ?>" class="btn btn-primary btn-sm">
                    <i class="fas fa-edit me-1"></i> Edit Profil
                </a>
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
    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            <?= $this->session->flashdata('success'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <?= $this->session->flashdata('error'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Profile Content -->
    <div class="row">
        <!-- Main Profile Info -->
        <div class="col-lg-8 col-md-12">
            <div class="content-card">
                <div class="d-flex align-items-center mb-4">
                    <div class="avatar-lg me-3">
                        <?php if (!empty($user->foto_profil)): ?>
                            <img src="<?= base_url('assets/img/profile/' . $user->foto_profil) ?>" alt="Foto Profil" class="rounded-circle" style="width:64px;height:64px;object-fit:cover;">
                        <?php else: ?>
                            <i class="fas fa-user-circle text-primary" style="font-size: 4rem;"></i>
                        <?php endif; ?>
                    </div>
                    <div>
                        <h5 class="mb-1"><?= htmlspecialchars($user->nama_lengkap ?: $user->username); ?></h5>
                        <p class="text-muted mb-1">@<?= htmlspecialchars($user->username); ?></p>
                        <span class="badge bg-<?= $user->role === 'admin' ? 'danger' : 'primary'; ?> badge-soft">
                            <i class="fas fa-<?= $user->role === 'admin' ? 'crown' : 'user'; ?> me-1"></i>
                            <?= ucfirst($user->role); ?>
                        </span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="info-item mb-3">
                            <label class="form-label fw-semibold text-muted">Email</label>
                            <div class="info-value">
                                <i class="fas fa-envelope me-2 text-muted"></i>
                                <?= $user->email ? htmlspecialchars($user->email) : '<span class="text-muted fst-italic">Belum diatur</span>'; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="info-item mb-3">
                            <label class="form-label fw-semibold text-muted">Username</label>
                            <div class="info-value">
                                <i class="fas fa-user me-2 text-muted"></i>
                                <?= htmlspecialchars($user->username); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="info-item mb-3">
                            <label class="form-label fw-semibold text-muted">Nama Lengkap</label>
                            <div class="info-value">
                                <i class="fas fa-id-card me-2 text-muted"></i>
                                <?= $user->nama_lengkap ? htmlspecialchars($user->nama_lengkap) : '<span class="text-muted fst-italic">Belum diatur</span>'; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="info-item mb-3">
                            <label class="form-label fw-semibold text-muted">Bergabung Sejak</label>
                            <div class="info-value">
                                <i class="fas fa-calendar me-2 text-muted"></i>
                                <?= $user->created_at ? date('d F Y', strtotime($user->created_at)) : '<span class="text-muted">-</span>'; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <div class="action-buttons">
                    <a href="<?= site_url('profile/edit'); ?>" class="btn btn-primary">
                        <i class="fas fa-edit me-1"></i>
                        Edit Profil
                    </a>
                    <a href="<?= site_url('profile/change_password'); ?>" class="btn btn-warning">
                        <i class="fas fa-key me-1"></i>
                        Ubah Password
                    </a>
                </div>
            </div>
        </div>

        <!-- Sidebar Info -->
        <div class="col-lg-4 col-md-12">
            <!-- Security Card -->
            <div class="content-card mb-4">
                <h6 class="card-title mb-3">
                    <i class="fas fa-shield-alt me-2 text-success"></i>
                    Keamanan Akun
                </h6>
                <div class="security-info">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted">Password</span>
                        <i class="fas fa-check-circle text-success"></i>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">Akun Aktif</span>
                        <i class="fas fa-check-circle text-success"></i>
                    </div>
                    <div class="d-grid">
                        <a href="<?= site_url('profile/change_password'); ?>" class="btn btn-outline-warning btn-sm">
                            <i class="fas fa-key me-1"></i>
                            Ganti Password
                        </a>
                    </div>
                </div>
            </div>

            <!-- Session Info -->
            <div class="content-card">
                <h6 class="card-title mb-3">
                    <i class="fas fa-info-circle me-2 text-info"></i>
                    Informasi Sesi
                </h6>
                <div class="session-info">
                    <div class="info-item mb-2">
                        <small class="text-muted">Terakhir Login</small>
                        <div class="fw-medium">
                            <?php
                            if ($this->session->userdata('login_time')) {
                                echo date('d M Y, H:i', $this->session->userdata('login_time'));
                            } else {
                                echo '<span class="text-muted">-</span>';
                            }
                            ?>
                        </div>
                    </div>
                    <div class="info-item mb-3">
                        <small class="text-muted">IP Address</small>
                        <div class="fw-medium font-mono">
                            <?= $this->session->userdata('login_ip') ?: 'Unknown'; ?>
                        </div>
                    </div>
                    <div class="d-grid">
                        <a href="<?= site_url('auth/logout'); ?>" class="btn btn-outline-danger btn-sm"
                            onclick="return confirm('Yakin ingin logout?')">
                            <i class="fas fa-sign-out-alt me-1"></i>
                            Logout
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .content-card {
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        padding: 1.5rem;
        border: 1px solid rgba(0, 0, 0, 0.05);
    }

    .avatar-lg {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .info-item {
        margin-bottom: 1rem;
    }

    .info-item .form-label {
        font-size: 0.875rem;
        margin-bottom: 0.25rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .info-value {
        display: flex;
        align-items: center;
        font-size: 0.95rem;
        padding: 0.5rem 0;
    }

    .badge-soft {
        background-color: rgba(var(--bs-primary-rgb), 0.1) !important;
        color: var(--bs-primary) !important;
        border: 1px solid rgba(var(--bs-primary-rgb), 0.2);
    }

    .bg-danger.badge-soft {
        background-color: rgba(var(--bs-danger-rgb), 0.1) !important;
        color: var(--bs-danger) !important;
        border: 1px solid rgba(var(--bs-danger-rgb), 0.2);
    }

    .action-buttons {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
    }

    .security-info,
    .session-info {
        font-size: 0.9rem;
    }

    .card-title {
        font-weight: 600;
        color: #495057;
        margin-bottom: 1rem;
    }

    @media (max-width: 768px) {
        .action-buttons {
            flex-direction: column;
        }

        .action-buttons .btn {
            width: 100%;
        }
    }
</style>

<?php $this->load->view('navbar/footer'); ?>