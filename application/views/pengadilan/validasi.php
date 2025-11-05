<div class="content-wrapper">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="content-card mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="mb-1">
                        <i class="fas fa-check-circle me-2"></i>
                        Validasi Konsistensi Nama Pengadilan
                    </h4>
                    <p class="text-muted mb-0">Deteksi dan perbaiki inkonsistensi dalam penamaan pengadilan</p>
                </div>
                <a href="<?= site_url('kelola_pengadilan'); ?>" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
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

        <!-- Hasil Validasi -->
        <?php if (empty($inkonsistensi)): ?>
            <div class="content-card">
                <div class="text-center py-5">
                    <i class="fas fa-check-circle text-success" style="font-size: 4rem;"></i>
                    <h4 class="mt-3 mb-2">Tidak Ada Inkonsistensi!</h4>
                    <p class="text-muted">Semua nama pengadilan sudah konsisten.</p>
                    <a href="<?= site_url('kelola_pengadilan'); ?>" class="btn btn-primary mt-3">
                        <i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar
                    </a>
                </div>
            </div>
        <?php else: ?>
            <!-- Warning Alert -->
            <div class="alert alert-warning">
                <div class="d-flex align-items-start">
                    <i class="fas fa-exclamation-triangle me-3" style="font-size: 2rem;"></i>
                    <div>
                        <h5 class="alert-heading mb-2">
                            <strong><?= count($inkonsistensi); ?> Grup Inkonsistensi Ditemukan!</strong>
                        </h5>
                        <p class="mb-0">
                            Ditemukan variasi penulisan nama pengadilan yang berbeda (huruf besar/kecil, spasi, singkatan).
                            Silakan pilih nama standar yang benar untuk setiap grup dan klik "Perbaiki" untuk menyeragamkan.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Daftar Inkonsistensi -->
            <?php $grupNo = 1;
            foreach ($inkonsistensi as $baseNama => $variants): ?>
                <div class="content-card mb-3">
                    <h5 class="mb-3">
                        <span class="badge bg-danger"><?= $grupNo++; ?></span>
                        <strong class="ms-2">Grup: "<?= htmlspecialchars($baseNama); ?>"</strong>
                    </h5>

                    <form method="post" action="<?= site_url('kelola_pengadilan/perbaiki'); ?>"
                        onsubmit="return confirmFix('<?= htmlspecialchars($baseNama); ?>')">
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label class="form-label">
                                    <strong>Pilih Nama Standar yang Benar:</strong>
                                </label>
                                <div class="variant-list">
                                    <?php foreach ($variants as $variant): ?>
                                        <div class="form-check variant-item">
                                            <input class="form-check-input" type="radio"
                                                name="pengadilan_baru"
                                                id="variant_<?= md5($variant->nama); ?>"
                                                value="<?= htmlspecialchars($variant->nama); ?>"
                                                required>
                                            <label class="form-check-label" for="variant_<?= md5($variant->nama); ?>">
                                                <div class="d-flex align-items-center justify-content-between flex-wrap">
                                                    <div class="variant-name">
                                                        <strong><?= htmlspecialchars($variant->nama); ?></strong>
                                                    </div>
                                                    <div class="variant-stats">
                                                        <span class="badge bg-primary me-2">
                                                            <i class="fas fa-users me-1"></i>
                                                            <?= $variant->jumlah_user; ?> user
                                                        </span>
                                                        <span class="badge bg-info">
                                                            <i class="fas fa-folder me-1"></i>
                                                            <?= $variant->jumlah_perkara; ?> perkara
                                                        </span>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Hidden fields untuk semua variant yang akan diubah -->
                        <?php foreach ($variants as $variant): ?>
                            <input type="hidden" name="pengadilan_lama[]" value="<?= htmlspecialchars($variant->nama); ?>">
                        <?php endforeach; ?>

                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Total yang akan diubah:</strong>
                            <?php
                            $totalUser = array_sum(array_column($variants, 'jumlah_user'));
                            $totalPerkara = array_sum(array_column($variants, 'jumlah_perkara'));
                            ?>
                            <span class="badge bg-primary"><?= $totalUser; ?> user</span> dan
                            <span class="badge bg-info"><?= $totalPerkara; ?> perkara</span>
                        </div>

                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-magic me-1"></i>
                            Perbaiki Grup Ini
                        </button>
                    </form>
                </div>
            <?php endforeach; ?>

            <!-- Perbaiki Semua Button -->
            <div class="content-card text-center">
                <h5 class="mb-3">Perbaiki Semua Inkonsistensi Sekaligus?</h5>
                <p class="text-muted mb-3">
                    Untuk setiap grup, sistem akan memilih nama dengan jumlah user terbanyak sebagai standar.
                </p>
                <button class="btn btn-danger btn-lg" onclick="confirmFixAll()">
                    <i class="fas fa-magic me-2"></i>
                    Perbaiki Semua Otomatis
                </button>
            </div>
        <?php endif; ?>

        <!-- Duplikat Case-Insensitive (Informasi Tambahan) -->
        <?php if (!empty($duplikat)): ?>
            <div class="content-card mt-4">
                <h5 class="mb-3">
                    <i class="fas fa-clone me-2"></i>
                    Duplikat Case-Insensitive (Informasi)
                </h5>
                <p class="text-muted">
                    Berikut adalah pengelompokan nama pengadilan berdasarkan kesamaan huruf (tidak case-sensitive).
                </p>
                <div class="accordion" id="duplikatAccordion">
                    <?php $dupNo = 1;
                    foreach ($duplikat as $key => $group): ?>
                        <?php if (count($group) > 1): ?>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading<?= $dupNo; ?>">
                                    <button class="accordion-button collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapse<?= $dupNo; ?>">
                                        <strong>Grup <?= $dupNo; ?>:</strong>
                                        <span class="ms-2 text-muted"><?= $key; ?></span>
                                        <span class="badge bg-secondary ms-auto"><?= count($group); ?> varian</span>
                                    </button>
                                </h2>
                                <div id="collapse<?= $dupNo; ?>" class="accordion-collapse collapse"
                                    data-bs-parent="#duplikatAccordion">
                                    <div class="accordion-body">
                                        <ul class="list-group">
                                            <?php foreach ($group as $item): ?>
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    <?= htmlspecialchars($item->nama); ?>
                                                    <div>
                                                        <span class="badge bg-primary me-1"><?= $item->jumlah_user; ?> user</span>
                                                        <span class="badge bg-info"><?= $item->jumlah_perkara; ?> perkara</span>
                                                    </div>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <?php $dupNo++; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
    .variant-list {
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        overflow: hidden;
    }

    .variant-item {
        padding: 1rem;
        border-bottom: 1px solid #e2e8f0;
        margin: 0;
        transition: background-color 0.2s;
    }

    .variant-item:last-child {
        border-bottom: none;
    }

    .variant-item:hover {
        background-color: #f7fafc;
    }

    .variant-item input[type="radio"]:checked+label {
        font-weight: 600;
    }

    .variant-item input[type="radio"]:checked~* {
        background-color: #e6fffa;
    }

    .form-check-label {
        width: 100%;
        cursor: pointer;
    }

    .variant-name {
        font-size: 1.1rem;
    }

    .variant-stats {
        margin-top: 0.5rem;
    }

    @media (min-width: 768px) {
        .variant-stats {
            margin-top: 0;
        }
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmFix(grupNama) {
        const selectedRadio = event.target.querySelector('input[type="radio"]:checked');
        if (!selectedRadio) {
            Swal.fire({
                icon: 'warning',
                title: 'Pilih Nama Standar',
                text: 'Silakan pilih nama standar yang benar terlebih dahulu.'
            });
            return false;
        }

        const namaStandar = selectedRadio.value;
        event.preventDefault();

        Swal.fire({
            title: 'Konfirmasi Perbaikan',
            html: `Anda akan menyeragamkan semua varian dalam grup "<strong>${grupNama}</strong>" menjadi:<br><br><strong>${namaStandar}</strong>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Perbaiki!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                event.target.submit();
            }
        });

        return false;
    }

    function confirmFixAll() {
        Swal.fire({
            title: 'Perbaiki Semua Otomatis?',
            html: 'Sistem akan memilih nama dengan <strong>jumlah user terbanyak</strong> sebagai standar untuk setiap grup inkonsistensi.<br><br>Proses ini tidak dapat dibatalkan!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Perbaiki Semua!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Redirect to auto-fix endpoint
                window.location.href = '<?= site_url('kelola_pengadilan/perbaiki_semua_otomatis'); ?>';
            }
        });
    }
</script>
