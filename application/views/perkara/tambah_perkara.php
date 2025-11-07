<?php require_once(APPPATH . 'views/navbar/header.php'); ?>

<style>
    /* Enhanced datalist styling for better dropdown experience */
    input[list] {
        position: relative;
    }

    /* Make sure datalist dropdown is properly styled */
    datalist {
        position: absolute;
        background-color: white;
        border: 1px solid #ccc;
        border-radius: 4px;
        max-height: 200px;
        overflow-y: auto;
        z-index: 1000;
    }

    /* Ensure the input can trigger dropdown properly */
    #klasifikasi {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
        background-position: right 8px center;
        background-repeat: no-repeat;
        background-size: 16px 12px;
        padding-right: 35px;
        cursor: pointer;
    }

    /* Style untuk browser yang mendukung datalist dengan lebih baik */
    @supports (background: -webkit-named-image(menulist-button)) {
        #klasifikasi {
            background-image: none;
            -webkit-appearance: textfield;
        }
    }
</style>

<div class="content-wrapper">
    <div class="">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">Tambah Data Perkara</h4>
            <a href="<?= site_url('perkara/dashboard') ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>

        <?php if (!empty($error)): ?>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        html: '<?= addslashes($error) ?>',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#dc3545'
                    });
                });
            </script>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: '<?= addslashes($success) ?>',
                        showConfirmButton: true,
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#28a745',
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    }).then(() => {
                        window.location.href = "<?= site_url('perkara/dashboard') ?>";
                    });
                });
            </script>
        <?php endif; ?>

        <form method="post" class="needs-validation" novalidate>
            <div class="row g-3">
                <div class="content-card mb-6">
                    <h5>Tingkat Pertama</h5>
                    <hr>
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label">Asal Pengadilan</label>
                            <!-- Tampilkan kosong di frontend sesuai permintaan pembimbing; nilai sebenarnya diambil dari session di backend -->
                            <input type="text" class="form-control" value="" autocomplete="off" disabled>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Nomor Perkara Tk1<span class="text-danger">*</span></label>
                            <input type="text" name="nomor_perkara_tk1" class="form-control" required
                                value="<?= htmlspecialchars($this->input->post('nomor_perkara_tk1')) ?>">
                            <div class="invalid-feedback">Nomor perkara tk1 harus diisi</div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Jenis Perkara<span class="text-danger">*</span></label>
                            <select name="perkara" class="form-select" required>
                                <option value="">-- Pilih Jenis Perkara --</option>
                                <option value="PIDANA" <?= ($this->input->post('perkara') == 'PIDANA') ? 'selected' : '' ?>>PIDANA</option>
                                <option value="PERDATA" <?= ($this->input->post('perkara') == 'PERDATA') ? 'selected' : '' ?>>PERDATA</option>
                                <option value="ANAK" <?= ($this->input->post('perkara') == 'ANAK') ? 'selected' : '' ?>>ANAK</option>
                                <option value="TIPIKOR" <?= ($this->input->post('perkara') == 'TIPIKOR') ? 'selected' : '' ?>>TIPIKOR</option>
                            </select>
                            <div class="invalid-feedback">Jenis perkara harus dipilih</div>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Klasifikasi<span class="text-danger">*</span></label>
                            <div class="position-relative">
                                <input type="text"
                                    name="klasifikasi"
                                    id="klasifikasi"
                                    class="form-control"
                                    list="klasifikasi-options"
                                    value="<?= htmlspecialchars($this->input->post('klasifikasi')) ?>"
                                    placeholder="Pilih atau ketik klasifikasi..."
                                    autocomplete="off"
                                    required>
                                <datalist id="klasifikasi-options">
                                    <?php if (isset($jenis_perkara) && is_array($jenis_perkara) && count($jenis_perkara) > 0): ?>
                                        <?php foreach ($jenis_perkara as $jp): ?>
                                            <option value="<?= htmlspecialchars($jp->nama) ?>"></option>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <!-- Fallback hardcode data -->
                                        <option value="Perdata"></option>
                                        <option value="Pidana"></option>
                                        <option value="Gugatan"></option>
                                        <option value="Permohonan"></option>
                                        <option value="Tindak Pidana Korupsi"></option>
                                        <option value="Penganiayaan"></option>
                                        <option value="Pencurian"></option>
                                        <option value="Penipuan"></option>
                                        <option value="Pemerasan dan Pengancaman"></option>
                                        <option value="Penggelapan"></option>
                                    <?php endif; ?>
                                </datalist>
                            </div>
                            <div class="invalid-feedback">Klasifikasi harus diisi</div>
                            <small class="form-text text-muted">Klik untuk melihat semua pilihan atau ketik untuk mencari</small>
                        </div>
                    </div>
                </div>

                <div class="content-card mb-6">
                    <h5>Tingkat Banding</h5>
                    <hr>
                    <div class="row g-3">
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
                            <input type="number" name="lama_proses" id="lama_proses" class="form-control"
                                value="<?= htmlspecialchars($this->input->post('lama_proses')) ?>" min="0" step="1">
                            <div class="form-text" id="lamaProsesPreview"></div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Status Perkara Tk Banding</label>
                            <input type="date" name="status_perkara_tk_banding_date" id="status_perkara_tk_banding_date" class="form-control">
                            <input type="hidden" name="status_perkara_tk_banding" id="status_perkara_tk_banding"
                                value="<?= htmlspecialchars($this->input->post('status_perkara_tk_banding')) ?>">
                            <small class="form-text text-muted">Format otomatis: Putusan Banding PT tanggal : [tanggal yang Anda pilih]</small>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Pemberitahuan Putusan Banding</label>
                            <input type="date" name="pemberitahuan_putusan_banding" class="form-control"
                                value="<?= htmlspecialchars($this->input->post('pemberitahuan_putusan_banding')) ?>">
                        </div>
                    </div>
                </div>

                <div class="content-card mb-6">
                    <h5>Tingkat Kasasi</h5>
                    <hr>
                    <div class="row g-3">
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

                        <div class="col-md-12">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select" required>
                                <option value="">-- Pilih Status --</option>
                                <option value="Proses" <?= ($this->input->post('status') == 'Proses') ? 'selected' : '' ?>>Proses</option>
                                <option value="Selesai" <?= ($this->input->post('status') == 'Selesai') ? 'selected' : '' ?>>Selesai</option>
                            </select>
                            <div class="invalid-feedback">Status harus dipilih</div>
                        </div>
                    </div>
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

        // Auto format Status Perkara Tk Banding dengan tanggal
        document.addEventListener('DOMContentLoaded', function() {
            const dateInput = document.getElementById('status_perkara_tk_banding_date');
            const hiddenInput = document.getElementById('status_perkara_tk_banding');

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

        // Simple autocomplete functionality for klasifikasi
        document.addEventListener('DOMContentLoaded', function() {
            const klasifikasiInput = document.getElementById('klasifikasi');
            const datalist = document.getElementById('klasifikasi-options');

            // Debug info
            console.log('PHP Jenis Perkara data:', <?= json_encode(isset($jenis_perkara) ? $jenis_perkara : 'undefined') ?>);

            if (!klasifikasiInput || !datalist) {
                console.error('Klasifikasi elements not found');
                return;
            }

            // Get all options from datalist
            const options = Array.from(datalist.options).map(option => option.value);
            console.log('Available options:', options);

            // Show all options on focus
            klasifikasiInput.addEventListener('focus', function() {
                console.log('Input focused, showing all options');
            });

            // Show all options on click
            klasifikasiInput.addEventListener('click', function() {
                console.log('Input clicked, showing all options');
            });

            // Filter options on input
            klasifikasiInput.addEventListener('input', function() {
                const value = this.value.toLowerCase();
                console.log('Input value:', value);
            });
        });

        // Preview "Hari" untuk input lama proses
        document.addEventListener('DOMContentLoaded', function() {
            const lamaProsesInput = document.getElementById('lama_proses');
            const preview = document.getElementById('lamaProsesPreview');

            function updatePreview() {
                const val = lamaProsesInput.value;
                if (val && !isNaN(val)) {
                    preview.textContent = val + ' Hari';
                } else {
                    preview.textContent = '';
                }
            }
            lamaProsesInput.addEventListener('input', updatePreview);
            updatePreview(); // initial
        });
    </script>