<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view('navbar/header');
?>

<style>
    .main-content {
        margin-left: 0;
        width: 100%;
        min-height: calc(100vh - 60px);
        background: #f8f9fa;
        padding: 0;
        transition: all 0.3s ease;
    }

    .content-wrapper {
        padding: 1.5rem;
        margin: 0;
        width: 100%;
        box-sizing: border-box;
        max-width: 100%;
    }

    .page-header {
        background: white;
        border-radius: 0.5rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .page-title {
        font-size: 1.75rem;
        font-weight: 600;
        color: #2d3748;
        margin-bottom: 0.5rem;
    }

    .filter-card {
        background: white;
        border-radius: 0.5rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .action-buttons {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.625rem 1.25rem;
        border-radius: 0.375rem;
        font-weight: 500;
        font-size: 0.875rem;
        text-decoration: none;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .btn-primary {
        background: #007bff;
        color: white;
    }

    .btn-primary:hover {
        background: #0056b3;
        color: white;
    }

    .btn-success {
        background: #28a745;
        color: white;
    }

    .btn-success:hover {
        background: #1e7e34;
        color: white;
    }

    .btn-info {
        background: #17a2b8;
        color: white;
    }

    .btn-info:hover {
        background: #117a8b;
        color: white;
    }

    .btn-secondary {
        background: #6c757d;
        color: white;
    }

    .btn-secondary:hover {
        background: #545b62;
        color: white;
    }

    .table-wrapper {
        background: white;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12);
        border-radius: 0.5rem;
        overflow: hidden;
        margin-bottom: 1.5rem;
    }

    .table {
        width: 100%;
        margin-bottom: 0;
        border-collapse: collapse;
    }

    .table th,
    .table td {
        padding: 1rem;
        text-align: center;
        border-bottom: 1px solid #dee2e6;
        vertical-align: middle;
    }

    .table th {
        background: #198754;
        color: white;
        font-weight: 600;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        border: none;
    }

    .table tbody tr:hover {
        background: #f8f9fa;
    }

    .table .total-row {
        background: #fff3cd !important;
        font-weight: bold;
        border-top: 2px solid #ffc107;
    }

    .table .total-row td {
        color: #856404;
        font-size: 1.1em;
    }

    .badge {
        padding: 0.375rem 0.75rem;
        border-radius: 0.375rem;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .badge-kasasi {
        background: #dc3545;
        color: white;
    }

    .badge-tidak-kasasi {
        background: #28a745;
        color: white;
    }

    .badge-putus {
        background: #007bff;
        color: white;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .stat-card {
        background: white;
        border-radius: 0.5rem;
        padding: 1.5rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        text-align: center;
        border-left: 4px solid #198754;
    }

    .stat-number {
        font-size: 2rem;
        font-weight: bold;
        color: #198754;
        margin-bottom: 0.5rem;
    }

    .stat-label {
        color: #6c757d;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .form-select {
        padding: 0.5rem 0.75rem;
        border: 1px solid #ced4da;
        border-radius: 0.375rem;
        font-size: 0.875rem;
        background: white;
    }

    .form-select:focus {
        border-color: #80bdff;
        outline: 0;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }
</style>

<div class="main-content">
    <div class="content-wrapper">
        <!-- Page Header -->
        <div class="page-header">
            <div>
                <h2 class="page-title">
                    Laporan Rekap Perkara Pidana Banding
                    <?php if (isset($bulan) && $bulan): ?>
                        <br><small class="text-muted">Bulan <?= $nama_bulan_terpilih ?> <?= $tahun ?></small>
                    <?php else: ?>
                        <br><small class="text-muted">Tahun <?= $tahun ?></small>
                    <?php endif; ?>
                </h2>
                <p class="text-muted mb-0">
                    Selamat datang, <b><?= htmlspecialchars($this->session->userdata('username') ?? 'Guest'); ?></b>
                    (<?= ucfirst($this->session->userdata('role') ?? 'User'); ?>)
                </p>
            </div>
            <div class="action-buttons">
                <a href="<?= site_url('laporan/cetak_rekap_excel?tahun=' . $tahun . (isset($bulan) && $bulan ? '&bulan=' . $bulan : '')); ?>" class="btn btn-success">
                    <i class="fas fa-file-excel"></i> Ekspor Excel
                </a>
                <a href="<?= site_url('laporan'); ?>" class="btn btn-info">
                    <i class="fas fa-arrow-left"></i> Kembali ke Laporan
                </a>
            </div>
        </div>

        <!-- Filter Tahun dan Bulan -->
        <div class="filter-card">
            <form method="GET" style="display: flex; align-items: center; gap: 1rem; flex-wrap: wrap;">
                <div style="display: flex; align-items: center; gap: 0.5rem;">
                    <label for="tahun" style="font-weight: 600; color: #495057;">Filter Tahun:</label>
                    <select name="tahun" id="tahun" class="form-select" style="width: auto;">
                        <?php foreach ($tahun_options as $year): ?>
                            <option value="<?= $year ?>" <?= ($year == $tahun) ? 'selected' : '' ?>>
                                <?= $year ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div style="display: flex; align-items: center; gap: 0.5rem;">
                    <label for="bulan" style="font-weight: 600; color: #495057;">Filter Bulan:</label>
                    <select name="bulan" id="bulan" class="form-select" style="width: auto;">
                        <option value="">Semua Bulan</option>
                        <option value="01" <?= (isset($bulan) && $bulan == '01') ? 'selected' : '' ?>>Januari</option>
                        <option value="02" <?= (isset($bulan) && $bulan == '02') ? 'selected' : '' ?>>Februari</option>
                        <option value="03" <?= (isset($bulan) && $bulan == '03') ? 'selected' : '' ?>>Maret</option>
                        <option value="04" <?= (isset($bulan) && $bulan == '04') ? 'selected' : '' ?>>April</option>
                        <option value="05" <?= (isset($bulan) && $bulan == '05') ? 'selected' : '' ?>>Mei</option>
                        <option value="06" <?= (isset($bulan) && $bulan == '06') ? 'selected' : '' ?>>Juni</option>
                        <option value="07" <?= (isset($bulan) && $bulan == '07') ? 'selected' : '' ?>>Juli</option>
                        <option value="08" <?= (isset($bulan) && $bulan == '08') ? 'selected' : '' ?>>Agustus</option>
                        <option value="09" <?= (isset($bulan) && $bulan == '09') ? 'selected' : '' ?>>September</option>
                        <option value="10" <?= (isset($bulan) && $bulan == '10') ? 'selected' : '' ?>>Oktober</option>
                        <option value="11" <?= (isset($bulan) && $bulan == '11') ? 'selected' : '' ?>>November</option>
                        <option value="12" <?= (isset($bulan) && $bulan == '12') ? 'selected' : '' ?>>Desember</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-success">
                    <i class="fas fa-filter"></i> Filter
                </button>

                <a href="<?= site_url('laporan/rekap'); ?>" class="btn btn-secondary">
                    <i class="fas fa-undo"></i> Reset Filter
                </a>
            </form>
        </div>

        <!-- Stats Summary -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-number"><?= $rekap_total['jumlah_kasasi'] ?></div>
                <div class="stat-label">Total Kasasi</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?= $rekap_total['jumlah_tidak_kasasi'] ?></div>
                <div class="stat-label">Total Tidak Kasasi</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?= $rekap_total['jumlah_putus_banding'] ?></div>
                <div class="stat-label">Total Putus Banding</div>
            </div>
        </div>

        <!-- Tabel Rekap per Bulan -->
        <div class="table-wrapper">
            <table class="table">
                <thead>
                    <tr>
                        <th style="width: 25%;">Bulan</th>
                        <th style="width: 25%;">Kasasi (Lanjut)</th>
                        <th style="width: 25%;">Tidak Kasasi (Tidak Lanjut)</th>
                        <th style="width: 25%;">Putus Banding</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rekap_bulanan as $row): ?>
                        <tr>
                            <td style="font-weight: 600;"><?= $row['nama_bulan'] ?></td>
                            <td>
                                <?php if ($row['jumlah_kasasi'] > 0): ?>
                                    <span class="badge badge-kasasi"><?= $row['jumlah_kasasi'] ?></span>
                                <?php else: ?>
                                    0
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($row['jumlah_tidak_kasasi'] > 0): ?>
                                    <span class="badge badge-tidak-kasasi"><?= $row['jumlah_tidak_kasasi'] ?></span>
                                <?php else: ?>
                                    0
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($row['jumlah_putus_banding'] > 0): ?>
                                    <span class="badge badge-putus"><?= $row['jumlah_putus_banding'] ?></span>
                                <?php else: ?>
                                    0
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <tr class="total-row">
                        <td><strong>TOTAL TAHUN <?= $tahun ?></strong></td>
                        <td><strong><?= $rekap_total['jumlah_kasasi'] ?></strong></td>
                        <td><strong><?= $rekap_total['jumlah_tidak_kasasi'] ?></strong></td>
                        <td><strong><?= $rekap_total['jumlah_putus_banding'] ?></strong></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Keterangan -->
        <div class="filter-card">
            <h6 class="mb-3">
                <i class="fas fa-info-circle me-2"></i>
                Keterangan
            </h6>
            <ul class="list-unstyled mb-0">
                <li class="mb-2">
                    <i class="fas fa-circle text-danger me-2"></i>
                    <strong>Kasasi (Lanjut):</strong> Perkara yang memiliki tanggal permohonan kasasi
                </li>
                <li class="mb-2">
                    <i class="fas fa-circle text-success me-2"></i>
                    <strong>Tidak Kasasi:</strong> Perkara yang tidak memiliki tanggal permohonan kasasi
                </li>
                <li class="mb-0">
                    <i class="fas fa-circle text-primary me-2"></i>
                    <strong>Putus Banding:</strong> Perkara yang memiliki tanggal pemberitahuan putusan banding
                </li>
            </ul>
        </div>
    </div>
</div>

<?php $this->load->view('navbar/footer'); ?>