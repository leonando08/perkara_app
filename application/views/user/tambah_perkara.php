<div class="container mt-4">
    <h2>Tambah Perkara</h2>

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
        <div class="mb-3">
            <label>Asal Pengadilan</label>
            <input type="text" name="asal_pengadilan" class="form-control"
                value="<?= set_value('asal_pengadilan') ?>" required>
        </div>

        <div class="mb-3">
            <label>Nomor Perkara Tk1</label>
            <input type="text" name="nomor_perkara_tk1" class="form-control"
                value="<?= set_value('nomor_perkara_tk1') ?>">
        </div>

        <div class="mb-3">
            <label>Klasifikasi</label>
            <input type="text" name="klasifikasi" class="form-control"
                value="<?= set_value('klasifikasi') ?>" required>
        </div>

        <div class="mb-3">
            <label>Tgl Register Banding</label>
            <input type="date" name="tgl_register_banding" class="form-control"
                value="<?= set_value('tgl_register_banding') ?>" required>
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-select" required>
                <option value="Proses" <?= set_select('status', 'Proses') ?>>Proses</option>
                <option value="Selesai" <?= set_select('status', 'Selesai') ?>>Selesai</option>
                <option value="Ditolak" <?= set_select('status', 'Ditolak') ?>>Ditolak</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="<?= site_url('perkara/dashboard') ?>" class="btn btn-secondary">Kembali</a>
    </form>
</div>