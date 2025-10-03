<?php $this->load->view('navbar/header'); ?>

<div class="content-wrapper">
    <!-- Page Header -->
    <div class="content-card mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-1">
                    <i class="fas fa-users me-2 text-primary"></i>
                    Kelola User
                </h4>
                <p class="text-muted mb-0">Manajemen pengguna sistem</p>
            </div>
            <a href="<?= site_url('admin/tambah_user') ?>" class="btn btn-primary">
                <i class="fas fa-user-plus me-1"></i>
                Tambah User Baru
            </a>
        </div>
    </div>

    <!-- Flash Messages -->
    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            <?= $this->session->flashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <?= $this->session->flashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Users Table -->
    <div class="content-card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-primary">
                        <tr>
                            <th class="text-center">#</th>
                            <th>
                                <i class="fas fa-user me-1"></i>
                                Username
                            </th>
                            <th class="text-center">
                                <i class="fas fa-user-tag me-1"></i>
                                Role
                            </th>
                            <th class="text-center">
                                <i class="fas fa-calendar me-1"></i>
                                Dibuat
                            </th>
                            <th class="text-center">
                                <i class="fas fa-cogs me-1"></i>
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($users)): ?>
                            <?php $no = 1;
                            foreach ($users as $row): ?>
                                <tr>
                                    <td class="text-center fw-bold"><?= $no++ ?></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm me-2">
                                                <i class="fas fa-user-circle fa-2x text-secondary"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0"><?= htmlspecialchars($row['username']) ?></h6>
                                                <small class="text-muted">ID: <?= $row['id'] ?></small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <?php if ($row['role'] == 'admin'): ?>
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
                                    </td>
                                    <td class="text-center">
                                        <small class="text-muted">
                                            <?= date('d/m/Y', strtotime($row['created_at'])) ?>
                                        </small>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="<?= site_url('admin/edit_user/' . $row['id']) ?>"
                                                class="btn btn-sm btn-outline-primary"
                                                title="Edit User">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <?php if ($row['id'] != $this->session->userdata('user_id')): ?>
                                                <a href="<?= site_url('admin/hapus_user/' . $row['id']) ?>"
                                                    class="btn btn-sm btn-outline-danger"
                                                    title="Hapus User"
                                                    onclick="return confirm('Yakin ingin menghapus user <?= htmlspecialchars($row['username']) ?>?')">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            <?php else: ?>
                                                <button class="btn btn-sm btn-outline-secondary"
                                                    title="Tidak dapat menghapus diri sendiri"
                                                    disabled>
                                                    <i class="fas fa-ban"></i>
                                                </button>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="fas fa-users fa-3x mb-3"></i>
                                        <h5>Belum ada data user</h5>
                                        <p>Silakan tambahkan user baru untuk memulai</p>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('navbar/footer'); ?>