<?php $this->load->view('navbar/header'); ?>

<div class="content-wrapper">
    <div class="content-card mb-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">Edit Data Perkara</h4>
            <a href="<?= site_url('user/dashboard_user') ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>

        <?php if ($this->session->flashdata('error')): ?>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: '<?= addslashes($this->session->flashdata('error')) ?>',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#dc3545'
                    });
                });
            </script>
        <?php endif; ?>

        <?php if ($this->session->flashdata('success')): ?>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: '<?= $this->session->flashdata('success') ?>',
                        showConfirmButton: false,
                        timer: 2000,
                        timerProgressBar: true,
                        toast: true,
                        position: 'top-end'
                    }).then(() => {
                        window.location.href = "<?= site_url('user/dashboard_user') ?>";
                    });
                });
            </script>
        <?php endif; ?>

        <?php if (isset($perkara)): ?>
            <form method="post" action="<?= current_url() ?>" class="needs-validation" novalidate>
                <div class="mb-3">
                    <label class="form-label">ID Perkara</label>
                    <input type="text" class="form-control" value="<?= htmlspecialchars($perkara->id) ?>" readonly>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Asal Pengadilan<span class="text-danger">*</span></label>
                        <input type="text" name="asal_pengadilan" class="form-control" required
                            value="<?= htmlspecialchars($perkara->asal_pengadilan) ?>">
                        <div class="invalid-feedback">Asal pengadilan harus diisi</div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Nomor Perkara Tk1<span class="text-danger">*</span></label>
                        <input type="text" name="nomor_perkara_tk1" class="form-control" required
                            value="<?= htmlspecialchars($perkara->nomor_perkara_tk1) ?>">
                        <div class="invalid-feedback">Nomor perkara tk1 harus diisi</div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Jenis Perkara<span class="text-danger">*</span></label>
                        <select name="perkara" id="perkara" class="form-select" required>
                            <option value="">-- Pilih Jenis Perkara --</option>
                            <option value="PIDANA" <?= ($perkara->perkara == 'PIDANA') ? 'selected' : '' ?>>PIDANA</option>
                            <option value="PERDATA" <?= ($perkara->perkara == 'PERDATA') ? 'selected' : '' ?>>PERDATA</option>
                            <option value="ANAK" <?= ($perkara->perkara == 'ANAK') ? 'selected' : '' ?>>ANAK</option>
                            <option value="TIPIKOR" <?= ($perkara->perkara == 'TIPIKOR') ? 'selected' : '' ?>>TIPIKOR</option>
                        </select>
                        <div class="invalid-feedback">Jenis Perkara harus dipilih</div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Klasifikasi<span class="text-danger">*</span></label>
                        <input type="text"
                            name="klasifikasi"
                            id="klasifikasi"
                            class="form-control"
                            list="klasifikasi-options"
                            value="<?= htmlspecialchars($perkara->klasifikasi) ?>"
                            placeholder="Pilih atau ketik klasifikasi..."
                            required>
                        <datalist id="klasifikasi-options">
                            <?php foreach ($jenis_perkara as $jp): ?>
                                <option value="<?= htmlspecialchars($jp->nama) ?>">
                                <?php endforeach; ?>
                        </datalist>
                        <div class="invalid-feedback">Klasifikasi harus diisi</div>
                        <small class="form-text text-muted">Pilih dari dropdown atau ketik klasifikasi baru</small>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Tgl Register Banding</label>
                        <input type="date" name="tgl_register_banding" class="form-control"
                            value="<?= $perkara->tgl_register_banding ? date('Y-m-d', strtotime($perkara->tgl_register_banding)) : '' ?>">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Nomor Perkara Banding</label>
                        <input type="text" name="nomor_perkara_banding" class="form-control"
                            value="<?= htmlspecialchars($perkara->nomor_perkara_banding) ?>">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Lama Proses</label>
                        <input type="text" name="lama_proses" class="form-control"
                            value="<?= htmlspecialchars($perkara->lama_proses) ?>">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Status Perkara Tk Banding</label>
                        <input type="text" name="status_perkara_tk_banding" class="form-control"
                            value="<?= htmlspecialchars($perkara->status_perkara_tk_banding) ?>">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Pemberitahuan Putusan Banding</label>
                        <input type="date" name="pemberitahuan_putusan_banding" class="form-control"
                            value="<?= $perkara->pemberitahuan_putusan_banding ? date('Y-m-d', strtotime($perkara->pemberitahuan_putusan_banding)) : '' ?>">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Permohonan Kasasi</label>
                        <input type="date" name="permohonan_kasasi" class="form-control"
                            value="<?= $perkara->permohonan_kasasi ? date('Y-m-d', strtotime($perkara->permohonan_kasasi)) : '' ?>">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Pengiriman Berkas Kasasi</label>
                        <input type="date" name="pengiriman_berkas_kasasi" class="form-control"
                            value="<?= $perkara->pengiriman_berkas_kasasi ? date('Y-m-d', strtotime($perkara->pengiriman_berkas_kasasi)) : '' ?>">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select" required>
                            <option value="Proses" <?= ($perkara->status == 'Proses') ? 'selected' : '' ?>>Proses</option>
                            <option value="Selesai" <?= ($perkara->status == 'Selesai') ? 'selected' : '' ?>>Selesai</option>
                            <option value="Ditolak" <?= ($perkara->status == 'Ditolak') ? 'selected' : '' ?>>Ditolak</option>
                        </select>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Simpan Perubahan
                    </button>
                    <a href="<?= site_url('user/dashboard_user') ?>" class="btn btn-light ms-2">Batal</a>
                </div>
            </form>
        <?php else: ?>
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-triangle me-2"></i>
                Data perkara tidak ditemukan
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
    // Form validation
    (function() {
        'use strict';
        var forms = document.querySelectorAll('.needs-validation');
        Array.prototype.slice.call(forms).forEach(function(form) {
            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    })();

    // Alert auto-hide
    setTimeout(function() {
        const alertBox = document.getElementById('alertBox');
        if (alertBox) {
            alertBox.classList.remove('show');
            alertBox.classList.add('hide');
        }
    }, 3000);
</script>

<?php $this->load->view('navbar/footer'); ?>