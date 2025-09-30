<?php require_once(APPPATH . 'views/navbar/header.php'); ?>

<div class="content-wrapper">
    <div class="content-card mb-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">Tambah Data Perkara</h4>
            <a href="<?= site_url('perkara/dashboard') ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= $error ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert" id="alertBox">
                <?= $success ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <script>
                setTimeout(function() {
                    window.location.href = "<?= site_url('perkara/dashboard') ?>";
                }, 2000);
            </script>
        <?php endif; ?>

        <form method="post" class="needs-validation" novalidate>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Asal Pengadilan<span class="text-danger">*</span></label>
                    <input type="text" name="asal_pengadilan" class="form-control" required
                        value="<?= htmlspecialchars($this->input->post('asal_pengadilan')) ?>">
                    <div class="invalid-feedback">Asal pengadilan harus diisi</div>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Nomor Perkara Tk1<span class="text-danger">*</span></label>
                    <input type="text" name="nomor_perkara_tk1" class="form-control" required
                        value="<?= htmlspecialchars($this->input->post('nomor_perkara_tk1')) ?>">
                    <div class="invalid-feedback">Nomor perkara tk1 harus diisi</div>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Parent</label>
                    <select name="parent" id="parent" class="form-select" required>
                        <option value="">-- Pilih Parent --</option>
                        <?php foreach ($parents as $p): ?>
                            <option value="<?= $p->id ?>" <?= ($this->input->post('parent') == $p->id) ? 'selected' : '' ?>>
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
                    <label class="form-label">Tanggal Register Banding</label>
                    <input type="date" name="tgl_register_banding" class="form-control"
                        value="<?= htmlspecialchars($this->input->post('tgl_register_banding')) ?>" required>
                    <div class="invalid-feedback">Tanggal register banding harus diisi</div>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Nomor Perkara Banding</label>
                    <input type="text" name="nomor_perkara_banding" class="form-control"
                        value="<?= htmlspecialchars($this->input->post('nomor_perkara_banding')) ?>">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Lama Proses</label>
                    <input type="text" name="lama_proses" class="form-control"
                        value="<?= htmlspecialchars($this->input->post('lama_proses')) ?>">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Status Perkara Tk Banding</label>
                    <input type="text" name="status_perkara_tk_banding" class="form-control"
                        value="<?= htmlspecialchars($this->input->post('status_perkara_tk_banding')) ?>">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Pemberitahuan Putusan Banding</label>
                    <input type="date" name="pemberitahuan_putusan_banding" class="form-control"
                        value="<?= htmlspecialchars($this->input->post('pemberitahuan_putusan_banding')) ?>">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Permohonan Kasasi</label>
                    <input type="date" name="permohonan_kasasi" class="form-control"
                        value="<?= htmlspecialchars($this->input->post('permohonan_kasasi')) ?>">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Pengiriman Berkas Kasasi</label>
                    <input type="date" name="pengiriman_berkas_kasasi" class="form-control"
                        value="<?= htmlspecialchars($this->input->post('pengiriman_berkas_kasasi')) ?>">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select" required>
                        <option value="">-- Pilih Status --</option>
                        <option value="Proses" <?= ($this->input->post('status') == 'Proses') ? 'selected' : '' ?>>Proses</option>
                        <option value="Selesai" <?= ($this->input->post('status') == 'Selesai') ? 'selected' : '' ?>>Selesai</option>
                        <option value="Ditolak" <?= ($this->input->post('status') == 'Ditolak') ? 'selected' : '' ?>>Ditolak</option>
                    </select>
                    <div class="invalid-feedback">Status harus dipilih</div>
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Simpan
                </button>
                <a href="<?= site_url('perkara/dashboard') ?>" class="btn btn-light ms-2">Batal</a>
            </div>
        </form>
    </div>

    <?php require_once(APPPATH . 'views/navbar/footer.php'); ?>

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

        // Jika ada nilai parent yang sudah dipilih (misal saat validation error), trigger change event
        if (document.getElementById('parent').value) {
            document.getElementById('parent').dispatchEvent(new Event('change'));
        }
    </script>