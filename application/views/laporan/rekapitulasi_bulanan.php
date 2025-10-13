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
        width: 100%;
        overflow-x: auto;
        border: 1px solid rgba(0, 0, 0, 0.05);
    }

    .table-wrapper>div {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: thin;
        scrollbar-color: #198754 #f1f3f4;
    }

    .table-wrapper>div::-webkit-scrollbar {
        height: 12px;
        width: 12px;
    }

    .table-wrapper>div::-webkit-scrollbar-track {
        background: #f1f3f4;
        border-radius: 6px;
    }

    .table-wrapper>div::-webkit-scrollbar-thumb {
        background: linear-gradient(135deg, #198754, #0d4b2e);
        border-radius: 6px;
        border: 2px solid #f1f3f4;
    }

    .table-wrapper>div::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(135deg, #0d4b2e, #083920);
    }

    .table {
        width: 100%;
        margin-bottom: 0;
        border-collapse: collapse;
        font-size: 0.8rem;
        table-layout: auto;
        min-width: 1400px;
    }

    .table th,
    .table td {
        padding: 0.875rem 0.5rem;
        text-align: center;
        border: 1px solid #dee2e6;
        vertical-align: middle;
        word-wrap: break-word;
        font-size: 0.8rem;
        transition: all 0.2s ease;
    }

    .table th {
        background: linear-gradient(135deg, #198754, #0d4b2e);
        color: white;
        font-weight: 700;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.075em;
        padding: 1rem 0.5rem;
        position: sticky;
        top: 0;
        z-index: 10;
        position: relative;
    }

    .table th::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 2px;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
    }

    .table tbody tr {
        transition: all 0.3s ease;
    }

    .table tbody tr:hover {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        transform: scale(1.005);
    }

    .table .total-row {
        background: linear-gradient(135deg, #fff3cd 0%, #ffe69c 100%) !important;
        font-weight: bold;
        border-top: 3px solid #ffc107;
        box-shadow: 0 -2px 8px rgba(255, 193, 7, 0.2);
    }

    .table .total-row td {
        color: #856404;
        font-size: 1.05em;
        font-weight: 800;
        padding: 1.25rem 0.5rem;
    }

    .table .quarterly-total {
        background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%) !important;
        font-weight: bold;
        border-top: 2px solid #2196f3;
        border-bottom: 2px solid #2196f3;
    }

    .table .quarterly-total td {
        color: #0d47a1;
        font-weight: 700;
        font-style: italic;
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

    .form-label {
        font-weight: 600;
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
        margin-bottom: 2rem;
    }

    .report-title {
        font-size: 16pt;
        font-weight: bold;
        margin-bottom: 0.5rem;
        text-transform: uppercase;
        color: #1a202c;
    }

    .report-subtitle {
        font-size: 13pt;
        margin-bottom: 0.5rem;
        text-transform: uppercase;
        color: #4a5568;
    }

    .report-year {
        font-size: 14pt;
        font-weight: bold;
        margin-bottom: 1.5rem;
        color: #198754;
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
    .table-wrapper {
        animation: fadeInUp 0.6s ease-out;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .content-wrapper {
            padding: 1rem;
        }

        .page-header {
            flex-direction: column;
            align-items: stretch;
            padding: 1.5rem;
        }

        .page-title {
            font-size: 1.5rem;
        }

        .table {
            font-size: 0.65rem;
            min-width: 1000px;
        }

        .table th,
        .table td {
            padding: 0.5rem 0.25rem;
            font-size: 0.65rem;
        }

        .action-buttons {
            flex-direction: column;
            gap: 0.5rem;
        }

        .filter-form {
            grid-template-columns: 1fr;
        }
    }

    @media (min-width: 1200px) {
        .table {
            min-width: 1600px;
        }
    }
</style>

<div class="main-content">
    <div class="content-wrapper">
        <!-- Page Header -->
        <div class="page-header no-print">
            <div>
                <h2 class="page-title">Rekapitulasi Bulanan Data Perkara</h2>
                <p class="text-muted mb-0">
                    Rekapitulasi data perkara bulanan yang tidak mengajukan upaya hukum kasasi
                </p>
            </div>
            <div class="action-buttons">
                <button onclick="window.print()" class="btn btn-success">
                    <i class="fas fa-print"></i> Print Laporan
                </button>
                <a href="<?= site_url('laporan/export_rekapitulasi_bulanan_excel?' . http_build_query(['tahun' => $tahun, 'periode' => $periode, 'bulan' => $bulan])); ?>" class="btn btn-success">
                    <i class="fas fa-file-excel"></i> Export Excel
                </a>
                <a href="<?= site_url('laporan'); ?>" class="btn btn-info">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>

        <!-- Filter -->
        <div class="filter-card no-print">
            <form method="GET" class="filter-form">
                <div>
                    <label for="tahun" class="form-label">Tahun:</label>
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

                <div>
                    <label for="periode" class="form-label">Periode:</label>
                    <select name="periode" id="periode" class="form-select">
                        <option value="semua" <?= ($periode == 'semua') ? 'selected' : '' ?>>Semua Bulan (1-12)</option>
                        <option value="triwulan" <?= ($periode == 'triwulan') ? 'selected' : '' ?>>Per Triwulan</option>
                        <option value="bulan" <?= ($periode == 'bulan') ? 'selected' : '' ?>>Per Bulan</option>
                    </select>
                </div>

                <div id="bulan-filter" style="<?= ($periode != 'bulan') ? 'display: none;' : '' ?>">
                    <label for="bulan" class="form-label">Bulan:</label>
                    <select name="bulan" id="bulan" class="form-select">
                        <option value="01" <?= ($bulan == '01') ? 'selected' : '' ?>>Januari</option>
                        <option value="02" <?= ($bulan == '02') ? 'selected' : '' ?>>Februari</option>
                        <option value="03" <?= ($bulan == '03') ? 'selected' : '' ?>>Maret</option>
                        <option value="04" <?= ($bulan == '04') ? 'selected' : '' ?>>April</option>
                        <option value="05" <?= ($bulan == '05') ? 'selected' : '' ?>>Mei</option>
                        <option value="06" <?= ($bulan == '06') ? 'selected' : '' ?>>Juni</option>
                        <option value="07" <?= ($bulan == '07') ? 'selected' : '' ?>>Juli</option>
                        <option value="08" <?= ($bulan == '08') ? 'selected' : '' ?>>Agustus</option>
                        <option value="09" <?= ($bulan == '09') ? 'selected' : '' ?>>September</option>
                        <option value="10" <?= ($bulan == '10') ? 'selected' : '' ?>>Oktober</option>
                        <option value="11" <?= ($bulan == '11') ? 'selected' : '' ?>>November</option>
                        <option value="12" <?= ($bulan == '12') ? 'selected' : '' ?>>Desember</option>
                    </select>
                </div>

                <div class="action-buttons">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                    <a href="<?= site_url('laporan/rekapitulasi_bulanan'); ?>" class="btn btn-secondary">
                        <i class="fas fa-undo"></i> Reset Filter
                    </a>
                </div>
            </form>
        </div>

        <!-- Area yang akan dicetak -->
        <div class="print-area">
            <!-- Header laporan - untuk print -->
            <div class="report-header">
                <div class="report-title">REKAPITULASI BULANAN DATA PERKARA YANG TIDAK MENGAJUKAN UPAYA HUKUM KASASI</div>
                <div class="report-subtitle">PENGADILAN TINGGI BANJARMASIN</div>
                <div class="report-year">
                    TAHUN <?= $tahun ?>
                    <?php if ($periode == 'bulan' && $bulan): ?>
                        - <?= strtoupper($nama_bulan) ?>
                    <?php elseif ($periode == 'triwulan'): ?>
                        - PER TRIWULAN
                    <?php endif; ?>
                </div>
            </div>

            <!-- Tabel Rekapitulasi -->
            <div class="table-wrapper">
                <div style="overflow-x: auto; -webkit-overflow-scrolling: touch;">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th rowspan="3" style="vertical-align: middle; min-width: 120px;">
                                    <?php if ($periode == 'triwulan'): ?>
                                        TRIWULAN
                                    <?php elseif ($periode == 'bulan'): ?>
                                        BULAN
                                    <?php else: ?>
                                        BULAN
                                    <?php endif; ?>
                                </th>
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
                        <tbody>
                            <?php
                            $nama_bulan = [
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

                            if ($periode == 'triwulan') {
                                // Display quarterly data
                                $triwulan_names = ['I', 'II', 'III', 'IV'];
                                for ($tw = 1; $tw <= 4; $tw++):
                                    $data_tw = isset($data_periode[$tw]) ? $data_periode[$tw] : array_fill_keys(array_keys($total_all), 0);

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
                                <?php
                                endfor;
                            } elseif ($periode == 'bulan') {
                                // Display single month data
                                $data_bln = isset($data_periode[$bulan]) ? $data_periode[$bulan] : array_fill_keys(array_keys($total_all), 0);

                                // Accumulate totals
                                foreach ($data_bln as $key => $value) {
                                    if (isset($total_all[$key])) {
                                        $total_all[$key] += $value;
                                    }
                                }

                                $total_putus = $data_bln['pidana_putus'] + $data_bln['perdata_putus'] + $data_bln['anak_putus'] + $data_bln['tipikor_putus'];
                                $total_kasasi = $data_bln['pidana_kasasi'] + $data_bln['perdata_kasasi'] + $data_bln['anak_kasasi'] + $data_bln['tipikor_kasasi'];
                                $total_tidak_kasasi = $data_bln['pidana_tidak_kasasi'] + $data_bln['perdata_tidak_kasasi'] + $data_bln['anak_tidak_kasasi'] + $data_bln['tipikor_tidak_kasasi'];

                                $persen_kasasi = $total_putus > 0 ? round(($total_kasasi / $total_putus) * 100, 2) : 0;
                                $persen_tidak_kasasi = $total_putus > 0 ? round(($total_tidak_kasasi / $total_putus) * 100, 2) : 0;
                                ?>
                                <tr>
                                    <td style="font-weight: bold;"><?= $nama_bulan[$bulan] ?></td>
                                    <!-- PIDANA -->
                                    <td><?= $data_bln['pidana_putus'] ?></td>
                                    <td><?= $data_bln['pidana_kasasi'] ?></td>
                                    <td><?= $data_bln['pidana_tidak_kasasi'] ?></td>
                                    <!-- PERDATA -->
                                    <td><?= $data_bln['perdata_putus'] ?></td>
                                    <td><?= $data_bln['perdata_kasasi'] ?></td>
                                    <td><?= $data_bln['perdata_tidak_kasasi'] ?></td>
                                    <!-- ANAK -->
                                    <td><?= $data_bln['anak_putus'] ?></td>
                                    <td><?= $data_bln['anak_kasasi'] ?></td>
                                    <td><?= $data_bln['anak_tidak_kasasi'] ?></td>
                                    <!-- TIPIKOR -->
                                    <td><?= $data_bln['tipikor_putus'] ?></td>
                                    <td><?= $data_bln['tipikor_kasasi'] ?></td>
                                    <td><?= $data_bln['tipikor_tidak_kasasi'] ?></td>
                                    <!-- TOTAL -->
                                    <td style="font-weight: bold;"><?= $total_putus ?></td>
                                    <td style="font-weight: bold;"><?= $total_kasasi ?></td>
                                    <td style="font-weight: bold;"><?= $total_tidak_kasasi ?></td>
                                    <!-- PERSENTASE -->
                                    <td style="font-weight: bold;"><?= $persen_kasasi ?></td>
                                    <td style="font-weight: bold;"><?= $persen_tidak_kasasi ?></td>
                                </tr>
                                <?php
                            } else {
                                // Display all 12 months
                                for ($m = 1; $m <= 12; $m++):
                                    $bulan_key = sprintf('%02d', $m);
                                    $data_bln = isset($data_periode[$bulan_key]) ? $data_periode[$bulan_key] : array_fill_keys(array_keys($total_all), 0);

                                    // Accumulate totals
                                    foreach ($data_bln as $key => $value) {
                                        if (isset($total_all[$key])) {
                                            $total_all[$key] += $value;
                                        }
                                    }

                                    $total_putus = $data_bln['pidana_putus'] + $data_bln['perdata_putus'] + $data_bln['anak_putus'] + $data_bln['tipikor_putus'];
                                    $total_kasasi = $data_bln['pidana_kasasi'] + $data_bln['perdata_kasasi'] + $data_bln['anak_kasasi'] + $data_bln['tipikor_kasasi'];
                                    $total_tidak_kasasi = $data_bln['pidana_tidak_kasasi'] + $data_bln['perdata_tidak_kasasi'] + $data_bln['anak_tidak_kasasi'] + $data_bln['tipikor_tidak_kasasi'];

                                    $persen_kasasi = $total_putus > 0 ? round(($total_kasasi / $total_putus) * 100, 2) : 0;
                                    $persen_tidak_kasasi = $total_putus > 0 ? round(($total_tidak_kasasi / $total_putus) * 100, 2) : 0;

                                    // Add quarterly totals after every 3 months
                                    if ($m % 3 == 0) {
                                        $triwulan_num = $m / 3;
                                        $triwulan_name = ['I', 'II', 'III', 'IV'][$triwulan_num - 1];

                                        // Calculate quarterly totals
                                        $quarterly_total = array_fill_keys(array_keys($total_all), 0);
                                        for ($q = $m - 2; $q <= $m; $q++) {
                                            $q_key = sprintf('%02d', $q);
                                            if (isset($data_periode[$q_key])) {
                                                foreach ($quarterly_total as $key => $value) {
                                                    $quarterly_total[$key] += $data_periode[$q_key][$key] ?? 0;
                                                }
                                            }
                                        }

                                        $q_total_putus = $quarterly_total['pidana_putus'] + $quarterly_total['perdata_putus'] + $quarterly_total['anak_putus'] + $quarterly_total['tipikor_putus'];
                                        $q_total_kasasi = $quarterly_total['pidana_kasasi'] + $quarterly_total['perdata_kasasi'] + $quarterly_total['anak_kasasi'] + $quarterly_total['tipikor_kasasi'];
                                        $q_total_tidak_kasasi = $quarterly_total['pidana_tidak_kasasi'] + $quarterly_total['perdata_tidak_kasasi'] + $quarterly_total['anak_tidak_kasasi'] + $quarterly_total['tipikor_tidak_kasasi'];

                                        $q_persen_kasasi = $q_total_putus > 0 ? round(($q_total_kasasi / $q_total_putus) * 100, 2) : 0;
                                        $q_persen_tidak_kasasi = $q_total_putus > 0 ? round(($q_total_tidak_kasasi / $q_total_putus) * 100, 2) : 0;
                                ?>
                                        <tr>
                                            <td style="font-weight: bold;"><?= $nama_bulan[$bulan_key] ?></td>
                                            <!-- PIDANA -->
                                            <td><?= $data_bln['pidana_putus'] ?></td>
                                            <td><?= $data_bln['pidana_kasasi'] ?></td>
                                            <td><?= $data_bln['pidana_tidak_kasasi'] ?></td>
                                            <!-- PERDATA -->
                                            <td><?= $data_bln['perdata_putus'] ?></td>
                                            <td><?= $data_bln['perdata_kasasi'] ?></td>
                                            <td><?= $data_bln['perdata_tidak_kasasi'] ?></td>
                                            <!-- ANAK -->
                                            <td><?= $data_bln['anak_putus'] ?></td>
                                            <td><?= $data_bln['anak_kasasi'] ?></td>
                                            <td><?= $data_bln['anak_tidak_kasasi'] ?></td>
                                            <!-- TIPIKOR -->
                                            <td><?= $data_bln['tipikor_putus'] ?></td>
                                            <td><?= $data_bln['tipikor_kasasi'] ?></td>
                                            <td><?= $data_bln['tipikor_tidak_kasasi'] ?></td>
                                            <!-- TOTAL -->
                                            <td style="font-weight: bold;"><?= $total_putus ?></td>
                                            <td style="font-weight: bold;"><?= $total_kasasi ?></td>
                                            <td style="font-weight: bold;"><?= $total_tidak_kasasi ?></td>
                                            <!-- PERSENTASE -->
                                            <td style="font-weight: bold;"><?= $persen_kasasi ?></td>
                                            <td style="font-weight: bold;"><?= $persen_tidak_kasasi ?></td>
                                        </tr>
                                        <!-- Quarterly Total Row -->
                                        <tr class="quarterly-total">
                                            <td><strong>TOTAL TW <?= $triwulan_name ?></strong></td>
                                            <!-- PIDANA -->
                                            <td><strong><?= $quarterly_total['pidana_putus'] ?></strong></td>
                                            <td><strong><?= $quarterly_total['pidana_kasasi'] ?></strong></td>
                                            <td><strong><?= $quarterly_total['pidana_tidak_kasasi'] ?></strong></td>
                                            <!-- PERDATA -->
                                            <td><strong><?= $quarterly_total['perdata_putus'] ?></strong></td>
                                            <td><strong><?= $quarterly_total['perdata_kasasi'] ?></strong></td>
                                            <td><strong><?= $quarterly_total['perdata_tidak_kasasi'] ?></strong></td>
                                            <!-- ANAK -->
                                            <td><strong><?= $quarterly_total['anak_putus'] ?></strong></td>
                                            <td><strong><?= $quarterly_total['anak_kasasi'] ?></strong></td>
                                            <td><strong><?= $quarterly_total['anak_tidak_kasasi'] ?></strong></td>
                                            <!-- TIPIKOR -->
                                            <td><strong><?= $quarterly_total['tipikor_putus'] ?></strong></td>
                                            <td><strong><?= $quarterly_total['tipikor_kasasi'] ?></strong></td>
                                            <td><strong><?= $quarterly_total['tipikor_tidak_kasasi'] ?></strong></td>
                                            <!-- TOTAL -->
                                            <td><strong><?= $q_total_putus ?></strong></td>
                                            <td><strong><?= $q_total_kasasi ?></strong></td>
                                            <td><strong><?= $q_total_tidak_kasasi ?></strong></td>
                                            <!-- PERSENTASE -->
                                            <td><strong><?= $q_persen_kasasi ?></strong></td>
                                            <td><strong><?= $q_persen_tidak_kasasi ?></strong></td>
                                        </tr>
                                    <?php
                                    } else {
                                    ?>
                                        <tr>
                                            <td style="font-weight: bold;"><?= $nama_bulan[$bulan_key] ?></td>
                                            <!-- PIDANA -->
                                            <td><?= $data_bln['pidana_putus'] ?></td>
                                            <td><?= $data_bln['pidana_kasasi'] ?></td>
                                            <td><?= $data_bln['pidana_tidak_kasasi'] ?></td>
                                            <!-- PERDATA -->
                                            <td><?= $data_bln['perdata_putus'] ?></td>
                                            <td><?= $data_bln['perdata_kasasi'] ?></td>
                                            <td><?= $data_bln['perdata_tidak_kasasi'] ?></td>
                                            <!-- ANAK -->
                                            <td><?= $data_bln['anak_putus'] ?></td>
                                            <td><?= $data_bln['anak_kasasi'] ?></td>
                                            <td><?= $data_bln['anak_tidak_kasasi'] ?></td>
                                            <!-- TIPIKOR -->
                                            <td><?= $data_bln['tipikor_putus'] ?></td>
                                            <td><?= $data_bln['tipikor_kasasi'] ?></td>
                                            <td><?= $data_bln['tipikor_tidak_kasasi'] ?></td>
                                            <!-- TOTAL -->
                                            <td style="font-weight: bold;"><?= $total_putus ?></td>
                                            <td style="font-weight: bold;"><?= $total_kasasi ?></td>
                                            <td style="font-weight: bold;"><?= $total_tidak_kasasi ?></td>
                                            <!-- PERSENTASE -->
                                            <td style="font-weight: bold;"><?= $persen_kasasi ?></td>
                                            <td style="font-weight: bold;"><?= $persen_tidak_kasasi ?></td>
                                        </tr>
                            <?php
                                    }
                                endfor;
                            }

                            // GRAND TOTAL ROW
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
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const periodeSelect = document.getElementById('periode');
        const bulanFilter = document.getElementById('bulan-filter');

        // Show/hide month filter based on periode selection
        periodeSelect.addEventListener('change', function() {
            if (this.value === 'bulan') {
                bulanFilter.style.display = 'block';
            } else {
                bulanFilter.style.display = 'none';
            }
        });

        // Handle print button
        window.addEventListener('beforeprint', function() {
            const periode = document.getElementById('periode').value;
            const tahun = document.getElementById('tahun').value;
            let title = 'Rekapitulasi Bulanan Data Perkara ' + tahun;

            if (periode === 'bulan') {
                const bulan = document.getElementById('bulan').value;
                const namaBulan = document.getElementById('bulan').options[document.getElementById('bulan').selectedIndex].text;
                title += ' - ' + namaBulan;
            } else if (periode === 'triwulan') {
                title += ' - Per Triwulan';
            }

            document.title = title;
        });
    });
</script>

<?php $this->load->view('navbar/footer'); ?>