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
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= $this->session->flashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert" id="alertBox">
                <?= $this->session->flashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <script>
                setTimeout(function() {
                    window.location.href = "<?= site_url('perkara/dashboard') ?>";
                }, 2000);
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
                        <label class="form-label">Parent</label>
                        <select name="parent" id="parent" class="form-select" required>
                            <option value="">-- Pilih Parent --</option>
                            <?php foreach ($parents as $p): ?>
                                <option value="<?= $p->id ?>" <?= ($perkara->parent == $p->id) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($p->nama_lengkap) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback">Parent harus dipilih</div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Klasifikasi<span class="text-danger">*</span></label>
                        <select name="klasifikasi" id="klasifikasi" class="form-select" required>
                            <option value="">-- Pilih Parent Terlebih Dahulu --</option>
                        </select>
                        <div class="invalid-feedback">Klasifikasi harus dipilih</div>
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

    // Fungsi untuk memuat klasifikasi berdasarkan parent yang dipilih
    document.getElementById('parent').addEventListener('change', function() {
        var parentId = this.value;
        var klasifikasiSelect = document.getElementById('klasifikasi');
        var selectedKlasifikasi = '<?= htmlspecialchars($perkara->klasifikasi) ?>'; // Simpan klasifikasi yang sudah dipilih

        // Reset klasifikasi
        klasifikasiSelect.innerHTML = '<option value="">-- ' +
            (parentId ? 'Pilih Klasifikasi' : 'Pilih Parent Terlebih Dahulu') +
            ' --</option>';

        if (parentId) {
            // Tambahkan loading state
            klasifikasiSelect.disabled = true;
            klasifikasiSelect.innerHTML = '<option value="">Loading...</option>';

            // Fetch klasifikasi berdasarkan parent
            fetch('<?= site_url("perkara/get_jenis_perkara") ?>?parent_id=' + parentId)
                .then(response => response.json())
                .then(data => {
                    // Reset dan enable kembali
                    klasifikasiSelect.innerHTML = '<option value="">-- Pilih Klasifikasi --</option>';
                    klasifikasiSelect.disabled = false;

                    // Tambahkan opsi
                    data.forEach(item => {
                        var option = new Option(item.nama_lengkap || item.nama, item.nama);
                        // Jika ini adalah klasifikasi yang sebelumnya dipilih, set sebagai selected
                        if (item.nama === selectedKlasifikasi) {
                            option.selected = true;
                        }
                        klasifikasiSelect.add(option);
                    });
                })
                .catch(error => {
                    console.error('Error:', error);
                    klasifikasiSelect.innerHTML = '<option value="">Error loading data</option>';
                    klasifikasiSelect.disabled = false;
                });
        }
    });

    // Trigger change event pada load untuk memuat klasifikasi yang sesuai
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('parent').dispatchEvent(new Event('change'));
    });
</script>

<?php $this->load->view('navbar/footer'); ?>