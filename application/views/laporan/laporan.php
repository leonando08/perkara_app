<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<?php $this->load->view('navbar/header'); ?>

<style>
    /* Main Content Layout */
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

    /* Page Header */
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

    /* Filter Card */
    .filter-card {
        background: white;
        border-radius: 0.5rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .filter-form {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        align-items: end;
    }

    /* Table Container */
    .table-wrapper {
        position: relative;
        margin-bottom: 1rem;
        background: white;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12);
        border-radius: 0.5rem;
        overflow: hidden;
    }

    .table-responsive {
        overflow: auto;
        margin: 0;
        padding: 0;
        max-width: 100%;
        max-height: 70vh;
        position: relative;
        scroll-behavior: smooth;
    }

    .table {
        width: max-content;
        min-width: 100%;
        margin-bottom: 0;
        background-color: white;
        border-collapse: separate;
        border-spacing: 0;
        font-size: 0.875rem;
    }

    /* Reset semua kolom untuk tidak sticky */
    .table th,
    .table td {
        position: static !important;
        left: auto !important;
        right: auto !important;
    }

    /* Sticky Header */
    .table thead {
        background-color: #198754;
        position: sticky;
        top: 0;
        z-index: 10;
    }

    .table thead th {
        background-color: #198754;
        color: white;
        font-weight: 600;
        padding: 0.75rem;
        white-space: nowrap;
        vertical-align: middle;
        border: 1px solid rgba(255, 255, 255, 0.1);
        position: sticky;
        top: 0;
        z-index: 10;
    }

    .table tbody td {
        padding: 0.75rem;
        vertical-align: middle;
        border: 1px solid #dee2e6;
        white-space: nowrap;
        background-color: white;
    }

    .table tbody tr:hover td {
        background-color: rgba(25, 135, 84, 0.05);
        transition: background-color 0.2s ease;
    }

    /* Column Widths */
    .table .number-column {
        min-width: 60px;
        max-width: 60px;
        text-align: center;
    }

    .table .text-column {
        min-width: 150px;
        max-width: 200px;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .table .date-column {
        min-width: 130px;
        max-width: 130px;
    }

    .table .status-column {
        min-width: 100px;
        max-width: 100px;
        text-align: center;
    }

    /* Action Buttons */
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
        text-decoration: none;
        border: none;
        transition: all 0.2s ease;
        cursor: pointer;
        font-size: 0.875rem;
    }

    .btn-success {
        background-color: #198754;
        color: white;
    }

    .btn-success:hover {
        background-color: #157347;
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(25, 135, 84, 0.3);
    }

    .btn-secondary {
        background-color: #6c757d;
        color: white;
    }

    .btn-secondary:hover {
        background-color: #5c636a;
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(108, 117, 125, 0.3);
    }

    .btn-primary {
        background-color: #0d6efd;
        color: white;
    }

    .btn-primary:hover {
        background-color: #0b5ed7;
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(13, 110, 253, 0.3);
    }

    .btn-warning {
        background-color: #ffc107;
        color: #212529;
    }

    .btn-warning:hover {
        background-color: #ffca2c;
        color: #212529;
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(255, 193, 7, 0.3);
    }

    .btn-info {
        background-color: #0dcaf0;
        color: #212529;
    }

    .btn-info:hover {
        background-color: #31d2f2;
        color: #212529;
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(13, 202, 240, 0.3);
    }

    /* Badge */
    .badge {
        padding: 0.4rem 0.75rem;
        font-weight: 500;
        border-radius: 0.25rem;
        font-size: 0.75rem;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        white-space: nowrap;
    }

    .bg-warning {
        background-color: #ffc107 !important;
    }

    .bg-success {
        background-color: #198754 !important;
        color: white !important;
    }

    .bg-danger {
        background-color: #dc3545 !important;
        color: white !important;
    }

    .bg-secondary {
        background-color: #6c757d !important;
        color: white !important;
    }

    /* Form controls */
    .form-control {
        padding: 0.625rem 0.875rem;
        border: 1px solid #ced4da;
        border-radius: 0.375rem;
        font-size: 0.875rem;
        transition: all 0.2s ease;
    }

    .form-control:focus {
        border-color: #198754;
        box-shadow: 0 0 0 0.2rem rgba(25, 135, 84, 0.15);
        outline: none;
    }

    .form-label {
        font-weight: 500;
        margin-bottom: 0.5rem;
        color: #495057;
        font-size: 0.875rem;
    }

    /* Scrollbar styling */
    .table-responsive::-webkit-scrollbar {
        height: 10px;
        width: 10px;
    }

    .table-responsive::-webkit-scrollbar-track {
        background: #f1f3f4;
        border-radius: 8px;
        margin: 2px;
    }

    .table-responsive::-webkit-scrollbar-thumb {
        background: linear-gradient(135deg, #198754, #157347);
        border-radius: 8px;
        border: 1px solid #f1f3f4;
    }

    .table-responsive::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(135deg, #157347, #0d4b2e);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .content-wrapper {
            padding: 1rem;
        }

        .filter-form {
            grid-template-columns: 1fr;
        }

        .page-header {
            flex-direction: column;
            align-items: stretch;
            padding: 1rem;
        }

        .table-responsive {
            max-height: 60vh;
        }

        .table {
            font-size: 0.813rem;
        }

        .table thead th,
        .table tbody td {
            padding: 0.5rem;
        }
    }

    @media (max-width: 576px) {
        .table-responsive {
            max-height: 55vh;
        }

        .table thead th,
        .table tbody td {
            padding: 0.375rem;
            font-size: 0.8rem;
        }
    }

    @media (min-width: 769px) and (max-width: 1024px) {
        .main-content {
            margin-left: 100px;
            width: calc(100% - 100px);
        }
    }

    @media (min-width: 1025px) {
        .main-content {
            margin-left: 180px;
            width: calc(100% - 180px);
        }
    }
</style>

<div class="content-wrapper">
    <div class="page-header">
        <div>
            <h2 class="page-title">Laporan Perkara</h2>
            <p class="text-muted mb-0">
                Selamat datang, <b><?= htmlspecialchars($this->session->userdata('username') ?? 'Guest'); ?></b>
                (<?= ucfirst($this->session->userdata('role') ?? 'User'); ?>)
            </p>
        </div>
        <div class="action-buttons">
            <a href="<?= site_url('laporan/laporan_data'); ?>" class="btn btn-primary">
                <i class="fas fa-chart-line"></i> Laporan Data
            </a>
            <a href="<?= site_url('laporan/rekap'); ?>" class="btn btn-info">
                <i class="fas fa-chart-bar"></i> Rekap Kasasi
            </a>
            <a href="<?= site_url('laporan/rekapitulasi'); ?>" class="btn btn-warning">
                <i class="fas fa-file-alt"></i> Rekapitulasi Data
            </a>
            <a href="<?= site_url('laporan/cetak_excel?' . $_SERVER['QUERY_STRING']); ?>" class="btn btn-success">
                <i class="fas fa-file-excel"></i> Ekspor Excel
            </a>
        </div>
    </div>

    <!-- Filter -->
    <div class="filter-card">
        <form method="GET" class="filter-form">
            <div>
                <label class="form-label">Bulan</label>
                <input type="month" name="bulan" class="form-control"
                    value="<?= htmlspecialchars($filters['bulan'] ?? ''); ?>">
            </div>
            <div>
                <label class="form-label">Jenis Perkara</label>
                <select name="perkara" class="form-control">
                    <option value="">Semua Jenis</option>
                    <option value="PIDANA" <?= ($filters['perkara'] ?? '') == 'PIDANA' ? 'selected' : '' ?>>PIDANA</option>
                    <option value="PERDATA" <?= ($filters['perkara'] ?? '') == 'PERDATA' ? 'selected' : '' ?>>PERDATA</option>
                    <option value="ANAK" <?= ($filters['perkara'] ?? '') == 'ANAK' ? 'selected' : '' ?>>ANAK</option>
                    <option value="TIPIKOR" <?= ($filters['perkara'] ?? '') == 'TIPIKOR' ? 'selected' : '' ?>>TIPIKOR</option>
                </select>
            </div>
            <div>
                <label class="form-label">Asal Pengadilan</label>
                <input type="text" name="asal_pengadilan" class="form-control"
                    value="<?= htmlspecialchars($filters['asal_pengadilan'] ?? ''); ?>">
            </div>
            <div>
                <label class="form-label">Klasifikasi</label>
                <input type="text" name="klasifikasi" class="form-control"
                    value="<?= htmlspecialchars($filters['klasifikasi'] ?? ''); ?>">
            </div>
            <div class="action-buttons">
                <button type="submit" class="btn btn-success"><i class="fas fa-filter"></i> Filter</button>
                <a href="<?= site_url('laporan'); ?>" class="btn btn-secondary"><i class="fas fa-redo"></i> Reset</a>
            </div>
        </form>
    </div>

    <!-- Tabel -->
    <div class="table-wrapper">
        <div class="table-responsive" id="tableResponsive" tabindex="0" role="region" aria-label="Tabel data perkara yang dapat di-scroll">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th class="number-column">No</th>
                        <th class="text-column">Pengadilan</th>
                        <th class="text-column">Jenis Perkara</th>
                        <th class="text-column">Perkara Tk1</th>
                        <th class="text-column">Klasifikasi</th>
                        <th class="date-column">Tgl Register</th>
                        <th class="text-column">Perkara Banding</th>
                        <th class="text-column">Lama</th>
                        <th class="text-column">Status Tk Banding</th>
                        <th class="date-column">Putusan Banding</th>
                        <th class="date-column">Kasasi</th>
                        <th class="date-column">Berkas Kasasi</th>
                        <th class="status-column">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($perkaras)): ?>
                        <tr>
                            <td colspan="13" class="text-center py-4">
                                <div class="d-flex flex-column align-items-center">
                                    <i class="fas fa-folder-open text-muted mb-2" style="font-size: 2rem;"></i>
                                    <p class="text-muted mb-0">Belum ada data perkara yang tersedia</p>
                                </div>
                            </td>
                        </tr>
                        <?php else: $no = 1;
                        foreach ($perkaras as $row): ?>
                            <tr>
                                <td class="number-column"><?= $no++ ?></td>
                                <td class="text-column" title="<?= htmlspecialchars($row->asal_pengadilan) ?>">
                                    <?= htmlspecialchars($row->asal_pengadilan) ?>
                                </td>
                                <td class="text-column" title="<?= htmlspecialchars($row->perkara ?? 'PIDANA') ?>">
                                    <?= htmlspecialchars($row->perkara ?? 'PIDANA') ?>
                                </td>
                                <td class="text-column" title="<?= htmlspecialchars($row->nomor_perkara_tk1) ?>">
                                    <?= htmlspecialchars($row->nomor_perkara_tk1) ?>
                                </td>
                                <td class="text-column" title="<?= htmlspecialchars($row->klasifikasi) ?>">
                                    <?= htmlspecialchars($row->klasifikasi) ?>
                                </td>
                                <td class="date-column">
                                    <?= $row->tgl_register_banding ? date("d-m-Y", strtotime($row->tgl_register_banding)) : '-' ?>
                                </td>
                                <td class="text-column" title="<?= htmlspecialchars($row->nomor_perkara_banding) ?>">
                                    <?= htmlspecialchars($row->nomor_perkara_banding) ?>
                                </td>
                                <td class="text-column"><?= htmlspecialchars($row->lama_proses) ?></td>
                                <td class="text-column"><?= htmlspecialchars($row->status_perkara_tk_banding) ?></td>
                                <td class="date-column">
                                    <?= $row->pemberitahuan_putusan_banding ? date("d-m-Y", strtotime($row->pemberitahuan_putusan_banding)) : '-' ?>
                                </td>
                                <td class="date-column">
                                    <?= $row->permohonan_kasasi ? date("d-m-Y", strtotime($row->permohonan_kasasi)) : '-' ?>
                                </td>
                                <td class="date-column">
                                    <?= $row->pengiriman_berkas_kasasi ? date("d-m-Y", strtotime($row->pengiriman_berkas_kasasi)) : '-' ?>
                                </td>
                                <td class="status-column">
                                    <?php
                                    switch ($row->status) {
                                        case "Proses":
                                            echo '<span class="badge bg-warning text-dark">Proses</span>';
                                            break;
                                        case "Selesai":
                                            echo '<span class="badge bg-success">Selesai</span>';
                                            break;
                                        case "Ditolak":
                                            echo '<span class="badge bg-danger">Ditolak</span>';
                                            break;
                                        default:
                                            echo '<span class="badge bg-secondary">-</span>';
                                    }
                                    ?>
                                </td>
                            </tr>
                    <?php endforeach;
                    endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tableWrapper = document.querySelector('.table-wrapper');
        const tableResponsive = document.querySelector('.table-responsive');
        const table = document.querySelector('.table');

        if (!tableWrapper || !tableResponsive || !table) return;

        function checkScrollable() {
            const isScrollableX = tableResponsive.scrollWidth > tableResponsive.clientWidth;
            const isScrollableY = tableResponsive.scrollHeight > tableResponsive.clientHeight;

            if (isScrollableX || isScrollableY) {
                tableResponsive.setAttribute('title', 'Gunakan scroll mouse atau tombol panah untuk navigasi');
            } else {
                tableResponsive.removeAttribute('title');
            }
        }

        tableResponsive.addEventListener('scroll', checkScrollable);
        window.addEventListener('resize', checkScrollable);
        checkScrollable();

        if ('ontouchstart' in window) {
            tableResponsive.style.webkitOverflowScrolling = 'touch';
        }

        tableResponsive.addEventListener('keydown', function(e) {
            const scrollAmount = 50;
            switch (e.key) {
                case 'ArrowLeft':
                    e.preventDefault();
                    tableResponsive.scrollLeft -= scrollAmount;
                    break;
                case 'ArrowRight':
                    e.preventDefault();
                    tableResponsive.scrollLeft += scrollAmount;
                    break;
                case 'ArrowUp':
                    e.preventDefault();
                    tableResponsive.scrollTop -= scrollAmount;
                    break;
                case 'ArrowDown':
                    e.preventDefault();
                    tableResponsive.scrollTop += scrollAmount;
                    break;
            }
        });

        if ('MutationObserver' in window) {
            const observer = new MutationObserver(checkScrollable);
            observer.observe(table, {
                childList: true,
                subtree: true
            });
        }
    });
</script>

<?php $this->load->view('navbar/footer'); ?>