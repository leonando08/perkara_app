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
        background: #fefeffff;
        padding: 0;
        transition: all 0.3s ease;
    }

    .content-wrapper {
        padding: 1.5rem;
        margin: 0;
        width: 100%;
        box-sizing: border-box;
    }

    /* Page Header */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1.5rem;
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
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12);
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .filter-form {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        align-items: end;
    }

    /* Alert */
    .alert {
        border: none;
        border-radius: 0.5rem;
        padding: 1rem 1.25rem;
        margin-bottom: 1.5rem;
        border-left: 4px solid;
    }

    .alert-warning {
        background-color: #fef3cd;
        border-left-color: #ffc107;
        color: #856404;
    }

    /* Table Container */
    .table-container {
        background: white;
        border-radius: 0.5rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12);
        overflow: hidden;
        margin-bottom: 1.5rem;
        max-width: 1200px;
        /* center and constrain width */
        margin-left: auto;
        margin-right: auto;
        padding-left: 0.75rem;
        padding-right: 0.75rem;
        box-sizing: border-box;
    }

    /* Table Responsive */
    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    /* Ensure the inner table is centered inside the responsive wrapper
       and allow horizontal scrolling when table is wider than container */
    .table-responsive .table {
        margin-left: auto;
        margin-right: auto;
        min-width: 800px;
        /* allow horizontal scroll for many columns */
    }

    /* Table Styling */
    .table {
        width: 100%;
        margin-bottom: 0;
        border-collapse: collapse;
        background-color: white;
        font-size: 0.875rem;
    }

    .table thead th {
        background-color: #198754;
        color: white;
        font-weight: 600;
        border: none;
        white-space: nowrap;
        text-align: center;
        vertical-align: middle;
    }

    .table tbody td {
        padding: 0.75rem 1rem;
        border-bottom: 1px solid #e9ecef;
        vertical-align: middle;
        border-top: none;
    }

    .table tbody tr:hover {
        background-color: rgba(0, 0, 0, 0.02);
    }

    /* Column Width */
    .table th:nth-child(1),
    .table td:nth-child(1) {
        width: 60px;
        text-align: center;
    }

    .table th:nth-child(2),
    .table td:nth-child(2) {
        width: 150px;
    }

    .table th:nth-child(3),
    .table td:nth-child(3) {
        width: 140px;
    }

    .table th:nth-child(4),
    .table td:nth-child(4) {
        width: 120px;
    }

    .table th:nth-child(5),
    .table td:nth-child(5) {
        width: 130px;
        text-align: center;
    }

    .table th:nth-child(6),
    .table td:nth-child(6) {
        width: 160px;
    }

    .table th:nth-child(7),
    .table td:nth-child(7) {
        width: 100px;
        text-align: center;
    }

    .table th:nth-child(8),
    .table td:nth-child(8) {
        width: 160px;
    }

    .table th:nth-child(9),
    .table td:nth-child(9) {
        width: 130px;
        text-align: center;
    }

    .table th:nth-child(10),
    .table td:nth-child(10) {
        width: 130px;
        text-align: center;
    }

    .table th:nth-child(11),
    .table td:nth-child(11) {
        width: 130px;
        text-align: center;
    }

    .table th:nth-child(12),
    .table td:nth-child(12) {
        width: 120px;
        text-align: center;
    }

    /* Text overflow */
    .table td {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 0;
    }

    .table td[title] {
        cursor: help;
    }

    /* Badge */
    .badge {
        padding: 0.3rem 0.4rem;
        font-weight: 500;
        border-radius: 0.2rem;
        font-size: 0.65rem;
        display: inline-flex;
        align-items: center;
        gap: 0.2rem;
        white-space: nowrap;
    }

    .bg-warning {
        background-color: #ffc107 !important;
    }

    .bg-success {
        background-color: #198754 !important;
    }

    .bg-danger {
        background-color: #dc3545 !important;
    }

    .bg-secondary {
        background-color: #6c757d !important;
    }

    .text-dark {
        color: #212529 !important;
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
        font-weight: 500;
        text-decoration: none;
        border: 1px solid;
        transition: all 0.2s;
    }

    .btn-success {
        background-color: #198754;
        border-color: #198754;
        color: white;
    }

    .btn-success:hover {
        background-color: #157347;
        border-color: #157347;
    }

    .btn-secondary {
        background-color: #6c757d;
        border-color: #6c757d;
        color: white;
    }

    .btn-secondary:hover {
        background-color: #5c636a;
        border-color: #5c636a;
    }

    .btn-primary {
        background-color: #0d6efd;
        border-color: #0d6efd;
        color: white;
    }

    .btn-primary:hover {
        background-color: #0b5ed7;
        border-color: #0b5ed7;
    }

    /* Empty state */
    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
        color: #6c757d;
    }

    .empty-state i {
        font-size: 3rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }

    /* Table scroll hint */
    .table-scroll-hint {
        padding: 0.75rem;
        background-color: #f8f9fa;
        border-top: 1px solid #e9ecef;
        color: #6c757d;
        font-size: 0.875rem;
        text-align: center;
    }

    /* Custom scrollbar */
    .table-responsive::-webkit-scrollbar {
        height: 10px;
    }

    .table-responsive::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }

    .table-responsive::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 4px;
    }

    .table-responsive::-webkit-scrollbar-thumb:hover {
        background: #666;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .main-content {
            margin-left: 0;
            width: 100%;
        }

        .content-wrapper {
            padding: 1rem;
        }

        .filter-form {
            grid-template-columns: 1fr;
        }

        .page-header {
            flex-direction: column;
            align-items: stretch;
        }

        .table {
            font-size: 0.8rem;
            min-width: 0;
            /* allow table to shrink on small screens */
        }

        .table thead th,
        .table tbody td {
            padding: 0.5rem;
        }

        .btn {
            font-size: 0.875rem;
        }
    }

    /* Make sure table container uses full width on very small screens */
    @media (max-width: 576px) {
        .table-container {
            max-width: 100%;
            padding-left: 0.5rem;
            padding-right: 0.5rem;
        }

        .table-responsive .table {
            min-width: 700px;
        }
    }

    @media (min-width: 769px) and (max-width: 1024px) {
        .main-content {
            margin-left: 100px;
            width: calc(100% - 240px);
        }
    }

    @media (min-width: 1200px) {
        .main-content {
            margin-left: 180px;
            width: calc(100% - 180px);
        }
    }

    @media (max-width: 576px) {

        .table thead th,
        .table tbody td {
            padding: 0.4rem;
            font-size: 0.75rem;
        }

        .badge {
            font-size: 0.7rem;
            padding: 0.3rem 0.5rem;
        }
    }

    /* Print Styles */
    @media print {
        body {
            background: white !important;
            margin: 0 !important;
            padding: 2cm !important;
            font-size: 11pt !important;
        }

        .main-content {
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;
            background: white !important;
        }

        .content-wrapper {
            padding: 0 !important;
            margin: 0 !important;
        }

        /* Hide non-essential elements */
        .sidebar,
        .filter-card,
        .btn-primary,
        .table-scroll-hint,
        .action-buttons,
        footer {
            display: none !important;
        }

        /* Page header print styling */
        .page-header {
            padding: 0 0 1rem 0 !important;
            margin-bottom: 1.5rem !important;
            background: none !important;
            box-shadow: none !important;
            border-bottom: 2px solid #000 !important;
            display: block !important;
        }

        .page-title {
            font-size: 14pt !important;
            margin-bottom: 0.5rem !important;
            text-align: center !important;
        }

        .text-muted {
            display: none !important;
        }

        /* Table print styling */
        .table-container {
            margin: 0 !important;
            padding: 0 !important;
            box-shadow: none !important;
            max-width: none !important;
            overflow: visible !important;
        }

        .table-responsive {
            overflow: visible !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        .table {
            width: 100% !important;
            margin: 0 !important;
            border-collapse: collapse !important;
            font-size: 9pt !important;
        }

        .table thead th {
            background-color: white !important;
            color: black !important;
            border: 1px solid #000 !important;
            font-weight: bold !important;
            padding: 8pt 4pt !important;
            text-align: center !important;
            vertical-align: middle !important;
        }

        .table tbody td {
            border: 1px solid #000 !important;
            padding: 6pt 4pt !important;
            text-align: left !important;
        }

        .table tbody tr:nth-child(even) {
            background-color: #f8f9fa !important;
        }

        /* Force table headers to repeat on each page */
        thead {
            display: table-header-group !important;
        }

        tfoot {
            display: table-footer-group !important;
        }

        tr {
            page-break-inside: avoid !important;
        }

        /* Status badge print styling */
        .badge {
            border: 1px solid #000 !important;
            padding: 2pt 4pt !important;
            font-size: 8pt !important;
            background: none !important;
            color: black !important;
            display: inline-block !important;
        }

        .badge i {
            display: none !important;
        }

        /* Ensure text wrapping and visibility */
        .table td {
            white-space: normal !important;
            overflow: visible !important;
            text-overflow: clip !important;
            max-width: none !important;
        }

        /* Page settings */
        @page {
            size: landscape;
            margin: 1.5cm !important;
        }

        @page :first {
            margin-top: 2cm !important;
        }

        /* Remove hover effects */
        * {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        /* Add page number */
        .table-container::after {
            content: "Halaman " counter(page) !important;
            display: block !important;
            text-align: right !important;
            font-size: 9pt !important;
            margin-top: 1cm !important;
        }
    }
</style>



<div class="content-wrapper">
    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h2 class="page-title">Laporan Perkara</h2>
            <p class="text-muted mb-0">
                Selamat datang, <b><?= htmlspecialchars($this->session->userdata('username') ?? 'Guest'); ?></b> (<?= ucfirst($this->session->userdata('role') ?? 'User'); ?>)
            </p>
        </div>
        <div class="action-buttons">
            <a href="<?= site_url('laporan/cetak_laporan?' . $_SERVER['QUERY_STRING']); ?>" class="btn btn-primary">
                <i class="fas fa-print"></i> Cetak PDF
            </a>
            <a href="<?= site_url('laporan/cetak_excel?' . $_SERVER['QUERY_STRING']); ?>" class="btn btn-success">
                <i class="fas fa-file-excel"></i> Ekspor Excel
            </a>
        </div>
    </div>

    <!-- Alert untuk notifikasi -->
    <?php if (!empty($perkaras)): ?>
        <?php
        $kasasi_lewat = 0;
        foreach ($perkaras as $row) {
            if (!empty($row->permohonan_kasasi)) {
                $tanggal_kasasi = strtotime($row->permohonan_kasasi);
                $batas_waktu = strtotime('+30 days', $tanggal_kasasi);
                if (time() > $batas_waktu) {
                    $kasasi_lewat++;
                }
            }
        }
        ?>
        <?php if ($kasasi_lewat > 0): ?>
            <div class="alert alert-warning">
                <i class="fas fa-exclamation-triangle me-2"></i>
                Ada <?= $kasasi_lewat ?> perkara yang permohonan kasasinya sudah lewat batas waktu 30 hari.
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <!-- Form Filter -->
    <div class="filter-card">
        <form method="GET" class="filter-form">
            <div>
                <label for="bulan" class="form-label">Pilih Bulan</label>
                <input type="month" id="bulan" name="bulan" class="form-control"
                    value="<?= htmlspecialchars($filters['bulan'] ?? ''); ?>">
            </div>

            <div>
                <label for="asal_pengadilan" class="form-label">Asal Pengadilan</label>
                <input type="text" id="asal_pengadilan" name="asal_pengadilan" class="form-control"
                    placeholder="Masukkan asal pengadilan..."
                    value="<?= htmlspecialchars($filters['asal_pengadilan'] ?? ''); ?>">
            </div>

            <div>
                <label for="klasifikasi" class="form-label">Klasifikasi</label>
                <input type="text" id="klasifikasi" name="klasifikasi" class="form-control"
                    placeholder="Masukkan klasifikasi..."
                    value="<?= htmlspecialchars($filters['klasifikasi'] ?? ''); ?>">
            </div>

            <div class="action-buttons">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-filter"></i> Filter
                </button>
                <a href="<?= site_url('laporan'); ?>" class="btn btn-secondary">
                    <i class="fas fa-redo"></i> Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Tabel Laporan -->
    <div class="table-container">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Asal Pengadilan</th>
                        <th>Nomor Perkara Tk1</th>
                        <th>Klasifikasi</th>
                        <th>Tgl Register Banding</th>
                        <th>Nomor Perkara Banding</th>
                        <th>Lama Proses</th>
                        <th>Status Perkara Tk Banding</th>
                        <th>Pemberitahuan Putusan Banding</th>
                        <th>Permohonan Kasasi</th>
                        <th>Pengiriman Berkas Kasasi</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($perkaras)) { ?>
                        <tr>
                            <td colspan="12">
                                <div class="empty-state">
                                    <i class="fas fa-folder-open"></i>
                                    <div>Tidak ada data perkara yang ditemukan.</div>
                                </div>
                            </td>
                        </tr>
                        <?php } else {
                        foreach ($perkaras as $row) { ?>
                            <tr>
                                <td><?= htmlspecialchars($row->id); ?></td>
                                <td title="<?= htmlspecialchars($row->asal_pengadilan); ?>">
                                    <?= htmlspecialchars(strlen($row->asal_pengadilan) > 20 ? substr($row->asal_pengadilan, 0, 20) . '...' : $row->asal_pengadilan); ?>
                                </td>
                                <td title="<?= htmlspecialchars($row->nomor_perkara_tk1); ?>">
                                    <?= htmlspecialchars(strlen($row->nomor_perkara_tk1) > 18 ? substr($row->nomor_perkara_tk1, 0, 18) . '...' : $row->nomor_perkara_tk1); ?>
                                </td>
                                <td title="<?= htmlspecialchars($row->klasifikasi); ?>">
                                    <?= htmlspecialchars(strlen($row->klasifikasi) > 15 ? substr($row->klasifikasi, 0, 15) . '...' : $row->klasifikasi); ?>
                                </td>
                                <td>
                                    <?= !empty($row->tgl_register_banding)
                                        ? date("d-m-Y", strtotime($row->tgl_register_banding))
                                        : '<span class="text-muted">-</span>'; ?>
                                </td>
                                <td title="<?= htmlspecialchars($row->nomor_perkara_banding); ?>">
                                    <?= htmlspecialchars(strlen($row->nomor_perkara_banding) > 20 ? substr($row->nomor_perkara_banding, 0, 20) . '...' : $row->nomor_perkara_banding); ?>
                                </td>
                                <td><?= htmlspecialchars($row->lama_proses); ?></td>
                                <td title="<?= htmlspecialchars($row->status_perkara_tk_banding); ?>">
                                    <?= htmlspecialchars(strlen($row->status_perkara_tk_banding) > 20 ? substr($row->status_perkara_tk_banding, 0, 20) . '...' : $row->status_perkara_tk_banding); ?>
                                </td>
                                <td>
                                    <?= !empty($row->pemberitahuan_putusan_banding)
                                        ? date("d-m-Y", strtotime($row->pemberitahuan_putusan_banding))
                                        : '<span class="text-muted">-</span>'; ?>
                                </td>
                                <td>
                                    <?= !empty($row->permohonan_kasasi)
                                        ? date("d-m-Y", strtotime($row->permohonan_kasasi))
                                        : '<span class="text-muted">-</span>'; ?>
                                </td>
                                <td>
                                    <?= !empty($row->pengiriman_berkas_kasasi)
                                        ? date("d-m-Y", strtotime($row->pengiriman_berkas_kasasi))
                                        : '<span class="text-muted">-</span>'; ?>
                                </td>
                                <td>
                                    <?php
                                    if ($row->status == "Proses") {
                                        $statusClass = "bg-warning text-dark";
                                        $statusIcon = "fa-clock";
                                    } elseif ($row->status == "Selesai") {
                                        $statusClass = "bg-success";
                                        $statusIcon = "fa-check";
                                    } elseif ($row->status == "Ditolak") {
                                        $statusClass = "bg-danger";
                                        $statusIcon = "fa-times";
                                    } else {
                                        $statusClass = "bg-secondary";
                                        $statusIcon = "fa-minus";
                                    }
                                    ?>
                                    <span class="badge <?= $statusClass ?>">
                                        <i class="fas <?= $statusIcon ?>"></i>
                                        <?= htmlspecialchars($row->status ?: '-') ?>
                                    </span>
                                </td>
                            </tr>
                    <?php }
                    } ?>
                </tbody>
            </table>
        </div>
        <?php if (!empty($perkaras)) { ?>
            <div class="table-scroll-hint">
                <small>
                    <i class="fas fa-arrows-alt-h me-1"></i>
                    Geser tabel untuk melihat semua kolom data. Hover pada teks terpotong untuk melihat data lengkap.
                </small>
            </div>
        <?php } ?>
    </div>
</div>

<?php $this->load->view('navbar/footer'); ?>