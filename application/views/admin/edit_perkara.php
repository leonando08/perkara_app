<?php $this->load->view('navbar/header'); ?>

<div class="content-wrapper">
    <div class="content-card mb-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">Edit Data Perkara</h4>
            <a href="<?= site_url('admin/dashboard_admin') ?>" class="btn btn-secondary">
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
                        showConfirmButton: true,
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#28a745',
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    }).then(() => {
                        window.location.href = "<?= site_url('admin/dashboard_admin') ?>";
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
                        <select name="asal_pengadilan" class="form-select" required>
                            <option value="">-- Pilih Asal Pengadilan --</option>
                            <?php if (isset($pengadilan_list) && !empty($pengadilan_list)): ?>
                                <?php foreach ($pengadilan_list as $pengadilan): ?>
                                    <option value="<?= htmlspecialchars($pengadilan->nama_pengadilan) ?>"
                                        <?= ($perkara->asal_pengadilan == $pengadilan->nama_pengadilan) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($pengadilan->nama_pengadilan) ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <option value="">Data pengadilan tidak tersedia</option>
                            <?php endif; ?>
                        </select>
                        <div class="invalid-feedback">Asal pengadilan harus dipilih</div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Jenis Perkara<span class="text-danger">*</span></label>
                        <select name="perkara" class="form-select" required>
                            <option value="">-- Pilih Jenis Perkara --</option>
                            <option value="PIDANA" <?= ($perkara->perkara == 'PIDANA') ? 'selected' : '' ?>>PIDANA</option>
                            <option value="PERDATA" <?= ($perkara->perkara == 'PERDATA') ? 'selected' : '' ?>>PERDATA</option>
                            <option value="ANAK" <?= ($perkara->perkara == 'ANAK') ? 'selected' : '' ?>>ANAK</option>
                            <option value="TIPIKOR" <?= ($perkara->perkara == 'TIPIKOR') ? 'selected' : '' ?>>TIPIKOR</option>
                        </select>
                        <div class="invalid-feedback">Jenis perkara harus dipilih</div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Nomor Perkara Tk1<span class="text-danger">*</span></label>
                        <input type="text" name="nomor_perkara_tk1" class="form-control" required
                            value="<?= htmlspecialchars($perkara->nomor_perkara_tk1) ?>">
                        <div class="invalid-feedback">Nomor perkara tk1 harus diisi</div>
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
                        <?php
                        // Extract date dari text jika ada format "Putusan Banding PT tanggal : DD-MM-YYYY"
                        $existing_date = '';
                        if (!empty($perkara->status_perkara_tk_banding)) {
                            if (preg_match('/\d{2}-\d{2}-\d{4}/', $perkara->status_perkara_tk_banding, $matches)) {
                                // Convert DD-MM-YYYY ke YYYY-MM-DD untuk input date
                                $parts = explode('-', $matches[0]);
                                $existing_date = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
                            }
                        }
                        ?>
                        <input type="date" name="status_perkara_tk_banding_date" id="status_perkara_tk_banding_date_edit" class="form-control"
                            value="<?= $existing_date ?>">
                        <input type="hidden" name="status_perkara_tk_banding" id="status_perkara_tk_banding_edit"
                            value="<?= htmlspecialchars($perkara->status_perkara_tk_banding) ?>">
                        <small class="form-text text-muted">Format otomatis: Putusan Banding PT tanggal : [tanggal yang Anda pilih]</small>
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
                        </select>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Simpan Perubahan
                    </button>
                    <a href="<?= site_url('admin/dashboard_admin') ?>" class="btn btn-light ms-2">Batal</a>
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

    // Auto format Status Perkara Tk Banding dengan tanggal (untuk edit)
    document.addEventListener('DOMContentLoaded', function() {
        const dateInput = document.getElementById('status_perkara_tk_banding_date_edit');
        const hiddenInput = document.getElementById('status_perkara_tk_banding_edit');

        if (dateInput && hiddenInput) {
            dateInput.addEventListener('change', function() {
                if (this.value) {
                    // Format tanggal dari YYYY-MM-DD ke DD-MM-YYYY
                    const date = new Date(this.value);
                    const day = String(date.getDate()).padStart(2, '0');
                    const month = String(date.getMonth() + 1).padStart(2, '0');
                    const year = date.getFullYear();
                    const formattedDate = `${day}-${month}-${year}`;

                    // Set nilai dengan format otomatis
                    hiddenInput.value = `Putusan Banding PT tanggal : ${formattedDate}`;
                    console.log('Status Perkara Tk Banding:', hiddenInput.value);
                } else {
                    hiddenInput.value = '';
                }
            });
        }
    });
</script>

<?php $this->load->view('navbar/footer'); ?>