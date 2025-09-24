<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<?php $this->load->view('navbar/header'); ?>

<div class="container mt-4">
    <h2>Edit Data Perkara</h2>

    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
    <?php endif; ?>

    <?php if (isset($perkara)): ?>
        <form action="<?= site_url('perkara/edit/' . $perkara->id) ?>" method="post">
            <div class="mb-3">
                <label>Asal Pengadilan</label>
                <input type="text" name="asal_pengadilan" class="form-control"
                    value="<?= htmlspecialchars($perkara->asal_pengadilan) ?>" required>
            </div>

            <div class="mb-3">
                <label>Nomor Perkara Tk1</label>
                <input type="text" name="nomor_perkara_tk1" class="form-control"
                    value="<?= htmlspecialchars($perkara->nomor_perkara_tk1) ?>">
            </div>

            <div class="mb-3">
                <label>Klasifikasi</label>
                <input type="text" name="klasifikasi" class="form-control"
                    value="<?= htmlspecialchars($perkara->klasifikasi) ?>">
            </div>

            <div class="mb-3">
                <label>Tgl Register Banding</label>
                <input type="date" name="tgl_register_banding" class="form-control"
                    value="<?= htmlspecialchars($perkara->tgl_register_banding) ?>">
            </div>

            <div class="mb-3">
                <label>Nomor Perkara Banding</label>
                <input type="text" name="nomor_perkara_banding" class="form-control"
                    value="<?= htmlspecialchars($perkara->nomor_perkara_banding) ?>">
            </div>

            <div class="mb-3">
                <label>Lama Proses</label>
                <input type="text" name="lama_proses" class="form-control"
                    value="<?= htmlspecialchars($perkara->lama_proses) ?>">
            </div>

            <div class="mb-3">
                <label>Status Perkara Tk Banding</label>
                <input type="text" name="status_perkara_tk_banding" class="form-control"
                    value="<?= htmlspecialchars($perkara->status_perkara_tk_banding) ?>">
            </div>

            <div class="mb-3">
                <label>Pemberitahuan Putusan Banding</label>
                <input type="date" name="pemberitahuan_putusan_banding" class="form-control"
                    value="<?= htmlspecialchars($perkara->pemberitahuan_putusan_banding) ?>">
            </div>

            <div class="mb-3">
                <label>Permohonan Kasasi</label>
                <input type="date" name="permohonan_kasasi" class="form-control"
                    value="<?= htmlspecialchars($perkara->permohonan_kasasi) ?>">
            </div>

            <div class="mb-3">
                <label>Pengiriman Berkas Kasasi</label>
                <input type="date" name="pengiriman_berkas_kasasi" class="form-control"
                    value="<?= htmlspecialchars($perkara->pengiriman_berkas_kasasi) ?>">
            </div>

            <div class="mb-3">
                <label>Status</label>
                <select name="status" class="form-control" required>
                    <option value="Proses" <?= $perkara->status === 'Proses' ? 'selected' : '' ?>>Proses</option>
                    <option value="Selesai" <?= $perkara->status === 'Selesai' ? 'selected' : '' ?>>Selesai</option>
                    <option value="Ditolak" <?= $perkara->status === 'Ditolak' ? 'selected' : '' ?>>Ditolak</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="<?= site_url('perkara/dashboard') ?>" class="btn btn-secondary">Kembali</a>
        </form>
    <?php else: ?>
        <p class="text-danger">Data perkara tidak ditemukan.</p>
    <?php endif; ?>
</div>

<?php $this->load->view('navbar/footer'); ?>