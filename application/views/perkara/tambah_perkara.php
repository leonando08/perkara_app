<?php require_once(APPPATH . 'views/navbar/header.php'); ?>

<div class="container mt-4">
    <h2 class="mb-4">Tambah Perkara</h2>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <div class="alert alert-success">
            <?= $success ?>
            <script>
                setTimeout(function() {
                    window.location.href = "<?= site_url('perkara/dashboard') ?>";
                }, 2000);
            </script>
        </div>
    <?php endif; ?>

    <form method="post">
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label>Asal Pengadilan</label>
                    <input type="text" name="asal_pengadilan" class="form-control"
                        value="<?= htmlspecialchars($this->input->post('asal_pengadilan')) ?>" required>
                </div>

                <div class="mb-3">
                    <label>Nomor Perkara Tk1</label>
                    <input type="text" name="nomor_perkara_tk1" class="form-control"
                        value="<?= htmlspecialchars($this->input->post('nomor_perkara_tk1')) ?>">
                </div>

                <div class="mb-3">
                    <label>Parent</label>
                    <input type="text" name="parent" class="form-control"
                        value="<?= htmlspecialchars($this->input->post('parent')) ?>">
                </div>

                <div class="mb-3">
                    <label>Klasifikasi</label>
                    <input type="text" name="klasifikasi" class="form-control"
                        value="<?= htmlspecialchars($this->input->post('klasifikasi')) ?>" required>
                </div>

                <div class="mb-3">
                    <label>Tanggal Register Banding</label>
                    <input type="date" name="tgl_register_banding" class="form-control"
                        value="<?= htmlspecialchars($this->input->post('tgl_register_banding')) ?>" required>
                </div>

                <div class="mb-3">
                    <label>Nomor Perkara Banding</label>
                    <input type="text" name="nomor_perkara_banding" class="form-control"
                        value="<?= htmlspecialchars($this->input->post('nomor_perkara_banding')) ?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label>Lama Proses (hari)</label>
                    <input type="number" name="lama_proses" class="form-control"
                        value="<?= htmlspecialchars($this->input->post('lama_proses')) ?>">
                </div>

                <div class="mb-3">
                    <label>Status Perkara Tk Banding</label>
                    <input type="text" name="status_perkara_tk_banding" class="form-control"
                        value="<?= htmlspecialchars($this->input->post('status_perkara_tk_banding')) ?>">
                </div>

                <div class="mb-3">
                    <label>Pemberitahuan Putusan Banding</label>
                    <input type="date" name="pemberitahuan_putusan_banding" class="form-control"
                        value="<?= htmlspecialchars($this->input->post('pemberitahuan_putusan_banding')) ?>">
                </div>

                <div class="mb-3">
                    <label>Permohonan Kasasi</label>
                    <input type="date" name="permohonan_kasasi" class="form-control"
                        value="<?= htmlspecialchars($this->input->post('permohonan_kasasi')) ?>">
                </div>

                <div class="mb-3">
                    <label>Pengiriman Berkas Kasasi</label>
                    <input type="date" name="pengiriman_berkas_kasasi" class="form-control"
                        value="<?= htmlspecialchars($this->input->post('pengiriman_berkas_kasasi')) ?>">
                </div>

                <div class="mb-3">
                    <label>Status</label>
                    <select name="status" class="form-select" required>
                        <option value="Proses" <?= ($this->input->post('status') == 'Proses') ? 'selected' : '' ?>>Proses</option>
                        <option value="Selesai" <?= ($this->input->post('status') == 'Selesai') ? 'selected' : '' ?>>Selesai</option>
                        <option value="Ditolak" <?= ($this->input->post('status') == 'Ditolak') ? 'selected' : '' ?>>Ditolak</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="mt-3">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="<?= site_url('perkara/dashboard') ?>" class="btn btn-secondary">Kembali</a>
        </div>
    </form>
</div>

<?php require_once(APPPATH . 'views/navbar/footer.php'); ?>
</div>