<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<?php $this->load->view('navbar/header'); ?>

<style>
    /* Force refresh CSS - Version 7.0 - FIXED LAYOUT */

    /* Print styles */
    @media print {
        body * {
            visibility: hidden;
        }

        .print-area,
        .print-area * {
            visibility: visible;
        }

        .print-area {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }

        .no-print {
            display: none !important;
        }

        .page-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .filter-info {
            text-align: center;
            margin-bottom: 15px;
            font-size: 12pt;
        }

        table {
            font-size: 10pt;
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 4px;
            text-align: center;
        }

        th {
            background-color: #f0f0f0 !important;
            font-weight: bold;
        }

        .table-responsive {
            overflow: visible !important;
        }
    }

    /* FIX: Main Content Layout */
    .main-content {
        margin-left: 0;
        padding: 1.5rem;
        width: 100%;
        min-height: 100vh;
        background-color: #f5f5f5;
    }

    .content-wrapper {
        max-width: 100%;
        margin: 0;
        padding: 0;
    }

    /* Page Header */
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
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 0.75rem;
        align-items: end;
    }

    /* Table Wrapper */
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

    /* Table Styles */
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
        background-color: #198754;
        position: sticky;
        top: 0;
        z-index: 10;
    }

    .table thead th {
        background-color: #198754;
        color: white;
        font-weight: 600;
        padding: 0.75rem 0.5rem;
        white-space: nowrap;
        vertical-align: middle;
        border: 1px solid rgba(255, 255, 255, 0.1);
        position: sticky;
        top: 0;
        z-index: 10;
        text-align: center;
        font-size: 0.8rem;
    }

    .table tbody td {
        padding: 0.5rem 0.25rem;
        vertical-align: middle;
        border: 1px solid #dee2e6;
        background-color: white;
        text-align: center;
        font-size: 0.75rem;
        line-height: 1.2;
        word-wrap: break-word;
        overflow-wrap: break-word;
    }

    .table tbody tr:hover td {
        background-color: rgba(25, 135, 84, 0.05);
        transition: background-color 0.2s ease;
    }

    .table tbody tr:nth-child(even) td {
        background-color: #f8f9fa;
    }

    /* Scrollbar Styling */
    .table-responsive::-webkit-scrollbar {
        height: 12px;
        width: 12px;
    }

    .table-responsive::-webkit-scrollbar-track {
        background: #f1f3f4;
        border-radius: 6px;
        margin: 2px;
        border: 1px solid #e0e0e0;
    }

    .table-responsive::-webkit-scrollbar-thumb {
        background: #198754;
        border-radius: 6px;
        border: 2px solid #f1f3f4;
        min-height: 40px;
        min-width: 40px;
    }

    .table-responsive::-webkit-scrollbar-thumb:hover {
        background: #157347;
    }

    .table-responsive::-webkit-scrollbar-corner {
        background: #f1f3f4;
    }

    /* Column Specific Styles */
    .table th,
    .table td {
        text-align: center;
        vertical-align: middle;
        padding: 0.5rem 0.25rem;
        word-wrap: break-word;
        white-space: normal;
    }

    .table th:nth-child(1),
    .table td:nth-child(1) {
        width: 50px;
        min-width: 40px;
    }

    .table th:nth-child(2),
    .table td:nth-child(2) {
        width: 150px;
        min-width: 120px;
        text-align: left;
    }

    .table th:nth-child(3),
    .table td:nth-child(3) {
        width: 140px;
        min-width: 120px;
        text-align: left;
    }

    .table th:nth-child(4),
    .table td:nth-child(4) {
        width: 100px;
        min-width: 90px;
    }

    .table th:nth-child(5),
    .table td:nth-child(5) {
        width: 140px;
        min-width: 120px;
        text-align: left;
    }

    .table th:nth-child(6),
    .table td:nth-child(6) {
        width: 80px;
        min-width: 70px;
    }

    .table th:nth-child(7),
    .table td:nth-child(7) {
        width: 120px;
        min-width: 100px;
    }

    .table th:nth-child(8),
    .table td:nth-child(8) {
        width: 100px;
        min-width: 90px;
    }

    .table th:nth-child(9),
    .table td:nth-child(9) {
        width: 100px;
        min-width: 90px;
    }

    .table th:nth-child(10),
    .table td:nth-child(10) {
        width: 120px;
        min-width: 100px;
    }

    /* Button Styles */
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

    /* Form Styles */
    .form-control {
        padding: 0.625rem 0.875rem;
        border: 1px solid #ced4da;
        border-radius: 0.375rem;
        font-size: 0.875rem;
        transition: all 0.2s ease;
        width: 100%;
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
        display: block;
    }

    .action-buttons {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
    }

    /* Report Headers */
    .report-header {
        text-align: center;
        margin-bottom: 20px;
        padding: 1rem 0;
    }

    .report-title {
        font-size: 16pt;
        font-weight: bold;
        margin-bottom: 5px;
        color: #2d3748;
    }

    .report-subtitle {
        font-size: 12pt;
        margin-bottom: 5px;
        color: #4a5568;
    }

    .filter-info {
        text-align: center;
        margin-bottom: 15px;
        font-size: 12pt;
        font-weight: bold;
        color: #2d3748;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .main-content {
            padding: 0.75rem;
        }

        .content-wrapper {
            padding: 0;
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
            font-size: 0.7rem;
            min-width: 800px;
        }

        .table thead th,
        .table tbody td {
            padding: 0.25rem;
            font-size: 0.65rem;
        }

        .action-buttons {
            flex-direction: column;
            gap: 0.5rem;
        }

        .btn {
            width: 100%;
            justify-content: center;
        }
    }

    /* Jika ada sidebar, sesuaikan dengan class dari sidebar.php */
    @media (min-width: 769px) {
        body.has-sidebar .main-content {
            margin-left: 250px;
            width: calc(100% - 250px);
        }

        body.sidebar-collapsed .main-content {
            margin-left: 70px;
            width: calc(100% - 70px);
        }
    }
</style>

<div class="main-content">
    <div class="content-wrapper">
        <!-- Header halaman - tidak akan dicetak -->
        <div class="page-header no-print">
            <div>
                <h2 class="page-title">Data Perkara Pidana Banding</h2>
                <p class="text-muted mb-0">
                    Laporan lengkap perkara pidana banding tahun <?= $filters['tahun'] ?? date('Y') ?>
                </p>
            </div>
            <div class="action-buttons">
                <button onclick="window.print()" class="btn btn-success">
                    <i class="fas fa-print"></i> Print Laporan
                </button>
                <a href="<?= site_url('laporan/cetak_laporan_data_excel?' . $_SERVER['QUERY_STRING']); ?>" class="btn btn-success">
                    <i class="fas fa-file-excel"></i> Export Excel
                </a>
                <a href="<?= site_url('laporan'); ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>

        <!-- Filter - tidak akan dicetak -->
        <div class="filter-card no-print">
            <form method="GET" class="filter-form">
                <div>
                    <label class="form-label">Bulan</label>
                    <select name="bulan" class="form-control">
                        <option value="">Semua Bulan</option>
                        <?php
                        $bulan_options = [
                            '01' => 'Januari',
                            '02' => 'Februari',
                            '03' => 'Maret',
                            '04' => 'April',
                            '05' => 'Mei',
                            '06' => 'Juni',
                            '07' => 'Juli',
                            '08' => 'Agustus',
                            '09' => 'September',
                            '10' => 'Oktober',
                            '11' => 'November',
                            '12' => 'Desember'
                        ];
                        foreach ($bulan_options as $val => $text):
                        ?>
                            <option value="<?= $val ?>" <?= ($filters['bulan'] == $val) ? 'selected' : '' ?>>
                                <?= $text ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label class="form-label">Tahun</label>
                    <select name="tahun" class="form-control">
                        <?php
                        $tahun_sekarang = date('Y');
                        $tahun_selected = $filters['tahun'] ?? $tahun_sekarang;
                        for ($y = 2020; $y <= ($tahun_sekarang + 1); $y++):
                        ?>
                            <option value="<?= $y ?>" <?= ($tahun_selected == $y) ? 'selected' : '' ?>>
                                <?= $y ?>
                            </option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div>
                    <label class="form-label">Jenis Perkara</label>
                    <select name="perkara" class="form-control">
                        <option value="">Semua Jenis</option>
                        <option value="PIDANA" <?= ($filters['perkara'] == 'PIDANA') ? 'selected' : '' ?>>PIDANA</option>
                        <option value="PERDATA" <?= ($filters['perkara'] == 'PERDATA') ? 'selected' : '' ?>>PERDATA</option>
                        <option value="ANAK" <?= ($filters['perkara'] == 'ANAK') ? 'selected' : '' ?>>ANAK</option>
                        <option value="TIPIKOR" <?= ($filters['perkara'] == 'TIPIKOR') ? 'selected' : '' ?>>TIPIKOR</option>
                    </select>
                </div>
                <div>
                    <label class="form-label">Asal Pengadilan</label>
                    <input type="text" name="asal_pengadilan" class="form-control"
                        value="<?= htmlspecialchars($filters['asal_pengadilan'] ?? ''); ?>"
                        placeholder="Nama pengadilan...">
                </div>
                <div class="action-buttons">
                    <button type="submit" class="btn btn-success"><i class="fas fa-filter"></i> Filter</button>
                    <a href="<?= site_url('laporan/laporan_data'); ?>" class="btn btn-secondary"><i class="fas fa-redo"></i> Reset</a>
                </div>
            </form>
        </div>

        <!-- Area yang akan dicetak -->
        <div class="print-area">
            <!-- Header laporan - untuk print -->
            <div class="report-header">
                <div class="report-title">DATA PERKARA PIDANA BANDING PUTUSAN TAHUN <?= $filters['tahun'] ?? date('Y') ?></div>
                <div class="report-subtitle">YANG TIDAK MENGAJUKAN UPAYA HUKUM KASASI TAHUN <?= $filters['tahun'] ?? date('Y') ?></div>
            </div>

            <!-- Info filter - untuk print -->
            <?php if (!empty(array_filter($filters))): ?>
                <div class="filter-info">
                    <?php if (!empty($filters['bulan'])): ?>
                        BULAN: <?= strtoupper($bulan_options[$filters['bulan']]) ?>
                    <?php endif; ?>
                    <?php if (!empty($filters['perkara'])): ?>
                        | JENIS PERKARA: <?= $filters['perkara'] ?>
                    <?php endif; ?>
                    <?php if (!empty($filters['asal_pengadilan'])): ?>
                        | PENGADILAN: <?= strtoupper($filters['asal_pengadilan']) ?>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <!-- Tabel data -->
            <div class="table-wrapper">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th rowspan="2" class="col-no">No.</th>
                                <th rowspan="2" class="col-pengadilan">Asal Pengadilan</th>
                                <th rowspan="2" class="col-nomor-tk1">Nomor Perkara Tk I</th>
                                <th rowspan="2" class="col-tgl-register">Tgl Register</th>
                                <th rowspan="2" class="col-nomor-banding">Nomor Perkara Banding</th>
                                <th rowspan="2" class="col-lama">Lama Proses</th>
                                <th rowspan="2" class="col-status-banding">Status Perkara Tk Banding</th>
                                <th colspan="3">Pemberitahuan</th>
                            </tr>
                            <tr>
                                <th class="col-putusan">Putusan Banding</th>
                                <th class="col-kasasi">Permohonan Kasasi</th>
                                <th class="col-berkas">Pengiriman Berkas Kasasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($perkaras)): ?>
                                <tr>
                                    <td colspan="10" class="text-center py-4">
                                        <div class="d-flex flex-column align-items-center">
                                            <i class="fas fa-folder-open text-muted mb-2" style="font-size: 2rem;"></i>
                                            <p class="text-muted mb-0">Belum ada data perkara yang tersedia</p>
                                        </div>
                                    </td>
                                </tr>
                                <?php else:
                                $no = 1;
                                foreach ($perkaras as $row):
                                ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td style="text-align: left; word-wrap: break-word; max-width: 120px;"><?= htmlspecialchars($row->asal_pengadilan) ?></td>
                                        <td style="text-align: left; word-wrap: break-word; max-width: 140px;"><?= htmlspecialchars($row->nomor_perkara_tk1) ?></td>
                                        <td>
                                            <?= $row->tgl_register_banding ? date('d-m-Y', strtotime($row->tgl_register_banding)) : '-' ?>
                                        </td>
                                        <td style="text-align: left; word-wrap: break-word; max-width: 140px;"><?= htmlspecialchars($row->nomor_perkara_banding) ?></td>
                                        <td><?= htmlspecialchars($row->lama_proses) ?> hari</td>
                                        <td style="word-wrap: break-word; max-width: 100px;"><?= htmlspecialchars($row->status_perkara_tk_banding) ?></td>
                                        <td><?= $row->pemberitahuan_putusan_banding ? date('d-m-Y', strtotime($row->pemberitahuan_putusan_banding)) : '-' ?></td>
                                        <td><?= $row->permohonan_kasasi ? date('d-m-Y', strtotime($row->permohonan_kasasi)) : '-' ?></td>
                                        <td><?= $row->pengiriman_berkas_kasasi ? date('d-m-Y', strtotime($row->pengiriman_berkas_kasasi)) : '-' ?></td>
                                    </tr>
                            <?php endforeach;
                            endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Format tanggal Indonesia untuk print
            const formatTanggalIndonesia = (dateString) => {
                if (!dateString) return '-';
                const date = new Date(dateString);
                const bulan = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun',
                    'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'
                ];
                return date.getDate() + ' ' + bulan[date.getMonth()] + ' ' + date.getFullYear();
            };

            // Handle print button
            window.addEventListener('beforeprint', function() {
                document.title = 'Laporan Data Perkara Pidana Banding ' + new Date().getFullYear();
            });

            // Table responsive enhancements
            const tableWrapper = document.querySelector('.table-wrapper');
            const tableContainer = document.querySelector('.table-responsive');
            const table = document.querySelector('.table');

            if (tableWrapper && tableContainer && table) {
                // Add scroll indicators
                function updateScrollIndicators() {
                    const isScrollableX = tableContainer.scrollWidth > tableContainer.clientWidth;
                    const isScrollableY = tableContainer.scrollHeight > tableContainer.clientHeight;

                    if (isScrollableX || isScrollableY) {
                        tableContainer.setAttribute('title', 'Gunakan scroll mouse atau tombol panah untuk navigasi');
                    } else {
                        tableContainer.removeAttribute('title');
                    }
                }

                // Initialize scroll indicators
                updateScrollIndicators();
                window.addEventListener('resize', updateScrollIndicators);

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
                        case 'Home':
                            e.preventDefault();
                            tableContainer.scrollLeft = 0;
                            break;
                        case 'End':
                            e.preventDefault();
                            tableContainer.scrollLeft = tableContainer.scrollWidth;
                            break;
                    }
                });

                // Make table focusable for keyboard navigation
                tableContainer.setAttribute('tabindex', '0');
            }
        });
    </script>

    <?php $this->load->view('navbar/footer'); ?>