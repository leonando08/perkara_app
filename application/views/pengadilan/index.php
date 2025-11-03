<div class="content-wrapper">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="content-card mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="mb-1">
                        <i class="fas fa-landmark me-2"></i>
                        Kelola Pengadilan Standar
                    </h4>
                    <p class="text-muted mb-0">Kelola daftar nama pengadilan dan validasi konsistensi data</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="<?= site_url('kelola_pengadilan/validasi'); ?>" class="btn btn-warning btn-sm">
                        <i class="fas fa-check-circle me-1"></i> Validasi Konsistensi
                    </a>
                    <a href="<?= site_url('kelola_pengadilan/generate_sql'); ?>" class="btn btn-info btn-sm">
                        <i class="fas fa-code me-1"></i> Generate SQL
                    </a>
                    <a href="<?= site_url('kelola_pengadilan/export_json'); ?>" class="btn btn-secondary btn-sm">
                        <i class="fas fa-download me-1"></i> Export JSON
                    </a>
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

        <!-- Statistik -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="stat-card stat-primary">
                    <div class="stat-icon">
                        <i class="fas fa-landmark"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-value"><?= $statistik['total_pengadilan']; ?></div>
                        <div class="stat-label">Total Pengadilan</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card stat-success">
                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-value"><?= $statistik['total_users']; ?></div>
                        <div class="stat-label">Total User Ter-assign</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card stat-info">
                    <div class="stat-icon">
                        <i class="fas fa-folder"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-value"><?= $statistik['total_perkara']; ?></div>
                        <div class="stat-label">Total Perkara Ter-assign</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card stat-warning">
                    <div class="stat-icon">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-value"><?= $statistik['users_tanpa_pengadilan'] + $statistik['perkara_tanpa_pengadilan']; ?></div>
                        <div class="stat-label">Data Tanpa Pengadilan</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Daftar Pengadilan -->
        <div class="content-card">
            <h5 class="mb-3">
                <i class="fas fa-list me-2"></i>
                Daftar Pengadilan yang Terdaftar
            </h5>

            <?php if (empty($pengadilan_list)): ?>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    Belum ada pengadilan yang terdaftar.
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead class="table-success">
                            <tr>
                                <th width="5%">No</th>
                                <th width="45%">Nama Pengadilan</th>
                                <th width="15%" class="text-center">Jumlah User</th>
                                <th width="15%" class="text-center">Jumlah Perkara</th>
                                <th width="20%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            foreach ($pengadilan_list as $pengadilan): ?>
                                <tr>
                                    <td class="text-center"><?= $no++; ?></td>
                                    <td>
                                        <strong><?= htmlspecialchars($pengadilan->nama_pengadilan); ?></strong>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-primary"><?= $pengadilan->jumlah_user; ?> user</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-info"><?= $pengadilan->jumlah_perkara; ?> perkara</span>
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-warning btn-sm"
                                            onclick="showRenameModal('<?= htmlspecialchars($pengadilan->nama_pengadilan); ?>')">
                                            <i class="fas fa-edit"></i> Rename
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Modal Rename Pengadilan -->
<div class="modal fade" id="renameModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="<?= site_url('kelola_pengadilan/rename'); ?>">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-edit me-2"></i>
                        Rename Nama Pengadilan
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Pengadilan Saat Ini</label>
                        <input type="text" class="form-control" name="pengadilan_lama" id="pengadilan_lama" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Pengadilan Baru <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="pengadilan_baru" required>
                        <small class="text-muted">Pastikan nama pengadilan konsisten dan sesuai standar</small>
                    </div>
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Perhatian!</strong> Perubahan ini akan mempengaruhi semua user dan perkara yang terkait dengan pengadilan ini.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .stat-card {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        display: flex;
        align-items: center;
        gap: 1rem;
        transition: transform 0.2s;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    .stat-primary .stat-icon {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .stat-success .stat-icon {
        background: linear-gradient(135deg, #00b09b 0%, #96c93d 100%);
        color: white;
    }

    .stat-info .stat-icon {
        background: linear-gradient(135deg, #0575e6 0%, #021b79 100%);
        color: white;
    }

    .stat-warning .stat-icon {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
    }

    .stat-content {
        flex: 1;
    }

    .stat-value {
        font-size: 2rem;
        font-weight: 700;
        color: #2d3748;
    }

    .stat-label {
        font-size: 0.875rem;
        color: #718096;
        margin-top: 0.25rem;
    }

    .content-card {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }
</style>

<script>
    function showRenameModal(namaPengadilan) {
        document.getElementById('pengadilan_lama').value = namaPengadilan;
        const modal = new bootstrap.Modal(document.getElementById('renameModal'));
        modal.show();
    }
</script>