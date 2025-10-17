<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<?php $this->load->view('navbar/header'); ?>

<style>
    /* Force refresh CSS - Version 1.0 - LAPORAN PUTUS TEPAT WAKTU - <?= time(); ?> */

    /* Layout now handled by global-layout.css - removed duplicate styles */

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
    }

    .filter-card {
        background: white;
        border-radius: 0.5rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .filter-form {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 0.75rem;
        align-items: end;
    }

    .table-wrapper {
        position: relative;
        margin-bottom: 1rem;
        background: white;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12);
        border-radius: 0.5rem;
        overflow: hidden;
        width: 100%;
    }

    .table-responsive {
        overflow-x: auto;
        overflow-y: auto;
        margin: 0;
        padding: 0;
        width: 100%;
        max-height: 70vh;
        position: relative;
        scroll-behavior: smooth;
        -webkit-overflow-scrolling: touch;
        border: 1px solid #dee2e6;
        border-radius: 0.375rem;
    }

    .table {
        width: 100%;
        margin-bottom: 0;
        background-color: white;
        border-collapse: collapse;
        font-size: 0.875rem;
        table-layout: auto;
        min-width: 1200px;
    }

    .table thead {
        background-color: #28a745;
        position: sticky;
        top: 0;
        z-index: 10;
    }

    .table thead th {
        background-color: #28a745;
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
        background-color: rgba(40, 167, 69, 0.05);
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

    .table .parent-column {
        min-width: 120px;
        max-width: 150px;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .table .date-column {
        min-width: 150px;
        max-width: 150px;
    }

    .table .status-column {
        min-width: 100px;
        max-width: 100px;
        text-align: center;
    }

    .table .lama-column {
        min-width: 120px;
        max-width: 120px;
        text-align: center;
    }

    .table .putusan-column {
        min-width: 180px;
        max-width: 180px;
        text-align: center;
    }

    .table .action-column {
        min-width: 100px;
        max-width: 100px;
        text-align: center;
    }

    /* Success badge for tepat waktu */
    .badge-tepat-waktu {
        background: linear-gradient(135deg, #28a745, #20c997);
        color: white;
        padding: 0.4rem 0.75rem;
        font-weight: 500;
        border-radius: 0.25rem;
        font-size: 0.75rem;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        box-shadow: 0 2px 4px rgba(40, 167, 69, 0.3);
    }

    /* Warning badge for tidak tepat waktu */
    .badge-tidak-tepat-waktu {
        background: linear-gradient(135deg, #dc3545, #c82333);
        color: white;
        padding: 0.4rem 0.75rem;
        font-weight: 500;
        border-radius: 0.25rem;
        font-size: 0.75rem;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        box-shadow: 0 2px 4px rgba(220, 53, 69, 0.3);
    }

    /* Row styling for different status */
    .table-success {
        background-color: rgba(40, 167, 69, 0.05) !important;
    }

    .table-warning {
        background-color: rgba(220, 53, 69, 0.05) !important;
    }

    .table tbody tr.table-success:hover {
        background-color: rgba(40, 167, 69, 0.1) !important;
    }

    .table tbody tr.table-warning:hover {
        background-color: rgba(220, 53, 69, 0.1) !important;
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
        background-color: #28a745;
        color: white;
    }

    .btn-success:hover {
        background-color: #218838;
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(40, 167, 69, 0.3);
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
        background-color: #007bff;
        color: white;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0, 123, 255, 0.3);
    }

    /* Badge Styles */
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

    .bg-success {
        background-color: #28a745 !important;
        color: white !important;
    }

    .bg-warning {
        background-color: #ffc107 !important;
        color: #212529 !important;
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
        border-color: #28a745;
        box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.15);
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
        background: linear-gradient(135deg, #28a745, #20c997);
        border-radius: 8px;
        border: 1px solid #f1f3f4;
    }

    .table-responsive::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(135deg, #218838, #1ba085);
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

    /* Statistics cards */
    .stats-card {
        background: linear-gradient(135deg, #28a745, #20c997);
        color: white;
        padding: 1.5rem;
        border-radius: 0.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 4px 6px rgba(40, 167, 69, 0.2);
    }

    .stats-title {
        font-size: 0.875rem;
        opacity: 0.9;
        margin-bottom: 0.5rem;
    }

    .stats-number {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
    }

    .stats-subtitle {
        font-size: 0.75rem;
        opacity: 0.8;
    }
</style>

<div class="main-content">
    <div class="content-wrapper">
        <!-- Loading overlay -->
        <div id="loadingOverlay" class="d-none">
            <div class="spinner-border text-success" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>

        <!-- Page Header -->
        <div class="page-header">
            <div>
                <h1 class="page-title">
                    <i class="fas fa-clock me-2"></i>
                    Laporan Waktu Penyelesaian Perkara
                </h1>
                <p class="text-muted mb-0">
                    Laporan lengkap waktu penyelesaian perkara (tepat waktu dan tidak tepat waktu)
                    <br><small>
                        <span class="badge bg-info me-1">ANAK: < 14 hari</span>
                                <span class="badge bg-success me-1">LAINNYA: < 90 hari</span>
                                        <span class="badge bg-danger">Tidak Tepat Waktu: ≥ Batas</span>
                    </small>
                </p>
            </div>
            <div class="action-buttons">
                <button type="button" class="btn btn-success" onclick="exportExcel()">
                    <i class="fas fa-file-excel me-1"></i> Export Excel
                </button>
                <a href="<?= site_url('laporan') ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="stats-card">
                    <div class="stats-title">Total Tepat Waktu</div>
                    <div class="stats-number"><?= isset($total_tepat_waktu) ? $total_tepat_waktu : 0 ?></div>
                    <div class="stats-subtitle">
                        < 90 hari</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card">
                        <div class="stats-title">Pidana</div>
                        <div class="stats-number"><?= isset($pidana_tepat_waktu) ? $pidana_tepat_waktu : 0 ?></div>
                        <div class="stats-subtitle">perkara</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card">
                        <div class="stats-title">Perdata</div>
                        <div class="stats-number"><?= isset($perdata_tepat_waktu) ? $perdata_tepat_waktu : 0 ?></div>
                        <div class="stats-subtitle">perkara</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card">
                        <div class="stats-title">Anak & Tipikor</div>
                        <div class="stats-number"><?= isset($anak_tipikor_tepat_waktu) ? $anak_tipikor_tepat_waktu : 0 ?></div>
                        <div class="stats-subtitle">perkara</div>
                    </div>
                </div>
            </div>

            <!-- Filter Card -->
            <div class="filter-card">
                <h5 class="mb-3">
                    <i class="fas fa-filter me-2"></i>
                    Filter Data
                </h5>
                <form method="get" action="<?= current_url() ?>">
                    <div class="filter-form">
                        <div>
                            <label class="form-label">Bulan</label>
                            <select name="bulan" class="form-control">
                                <option value="">Semua Bulan</option>
                                <option value="01" <?= (isset($_GET['bulan']) && $_GET['bulan'] == '01') ? 'selected' : '' ?>>Januari</option>
                                <option value="02" <?= (isset($_GET['bulan']) && $_GET['bulan'] == '02') ? 'selected' : '' ?>>Februari</option>
                                <option value="03" <?= (isset($_GET['bulan']) && $_GET['bulan'] == '03') ? 'selected' : '' ?>>Maret</option>
                                <option value="04" <?= (isset($_GET['bulan']) && $_GET['bulan'] == '04') ? 'selected' : '' ?>>April</option>
                                <option value="05" <?= (isset($_GET['bulan']) && $_GET['bulan'] == '05') ? 'selected' : '' ?>>Mei</option>
                                <option value="06" <?= (isset($_GET['bulan']) && $_GET['bulan'] == '06') ? 'selected' : '' ?>>Juni</option>
                                <option value="07" <?= (isset($_GET['bulan']) && $_GET['bulan'] == '07') ? 'selected' : '' ?>>Juli</option>
                                <option value="08" <?= (isset($_GET['bulan']) && $_GET['bulan'] == '08') ? 'selected' : '' ?>>Agustus</option>
                                <option value="09" <?= (isset($_GET['bulan']) && $_GET['bulan'] == '09') ? 'selected' : '' ?>>September</option>
                                <option value="10" <?= (isset($_GET['bulan']) && $_GET['bulan'] == '10') ? 'selected' : '' ?>>Oktober</option>
                                <option value="11" <?= (isset($_GET['bulan']) && $_GET['bulan'] == '11') ? 'selected' : '' ?>>November</option>
                                <option value="12" <?= (isset($_GET['bulan']) && $_GET['bulan'] == '12') ? 'selected' : '' ?>>Desember</option>
                            </select>
                        </div>
                        <div>
                            <label class="form-label">Tahun</label>
                            <select name="tahun" class="form-control">
                                <option value="">Semua Tahun</option>
                                <option value="2023" <?= (isset($_GET['tahun']) && $_GET['tahun'] == '2023') ? 'selected' : '' ?>>2023</option>
                                <option value="2024" <?= (isset($_GET['tahun']) && $_GET['tahun'] == '2024') ? 'selected' : '' ?>>2024</option>
                                <option value="2025" <?= (isset($_GET['tahun']) && $_GET['tahun'] == '2025') ? 'selected' : '' ?>>2025</option>
                            </select>
                        </div>
                        <div>
                            <label class="form-label">Jenis Perkara</label>
                            <select name="perkara" class="form-control">
                                <option value="">Semua Jenis</option>
                                <option value="PIDANA" <?= (isset($_GET['perkara']) && $_GET['perkara'] == 'PIDANA') ? 'selected' : '' ?>>PIDANA</option>
                                <option value="PERDATA" <?= (isset($_GET['perkara']) && $_GET['perkara'] == 'PERDATA') ? 'selected' : '' ?>>PERDATA</option>
                                <option value="ANAK" <?= (isset($_GET['perkara']) && $_GET['perkara'] == 'ANAK') ? 'selected' : '' ?>>ANAK</option>
                                <option value="TIPIKOR" <?= (isset($_GET['perkara']) && $_GET['perkara'] == 'TIPIKOR') ? 'selected' : '' ?>>TIPIKOR</option>
                            </select>
                        </div>
                        <div>
                            <label class="form-label">Asal Pengadilan</label>
                            <input type="text" name="pengadilan" class="form-control"
                                value="<?= htmlspecialchars($_GET['pengadilan'] ?? '') ?>"
                                placeholder="Cari pengadilan...">
                        </div>
                        <div>
                            <label class="form-label">Status Waktu</label>
                            <select name="status_waktu" class="form-control">
                                <option value="">Semua Status</option>
                                <option value="tepat_waktu" <?= (isset($_GET['status_waktu']) && $_GET['status_waktu'] == 'tepat_waktu') ? 'selected' : '' ?>>
                                    ✅ Tepat Waktu (ANAK: < 14 hari, Lainnya: < 90 hari)
                                        </option>
                                <option value="tidak_tepat_waktu" <?= (isset($_GET['status_waktu']) && $_GET['status_waktu'] == 'tidak_tepat_waktu') ? 'selected' : '' ?>>
                                    ⚠️ Tidak Tepat Waktu (≥ Batas masing-masing)
                                </option>
                            </select>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success flex-grow-1">
                                <i class="fas fa-search me-1"></i> Filter
                            </button>
                            <a href="<?= current_url() ?>" class="btn btn-secondary flex-grow-1">
                                <i class="fas fa-redo me-1"></i> Reset
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Table -->
            <!-- Table -->
            <div class="table-wrapper">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover m-0">
                        <thead>
                            <tr>
                                <th class="number-column">No</th>
                                <th class="text-column">Pengadilan</th>
                                <th class="parent-column">Jenis Perkara</th>
                                <th class="text-column">Perkara Tk1</th>
                                <th class="text-column">Klasifikasi</th>
                                <th class="date-column">Tgl Register</th>
                                <th class="text-column">Perkara Banding</th>
                                <th class="lama-column">Lama Proses</th>
                                <th class="text-column">Status Tk Banding</th>
                                <th class="putusan-column">Putusan Banding</th>
                                <th class="date-column">Kasasi</th>
                                <th class="date-column">Berkas Kasasi</th>
                                <th class="status-column">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($perkaras)): ?>
                                <tr>
                                    <td colspan="14" class="text-center py-4">
                                        <div class="d-flex flex-column align-items-center">
                                            <i class="fas fa-clock text-muted mb-2" style="font-size: 2rem;"></i>
                                            <p class="text-muted mb-0">Belum ada data perkara yang tersedia</p>
                                            <small class="text-muted">
                                                <span class="badge bg-info me-2">ANAK: < 14 hari</span>
                                                        <span class="badge bg-success me-2">LAINNYA: < 90 hari</span>
                                                                <span class="badge bg-danger">Tidak Tepat Waktu: ≥ Batas</span>
                                            </small>
                                        </div>
                                    </td>
                                </tr>
                                <?php else:
                                $no = 1;
                                foreach ($perkaras as $row):
                                    // Parsing lama proses untuk mendapatkan angka hari
                                    $lama_proses_hari = 0;
                                    if (!empty($row->lama_proses)) {
                                        // Coba beberapa pattern untuk ekstrak angka hari
                                        $lama_proses_text = trim($row->lama_proses);

                                        // Pattern 1: Cari angka diikuti "hari" 
                                        if (preg_match('/(\d+)\s*hari/i', $lama_proses_text, $matches)) {
                                            $lama_proses_hari = intval($matches[1]);
                                        }
                                        // Pattern 2: Cari angka saja jika tidak ada "hari"
                                        elseif (preg_match('/(\d+)/', $lama_proses_text, $matches)) {
                                            $lama_proses_hari = intval($matches[1]);
                                        }
                                        // Pattern 3: Jika berupa angka langsung
                                        elseif (is_numeric($lama_proses_text)) {
                                            $lama_proses_hari = intval($lama_proses_text);
                                        }
                                    }

                                    // Tentukan batas waktu berdasarkan jenis perkara
                                    $batas_hari = ($row->perkara == 'ANAK') ? 14 : 90;

                                    // Tentukan status waktu
                                    $is_tepat_waktu = $lama_proses_hari < $batas_hari;
                                    $status_waktu_filter = $_GET['status_waktu'] ?? '';

                                    // Logika filter berdasarkan status waktu
                                    $show_row = true; // Default tampilkan semua data

                                    if ($status_waktu_filter != '') {
                                        // Jika ada filter status waktu, periksa kondisi
                                        if ($lama_proses_hari > 0) {
                                            if ($status_waktu_filter == 'tepat_waktu' && !$is_tepat_waktu) {
                                                $show_row = false;
                                            } elseif ($status_waktu_filter == 'tidak_tepat_waktu' && $is_tepat_waktu) {
                                                $show_row = false;
                                            }
                                        } else {
                                            // Untuk data tanpa lama proses, tampilkan hanya saat filter kosong
                                            if ($status_waktu_filter != '') {
                                                $show_row = false;
                                            }
                                        }
                                    }

                                    if ($show_row): ?>
                                        <tr class="<?= $lama_proses_hari > 0 ? ($is_tepat_waktu ? 'table-success' : 'table-warning') : '' ?>">
                                            <td class="number-column"><?= $no++ ?></td>
                                            <td class="text-column" title="<?= htmlspecialchars($row->asal_pengadilan) ?>">
                                                <?= htmlspecialchars($row->asal_pengadilan) ?>
                                            </td>
                                            <td class="parent-column" title="<?= htmlspecialchars($row->perkara) ?>">
                                                <span class="badge bg-<?= $row->perkara == 'PIDANA' ? 'danger' : ($row->perkara == 'PERDATA' ? 'primary' : ($row->perkara == 'ANAK' ? 'warning' : 'info')) ?>">
                                                    <?= htmlspecialchars($row->perkara) ?>
                                                </span>
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
                                            <td class="lama-column">
                                                <?php if ($lama_proses_hari > 0): ?>
                                                    <?php if ($is_tepat_waktu): ?>
                                                        <span class="badge-tepat-waktu">
                                                            <i class="fas fa-check-circle me-1"></i>
                                                            <?= htmlspecialchars($row->lama_proses) ?>
                                                        </span>
                                                    <?php else: ?>
                                                        <span class="badge-tidak-tepat-waktu">
                                                            <i class="fas fa-exclamation-triangle me-1"></i>
                                                            <?= htmlspecialchars($row->lama_proses) ?>
                                                        </span>
                                                    <?php endif; ?>
                                                <?php else: ?>
                                                    <span class="text-muted">
                                                        <i class="fas fa-clock me-1"></i>
                                                        <?= !empty($row->lama_proses) ? htmlspecialchars($row->lama_proses) : 'Belum ada data' ?>
                                                    </span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-column"><?= str_replace('Minutas tanggal', 'Putusan Banding PT tanggal', htmlspecialchars($row->status_perkara_tk_banding)) ?></td>
                                            <td class="putusan-column">
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
                                                    default:
                                                        echo '<span class="badge bg-secondary">-</span>';
                                                }
                                                ?>
                                            </td>
                                        </tr>
                            <?php endif;
                                endforeach;
                            endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Export Excel function
                window.exportExcel = function() {
                    // Show loading
                    const loadingOverlay = document.getElementById('loadingOverlay');
                    if (loadingOverlay) {
                        loadingOverlay.classList.remove('d-none');
                    }

                    // Get current filter parameters
                    const urlParams = new URLSearchParams(window.location.search);
                    const exportUrl = '<?= site_url("laporan/export_excel_tepat_waktu") ?>';

                    // Create form data with current filters
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = exportUrl;
                    form.style.display = 'none';

                    // Add filter parameters
                    ['bulan', 'tahun', 'perkara', 'pengadilan', 'status_waktu'].forEach(param => {
                        if (urlParams.has(param)) {
                            const input = document.createElement('input');
                            input.type = 'hidden';
                            input.name = param;
                            input.value = urlParams.get(param);
                            form.appendChild(input);
                        }
                    });

                    document.body.appendChild(form);
                    form.submit();
                    document.body.removeChild(form);

                    // Hide loading after delay
                    setTimeout(() => {
                        if (loadingOverlay) {
                            loadingOverlay.classList.add('d-none');
                        }
                    }, 2000);
                };

                // Loading overlay handling
                const loadingOverlay = document.getElementById('loadingOverlay');
                const form = document.querySelector('form');

                if (form) {
                    form.addEventListener('submit', function() {
                        loadingOverlay.classList.remove('d-none');
                    });
                }

                // Table responsive handling
                const tableWrapper = document.querySelector('.table-wrapper');
                const tableContainer = document.querySelector('.table-responsive');

                if (tableContainer) {
                    // Check scrollable
                    function checkScrollable() {
                        const isScrollableX = tableContainer.scrollWidth > tableContainer.clientWidth;
                        const isScrollableY = tableContainer.scrollHeight > tableContainer.clientHeight;

                        if (isScrollableX || isScrollableY) {
                            tableContainer.setAttribute('title', 'Gunakan scroll mouse atau tombol panah untuk navigasi');
                        } else {
                            tableContainer.removeAttribute('title');
                        }
                    }

                    // Event listeners
                    window.addEventListener('resize', checkScrollable);
                    checkScrollable();

                    // Smooth scrolling untuk mobile
                    if ('ontouchstart' in window) {
                        tableContainer.style.webkitOverflowScrolling = 'touch';
                    }

                    // Keyboard navigation
                    tableContainer.addEventListener('keydown', function(e) {
                        const scrollAmount = 50;

                        switch (e.key) {
                            case 'ArrowLeft':
                                e.preventDefault();
                                tableContainer.scrollLeft -= scrollAmount;
                                break;
                            case 'ArrowRight':
                                e.preventDefault();
                                tableContainer.scrollLeft += scrollAmount;
                                break;
                            case 'ArrowUp':
                                e.preventDefault();
                                tableContainer.scrollTop -= scrollAmount;
                                break;
                            case 'ArrowDown':
                                e.preventDefault();
                                tableContainer.scrollTop += scrollAmount;
                                break;
                        }
                    });
                }

                // Filter auto submit on change
                const filterSelects = document.querySelectorAll('select[name="bulan"], select[name="tahun"], select[name="perkara"]');
                filterSelects.forEach(select => {
                    select.addEventListener('change', function() {
                        // Auto submit form when filter changes
                        // Uncomment jika ingin auto submit
                        // this.form.submit();
                    });
                });
            });
        </script>

    </div>
</div>

<?php $this->load->view('navbar/footer'); ?>