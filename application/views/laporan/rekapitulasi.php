<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view('navbar/header');
?>

<style>
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
    }

    .main-content {
        margin-left: 0;
        width: 100%;
        min-height: calc(100vh - 60px);
        background: #f8f9fa;
        padding: 0;
        transition: all 0.3s ease;
    }

    .content-wrapper {
        padding: 1rem;
        margin: 0;
        width: 100%;
        box-sizing: border-box;
        max-width: 100vw;
        overflow-x: hidden;
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
        width: 100%;
        overflow-x: auto;
    }

    .table {
        width: 100%;
        margin-bottom: 0;
        border-collapse: collapse;
        font-size: 0.8rem;
        table-layout: auto;
    }

    .table th,
    .table td {
        padding: 0.5rem 0.25rem;
        text-align: center;
        border: 1px solid #dee2e6;
        vertical-align: middle;
        word-wrap: break-word;
        font-size: 0.75rem;
    }

    .table th {
        background: #198754;
        color: white;
        font-weight: 600;
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        padding: 0.75rem 0.5rem;
        position: sticky;
        top: 0;
        z-index: 10;
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
        font-size: 1em;
        font-weight: bold;
    }

    .form-select {
        padding: 0.625rem 0.875rem;
        border: 1px solid #ced4da;
        border-radius: 0.375rem;
        font-size: 0.875rem;
        background: white;
        transition: all 0.2s ease;
    }

    .form-select:focus {
        border-color: #198754;
        outline: 0;
        box-shadow: 0 0 0 0.2rem rgba(25, 135, 84, 0.15);
    }

    .form-label {
        font-weight: 500;
        margin-bottom: 0.5rem;
        color: #495057;
        font-size: 0.875rem;
    }

    /* Filter form styling */
    .filter-form {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 0.75rem;
        align-items: end;
    }

    .report-header {
        text-align: center;
        margin-bottom: 20px;
    }

    .report-title {
        font-size: 14pt;
        font-weight: bold;
        margin-bottom: 5px;
        text-transform: uppercase;
    }

    .report-subtitle {
        font-size: 12pt;
        margin-bottom: 5px;
        text-transform: uppercase;
    }

    .report-year {
        font-size: 12pt;
        font-weight: bold;
        margin-bottom: 20px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .content-wrapper {
            padding: 0.5rem;
        }

        .page-header {
            flex-direction: column;
            align-items: stretch;
            padding: 1rem;
        }

        .table {
            font-size: 0.65rem;
        }

        .table th,
        .table td {
            padding: 0.25rem;
            font-size: 0.6rem;
        }

        .action-buttons {
            flex-direction: column;
            gap: 0.5rem;
        }

        .filter-form {
            grid-template-columns: 1fr;
        }
    }

    /* Remove sidebar margins for all screen sizes */
    @media (min-width: 769px) {
        .content-wrapper {
            padding: 1.5rem;
        }
    }

    @media (min-width: 1025px) {
        .content-wrapper {
            padding: 2rem;
        }
    }

    /* Scrollbar styling for better UX */
    .table-wrapper::-webkit-scrollbar {
        height: 8px;
        width: 8px;
    }

    .table-wrapper::-webkit-scrollbar-track {
        background: #f1f3f4;
        border-radius: 4px;
    }

    .table-wrapper::-webkit-scrollbar-thumb {
        background: #198754;
        border-radius: 4px;
        border: 1px solid #f1f3f4;
    }

    .table-wrapper::-webkit-scrollbar-thumb:hover {
        background: #157347;
    }
</style>

<div class="main-content">
    <div class="content-wrapper">
        <!-- Page Header -->
        <div class="page-header no-print">
            <div>
                <h2 class="page-title">Rekapitulasi Data Perkara</h2>
                <p class="text-muted mb-0">
                    Rekapitulasi data perkara yang tidak mengajukan upaya hukum kasasi
                </p>
            </div>
            <div class="action-buttons">
                <button onclick="window.print()" class="btn btn-success">
                    <i class="fas fa-print"></i> Print Laporan
                </button>
                <a href="<?= site_url('laporan/cetak_rekapitulasi_excel?tahun=' . $tahun); ?>" class="btn btn-success">
                    <i class="fas fa-file-excel"></i> Export Excel
                </a>
                <a href="<?= site_url('laporan'); ?>" class="btn btn-info">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>

        <!-- Filter Tahun -->
        <div class="filter-card no-print">
            <form method="GET" class="filter-form">
                <div>
                    <label for="tahun" class="form-label">Filter Tahun:</label>
                    <select name="tahun" id="tahun" class="form-select">
                        <?php
                        $tahun_sekarang = date('Y');
                        $tahun_selected = $tahun ?? $tahun_sekarang;
                        for ($y = 2020; $y <= ($tahun_sekarang + 1); $y++):
                        ?>
                            <option value="<?= $y ?>" <?= ($tahun_selected == $y) ? 'selected' : '' ?>>
                                <?= $y ?>
                            </option>
                        <?php endfor; ?>
                    </select>
                </div>

                <div class="action-buttons">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-filter"></i> Filter
                    </button>

                    <a href="<?= site_url('laporan/rekapitulasi'); ?>" class="btn btn-secondary">
                        <i class="fas fa-undo"></i> Reset Filter
                    </a>
                </div>
            </form>
        </div>

        <!-- Area yang akan dicetak -->
        <div class="print-area">
            <!-- Header laporan - untuk print -->
            <div class="report-header">
                <div class="report-title">REKAPITULASI DATA PERKARA YANG TIDAK MENGAJUKAN UPAYA HUKUM KASASI</div>
                <div class="report-subtitle">PENGADILAN TINGGI BANJARMASIN</div>
                <div class="report-year">TAHUN <?= $tahun ?></div>
            </div>

            <!-- Tabel Rekapitulasi -->
            <div class="table-wrapper">
                <div style="overflow-x: auto; -webkit-overflow-scrolling: touch;">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th rowspan="3" style="vertical-align: middle; min-width: 80px;">TRIWULAN</th>
                                <th colspan="3" style="min-width: 180px;">PIDANA</th>
                                <th colspan="3" style="min-width: 180px;">PERDATA</th>
                                <th colspan="3" style="min-width: 180px;">ANAK</th>
                                <th colspan="3" style="min-width: 180px;">TIPIKOR</th>
                                <th colspan="3" style="min-width: 180px;">TOTAL</th>
                                <th colspan="2" style="min-width: 120px;">%</th>
                            </tr>
                            <tr>
                                <th style="min-width: 60px;">PUTUS</th>
                                <th style="min-width: 60px;">KASASI</th>
                                <th style="min-width: 60px;">TIDAK KASASI</th>
                                <th style="min-width: 60px;">PUTUS</th>
                                <th style="min-width: 60px;">KASASI</th>
                                <th style="min-width: 60px;">TIDAK KASASI</th>
                                <th style="min-width: 60px;">PUTUS</th>
                                <th style="min-width: 60px;">KASASI</th>
                                <th style="min-width: 60px;">TIDAK KASASI</th>
                                <th style="min-width: 60px;">PUTUS</th>
                                <th style="min-width: 60px;">KASASI</th>
                                <th style="min-width: 60px;">TIDAK KASASI</th>
                                <th style="min-width: 60px;">PUTUS</th>
                                <th style="min-width: 60px;">KASASI</th>
                                <th style="min-width: 60px;">TIDAK KASASI</th>
                                <th style="min-width: 60px;">KASASI</th>
                                <th style="min-width: 60px;">TIDAK KASASI</th>
                            </tr>
                        </thead>
                        <th>TIDAK KASASI</th>
                        <th>PUTUS</th>
                        <th>KASASI</th>
                        <th>TIDAK KASASI</th>
                        <th>KASASI</th>
                        <th>TIDAK KASASI</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php
                            $triwulan_names = ['I', 'II', 'III', 'IV'];
                            $total_all = [
                                'pidana_putus' => 0,
                                'pidana_kasasi' => 0,
                                'pidana_tidak_kasasi' => 0,
                                'perdata_putus' => 0,
                                'perdata_kasasi' => 0,
                                'perdata_tidak_kasasi' => 0,
                                'anak_putus' => 0,
                                'anak_kasasi' => 0,
                                'anak_tidak_kasasi' => 0,
                                'tipikor_putus' => 0,
                                'tipikor_kasasi' => 0,
                                'tipikor_tidak_kasasi' => 0
                            ];

                            for ($tw = 1; $tw <= 4; $tw++):
                                $data_tw = isset($data_triwulan[$tw]) ? $data_triwulan[$tw] : [
                                    'pidana_putus' => 0,
                                    'pidana_kasasi' => 0,
                                    'pidana_tidak_kasasi' => 0,
                                    'perdata_putus' => 0,
                                    'perdata_kasasi' => 0,
                                    'perdata_tidak_kasasi' => 0,
                                    'anak_putus' => 0,
                                    'anak_kasasi' => 0,
                                    'anak_tidak_kasasi' => 0,
                                    'tipikor_putus' => 0,
                                    'tipikor_kasasi' => 0,
                                    'tipikor_tidak_kasasi' => 0
                                ];

                                // Accumulate totals
                                foreach ($data_tw as $key => $value) {
                                    if (isset($total_all[$key])) {
                                        $total_all[$key] += $value;
                                    }
                                }

                                $total_putus = $data_tw['pidana_putus'] + $data_tw['perdata_putus'] + $data_tw['anak_putus'] + $data_tw['tipikor_putus'];
                                $total_kasasi = $data_tw['pidana_kasasi'] + $data_tw['perdata_kasasi'] + $data_tw['anak_kasasi'] + $data_tw['tipikor_kasasi'];
                                $total_tidak_kasasi = $data_tw['pidana_tidak_kasasi'] + $data_tw['perdata_tidak_kasasi'] + $data_tw['anak_tidak_kasasi'] + $data_tw['tipikor_tidak_kasasi'];

                                $persen_kasasi = $total_putus > 0 ? round(($total_kasasi / $total_putus) * 100, 2) : 0;
                                $persen_tidak_kasasi = $total_putus > 0 ? round(($total_tidak_kasasi / $total_putus) * 100, 2) : 0;
                            ?>
                                <tr>
                                    <td style="font-weight: bold;"><?= $triwulan_names[$tw - 1] ?></td>
                                    <!-- PIDANA -->
                                    <td><?= $data_tw['pidana_putus'] ?></td>
                                    <td><?= $data_tw['pidana_kasasi'] ?></td>
                                    <td><?= $data_tw['pidana_tidak_kasasi'] ?></td>
                                    <!-- PERDATA -->
                                    <td><?= $data_tw['perdata_putus'] ?></td>
                                    <td><?= $data_tw['perdata_kasasi'] ?></td>
                                    <td><?= $data_tw['perdata_tidak_kasasi'] ?></td>
                                    <!-- ANAK -->
                                    <td><?= $data_tw['anak_putus'] ?></td>
                                    <td><?= $data_tw['anak_kasasi'] ?></td>
                                    <td><?= $data_tw['anak_tidak_kasasi'] ?></td>
                                    <!-- TIPIKOR -->
                                    <td><?= $data_tw['tipikor_putus'] ?></td>
                                    <td><?= $data_tw['tipikor_kasasi'] ?></td>
                                    <td><?= $data_tw['tipikor_tidak_kasasi'] ?></td>
                                    <!-- TOTAL -->
                                    <td style="font-weight: bold;"><?= $total_putus ?></td>
                                    <td style="font-weight: bold;"><?= $total_kasasi ?></td>
                                    <td style="font-weight: bold;"><?= $total_tidak_kasasi ?></td>
                                    <!-- PERSENTASE -->
                                    <td style="font-weight: bold;"><?= $persen_kasasi ?></td>
                                    <td style="font-weight: bold;"><?= $persen_tidak_kasasi ?></td>
                                </tr>
                            <?php endfor; ?>

                            <!-- TOTAL ROW -->
                            <?php
                            $grand_total_putus = $total_all['pidana_putus'] + $total_all['perdata_putus'] + $total_all['anak_putus'] + $total_all['tipikor_putus'];
                            $grand_total_kasasi = $total_all['pidana_kasasi'] + $total_all['perdata_kasasi'] + $total_all['anak_kasasi'] + $total_all['tipikor_kasasi'];
                            $grand_total_tidak_kasasi = $total_all['pidana_tidak_kasasi'] + $total_all['perdata_tidak_kasasi'] + $total_all['anak_tidak_kasasi'] + $total_all['tipikor_tidak_kasasi'];

                            $grand_persen_kasasi = $grand_total_putus > 0 ? round(($grand_total_kasasi / $grand_total_putus) * 100, 2) : 0;
                            $grand_persen_tidak_kasasi = $grand_total_putus > 0 ? round(($grand_total_tidak_kasasi / $grand_total_putus) * 100, 2) : 0;
                            ?>
                            <tr class="total-row">
                                <td><strong>TOTAL</strong></td>
                                <!-- PIDANA -->
                                <td><strong><?= $total_all['pidana_putus'] ?></strong></td>
                                <td><strong><?= $total_all['pidana_kasasi'] ?></strong></td>
                                <td><strong><?= $total_all['pidana_tidak_kasasi'] ?></strong></td>
                                <!-- PERDATA -->
                                <td><strong><?= $total_all['perdata_putus'] ?></strong></td>
                                <td><strong><?= $total_all['perdata_kasasi'] ?></strong></td>
                                <td><strong><?= $total_all['perdata_tidak_kasasi'] ?></strong></td>
                                <!-- ANAK -->
                                <td><strong><?= $total_all['anak_putus'] ?></strong></td>
                                <td><strong><?= $total_all['anak_kasasi'] ?></strong></td>
                                <td><strong><?= $total_all['anak_tidak_kasasi'] ?></strong></td>
                                <!-- TIPIKOR -->
                                <td><strong><?= $total_all['tipikor_putus'] ?></strong></td>
                                <td><strong><?= $total_all['tipikor_kasasi'] ?></strong></td>
                                <td><strong><?= $total_all['tipikor_tidak_kasasi'] ?></strong></td>
                                <!-- TOTAL -->
                                <td><strong><?= $grand_total_putus ?></strong></td>
                                <td><strong><?= $grand_total_kasasi ?></strong></td>
                                <td><strong><?= $grand_total_tidak_kasasi ?></strong></td>
                                <!-- PERSENTASE -->
                                <td><strong><?= $grand_persen_kasasi ?></strong></td>
                                <td><strong><?= $grand_persen_tidak_kasasi ?></strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Tanda Tangan -->
            <div style="margin-top: 50px; display: flex; justify-content: space-between;">
                <div style="text-align: center; width: 45%;">
                    <p>Mengetahui,</p>
                    <p><strong>PANITERA PENGADILAN TINGGI BANJARMASIN</strong></p>
                    <br><br><br>
                    <p><strong>LESTIJONO WARSITO</strong></p>
                </div>
                <div style="text-align: center; width: 45%;">
                    <p><strong>PANITERA MUDA HUKUM</strong></p>
                    <br><br><br><br>
                    <p><strong>YUHANA SARI YASMANI</strong></p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle print button
        window.addEventListener('beforeprint', function() {
            document.title = 'Rekapitulasi Data Perkara ' + new Date().getFullYear();
        });
    });
</script>

<?php $this->load->view('navbar/footer'); ?>