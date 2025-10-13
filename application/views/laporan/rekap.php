<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view('navbar/header');
?>

<style>
    /* Layout yang professional dan modern - Version SANGAT DEKAT - <?= time(); ?> */

    /* Reset body untuk memastikan tidak ada overflow */
    /* Layout now handled by global-layout.css - removed duplicate styles */
    body .main-content {
        background: linear-gradient(135deg, #f5f7fa 0%, #e4e9f0 100%) !important;
    }

    .page-header {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        flex-wrap: wrap;
        gap: 1rem;
        border: 1px solid rgba(0, 0, 0, 0.05);
    }

    .page-title {
        font-size: 1.75rem;
        font-weight: 600;
        color: #2d3748;
        margin-bottom: 0.5rem;
        line-height: 1.2;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .page-title::before {
        content: '';
        width: 4px;
        height: 2.5rem;
        background: linear-gradient(135deg, #198754, #0d4b2e);
        border-radius: 4px;
    }

    .filter-card {
        background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        padding: 1.5rem;
        margin-bottom: 2rem;
        border: 1px solid rgba(0, 0, 0, 0.05);
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
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.875rem;
        text-decoration: none;
        border: none;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        position: relative;
        overflow: hidden;
    }

    .btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.2);
        transition: left 0.4s ease;
    }

    .btn:hover::before {
        left: 100%;
    }

    .btn-primary {
        background: linear-gradient(135deg, #007bff, #0056b3);
        color: white;
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #0056b3, #003d82);
        transform: translateY(-2px);
        box-shadow: 0 4px 16px rgba(0, 123, 255, 0.3);
    }

    .btn-success {
        background: linear-gradient(135deg, #198754, #0d4b2e);
        color: white;
    }

    .btn-success:hover {
        background: linear-gradient(135deg, #0d4b2e, #083920);
        transform: translateY(-2px);
        box-shadow: 0 4px 16px rgba(25, 135, 84, 0.3);
    }

    .btn-info {
        background: linear-gradient(135deg, #17a2b8, #117a8b);
        color: white;
    }

    .btn-info:hover {
        background: linear-gradient(135deg, #117a8b, #0c5460);
        transform: translateY(-2px);
        box-shadow: 0 4px 16px rgba(23, 162, 184, 0.3);
    }

    .btn-secondary {
        background: linear-gradient(135deg, #6c757d, #545b62);
        color: white;
    }

    .btn-secondary:hover {
        background: linear-gradient(135deg, #545b62, #3d4349);
        transform: translateY(-2px);
        box-shadow: 0 4px 16px rgba(108, 117, 125, 0.3);
    }

    .table-wrapper {
        background: white;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        border-radius: 12px;
        overflow: hidden;
        margin-bottom: 2rem;
        border: 1px solid rgba(0, 0, 0, 0.05);
    }

    .table {
        width: 100%;
        margin-bottom: 0;
        border-collapse: collapse;
    }

    .table th,
    .table td {
        padding: 1.25rem 1rem;
        text-align: center;
        border-bottom: 1px solid #e9ecef;
        vertical-align: middle;
        transition: all 0.2s ease;
    }

    .table th {
        background: linear-gradient(135deg, #198754, #0d4b2e);
        color: white;
        font-weight: 700;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.075em;
        border: none;
        position: relative;
    }

    .table th::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 3px;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
    }

    .table tbody tr {
        transition: all 0.3s ease;
    }

    .table tbody tr:hover {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        transform: scale(1.01);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .table .total-row {
        background: linear-gradient(135deg, #fff3cd 0%, #ffe69c 100%) !important;
        font-weight: bold;
        border-top: 3px solid #ffc107;
        box-shadow: 0 -2px 8px rgba(255, 193, 7, 0.2);
    }

    .table .total-row td {
        color: #856404;
        font-size: 1.15em;
        font-weight: 700;
        padding: 1.5rem 1rem;
    }

    .badge {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.075em;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        transition: all 0.3s ease;
    }

    .badge::before {
        content: '';
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: currentColor;
        animation: pulse 2s ease-in-out infinite;
    }

    @keyframes pulse {

        0%,
        100% {
            opacity: 1;
            transform: scale(1);
        }

        50% {
            opacity: 0.5;
            transform: scale(1.2);
        }
    }

    .badge-kasasi {
        background: linear-gradient(135deg, #dc3545, #bd2130);
        color: white;
    }

    .badge-kasasi:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 16px rgba(220, 53, 69, 0.3);
    }

    .badge-tidak-kasasi {
        background: linear-gradient(135deg, #198754, #0d4b2e);
        color: white;
    }

    .badge-tidak-kasasi:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 16px rgba(25, 135, 84, 0.3);
    }

    .badge-putus {
        background: linear-gradient(135deg, #007bff, #0056b3);
        color: white;
    }

    .badge-putus:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 16px rgba(0, 123, 255, 0.3);
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
        border-radius: 12px;
        padding: 2rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        text-align: center;
        border-left: 5px solid #198754;
        border: 1px solid rgba(0, 0, 0, 0.05);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(25, 135, 84, 0.1) 0%, transparent 70%);
        transform: rotate(45deg);
    }

    .stat-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 8px 32px rgba(25, 135, 84, 0.2);
    }

    .stat-number {
        font-size: 3rem;
        font-weight: 800;
        background: linear-gradient(135deg, #198754, #0d4b2e);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 0.75rem;
        position: relative;
    }

    .stat-label {
        color: #6c757d;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        font-weight: 600;
        position: relative;
    }

    .form-select {
        padding: 0.75rem 1rem;
        border: 2px solid #e9ecef;
        border-radius: 8px;
        font-size: 0.875rem;
        background: white;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .form-select:hover {
        border-color: #198754;
    }

    .form-select:focus {
        border-color: #198754;
        outline: 0;
        box-shadow: 0 0 0 0.25rem rgba(25, 135, 84, 0.15);
        background: #f8f9fa;
    }

    /* Smooth Animations */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .page-header,
    .filter-card,
    .stats-grid,
    .table-wrapper {
        animation: fadeInUp 0.6s ease-out;
    }

    .stats-grid .stat-card:nth-child(1) {
        animation-delay: 0.1s;
    }

    .stats-grid .stat-card:nth-child(2) {
        animation-delay: 0.2s;
    }

    .stats-grid .stat-card:nth-child(3) {
        animation-delay: 0.3s;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .content-wrapper {
            padding: 1rem;
        }

        .page-title {
            font-size: 1.5rem;
        }

        .stat-number {
            font-size: 2rem;
        }

        .table th,
        .table td {
            padding: 0.75rem 0.5rem;
            font-size: 0.8rem;
        }
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