<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_Session $session
 * @property CI_Input $input
 * @property CI_DB_query_builder $db
 * @property Perkara_model $Perkara_model
 */
class Laporan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Perkara_model');
        $this->load->helper('url');
        $this->load->library('session');

        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }

        require_once(APPPATH . 'third_party/fpdf.php');
    }

    // =========================
    // Halaman laporan
    // =========================
    public function index()
    {
        $filters = [
            'bulan'           => $this->input->get('bulan', TRUE),
            'asal_pengadilan' => $this->input->get('asal_pengadilan', TRUE),
            'klasifikasi'     => $this->input->get('klasifikasi', TRUE),
            'status'          => $this->input->get('status', TRUE)
        ];

        $useFilter = array_filter($filters);

        if ($useFilter) {
            $data['perkaras'] = $this->Perkara_model->get_filtered($filters);
        } else {
            $data['perkaras'] = $this->Perkara_model->get_all();
        }

        $data['filters'] = $filters;

        $this->load->view('navbar/header');
        $this->load->view('laporan/laporan', $data);
        $this->load->view('navbar/footer');
    }

    // =========================
    // Laporan Data Perkara (seperti format gambar)
    // =========================
    public function laporan_data()
    {
        $filters = [
            'bulan'           => $this->input->get('bulan', TRUE),
            'tahun'           => $this->input->get('tahun', TRUE),
            'perkara'         => $this->input->get('perkara', TRUE),
            'asal_pengadilan' => $this->input->get('asal_pengadilan', TRUE)
        ];

        $useFilter = array_filter($filters);

        if ($useFilter) {
            $data['perkaras'] = $this->Perkara_model->get_filtered($filters);
        } else {
            $data['perkaras'] = $this->Perkara_model->get_all();
        }

        $data['filters'] = $filters;

        $this->load->view('laporan/laporan_data', $data);
    }

    // =========================
    // Cetak laporan PDF
    // =========================
    public function cetak_laporan()
    {
        $filters = [
            'bulan'           => $this->input->get('bulan', TRUE),
            'asal_pengadilan' => $this->input->get('asal_pengadilan', TRUE),
            'klasifikasi'     => $this->input->get('klasifikasi', TRUE),
            'status'          => $this->input->get('status', TRUE)
        ];

        $perkaras = $this->Perkara_model->get_filtered($filters);

        $judul = "Laporan Perkara";
        if (!empty($filters['bulan'])) {
            $judul .= " Bulan " . date("F Y", strtotime($filters['bulan'] . '-01'));
        }
        if (!empty($filters['asal_pengadilan'])) {
            $judul .= " | Asal: " . $filters['asal_pengadilan'];
        }
        if (!empty($filters['klasifikasi'])) {
            $judul .= " | Klasifikasi: " . $filters['klasifikasi'];
        }
        if (!empty($filters['status'])) {
            $judul .= " | Status: " . $filters['status'];
        }

        $pdf = new FPDF('L', 'mm', 'A4');
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 10, $judul, 0, 1, 'C');
        $pdf->Ln(5);

        // Header dengan kolom Parent yang menampilkan nama
        $pdf->SetFont('Arial', 'B', 8);
        $header = [
            'No' => 8,
            'Asal Pengadilan' => 28,
            'Nomor Tk1' => 28,
            'Parent' => 25,
            'Klasifikasi' => 25,
            'Tgl Register' => 20,
            'Nomor Banding' => 28,
            'Lama Proses' => 18,
            'Status Tk Banding' => 30,
            'Pemberitahuan Putusan' => 30,
            'Permohonan Kasasi' => 25,
            'Pengiriman Berkas' => 25,
            'Status' => 20
        ];

        $pdf->SetFillColor(200, 200, 200);
        foreach ($header as $h => $w) {
            $pdf->Cell($w, 7, $h, 1, 0, 'C', true);
        }
        $pdf->Ln();

        $pdf->SetFont('Arial', '', 8);
        $no = 1;
        if (!empty($perkaras)) {
            foreach ($perkaras as $row) {
                // Gunakan parent_nama, jika kosong tampilkan '-'
                $parentText = !empty($row->parent_nama) ? $row->parent_nama : '-';

                $heights = [
                    6,
                    $this->getMultiCellHeight($header['Asal Pengadilan'], $row->asal_pengadilan),
                    $this->getMultiCellHeight($header['Nomor Tk1'], $row->nomor_perkara_tk1),
                    $this->getMultiCellHeight($header['Parent'], $parentText),
                    $this->getMultiCellHeight($header['Klasifikasi'], $row->klasifikasi),
                    6,
                    $this->getMultiCellHeight($header['Nomor Banding'], $row->nomor_perkara_banding),
                    6,
                    $this->getMultiCellHeight($header['Status Tk Banding'], $row->status_perkara_tk_banding),
                    6,
                    6,
                    6,
                    $this->getMultiCellHeight($header['Status'], $row->status),
                ];
                $maxHeight = max($heights);

                $startX = $pdf->GetX();
                $startY = $pdf->GetY();

                $pdf->Cell($header['No'], $maxHeight, $no++, 1, 0, 'C');
                $this->multiCellColumn($pdf, $header['Asal Pengadilan'], $row->asal_pengadilan);
                $this->multiCellColumn($pdf, $header['Nomor Tk1'], $row->nomor_perkara_tk1);
                $this->multiCellColumn($pdf, $header['Parent'], $parentText);
                $this->multiCellColumn($pdf, $header['Klasifikasi'], $row->klasifikasi);

                $pdf->Cell(
                    $header['Tgl Register'],
                    $maxHeight,
                    !empty($row->tgl_register_banding) ? date('d-m-Y', strtotime($row->tgl_register_banding)) : '-',
                    1,
                    0,
                    'C'
                );

                $this->multiCellColumn($pdf, $header['Nomor Banding'], $row->nomor_perkara_banding);
                $pdf->Cell($header['Lama Proses'], $maxHeight, $row->lama_proses, 1, 0, 'C');
                $this->multiCellColumn($pdf, $header['Status Tk Banding'], $row->status_perkara_tk_banding);

                $pdf->Cell(
                    $header['Pemberitahuan Putusan'],
                    $maxHeight,
                    !empty($row->pemberitahuan_putusan_banding) ? date('d-m-Y', strtotime($row->pemberitahuan_putusan_banding)) : '-',
                    1,
                    0,
                    'C'
                );
                $pdf->Cell(
                    $header['Permohonan Kasasi'],
                    $maxHeight,
                    !empty($row->permohonan_kasasi) ? date('d-m-Y', strtotime($row->permohonan_kasasi)) : '-',
                    1,
                    0,
                    'C'
                );
                $pdf->Cell(
                    $header['Pengiriman Berkas'],
                    $maxHeight,
                    !empty($row->pengiriman_berkas_kasasi) ? date('d-m-Y', strtotime($row->pengiriman_berkas_kasasi)) : '-',
                    1,
                    0,
                    'C'
                );

                $pdf->SetFont('Arial', 'B', 8);
                $this->multiCellColumn($pdf, $header['Status'], $row->status, 'C');
                $pdf->SetFont('Arial', '', 8);

                $pdf->SetXY($startX, $startY + $maxHeight);
            }
        } else {
            $pdf->Cell(array_sum($header), 6, 'Tidak ada data perkara', 1, 1, 'C');
        }

        $pdf->Output('I', 'Laporan_Perkara.pdf');
    }

    // =========================
    // Cetak laporan data PDF (format sesuai gambar)
    // =========================
    public function cetak_laporan_data_pdf()
    {
        $filters = [
            'bulan'           => $this->input->get('bulan', TRUE),
            'perkara'         => $this->input->get('perkara', TRUE),
            'asal_pengadilan' => $this->input->get('asal_pengadilan', TRUE)
        ];

        $perkaras = $this->Perkara_model->get_filtered($filters);

        $pdf = new FPDF('L', 'mm', 'A4');
        $pdf->AddPage();

        // Header
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 8, 'DATA PERKARA PIDANA BANDING PUTUSAN TAHUN ' . date('Y'), 0, 1, 'C');
        $pdf->Cell(0, 6, 'YANG TIDAK MENGAJUKAN UPAYA HUKUM KASASI TAHUN ' . date('Y'), 0, 1, 'C');
        $pdf->Ln(5);

        // Info filter
        if (!empty(array_filter($filters))) {
            $pdf->SetFont('Arial', 'B', 10);
            $filterText = '';
            if (!empty($filters['bulan'])) {
                $bulan_nama = [
                    '01' => 'JANUARI',
                    '02' => 'FEBRUARI',
                    '03' => 'MARET',
                    '04' => 'APRIL',
                    '05' => 'MEI',
                    '06' => 'JUNI',
                    '07' => 'JULI',
                    '08' => 'AGUSTUS',
                    '09' => 'SEPTEMBER',
                    '10' => 'OKTOBER',
                    '11' => 'NOVEMBER',
                    '12' => 'DESEMBER'
                ];
                $filterText .= 'BULAN: ' . $bulan_nama[$filters['bulan']];
            }
            if (!empty($filters['perkara'])) {
                $filterText .= ($filterText ? ' | ' : '') . 'JENIS PERKARA: ' . $filters['perkara'];
            }
            if (!empty($filters['asal_pengadilan'])) {
                $filterText .= ($filterText ? ' | ' : '') . 'PENGADILAN: ' . strtoupper($filters['asal_pengadilan']);
            }
            if ($filterText) {
                $pdf->Cell(0, 6, $filterText, 0, 1, 'C');
                $pdf->Ln(3);
            }
        }

        // Header tabel
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->SetFillColor(230, 230, 230);

        // Baris pertama header
        $pdf->Cell(12, 12, 'No.', 1, 0, 'C', true);
        $pdf->Cell(30, 12, 'Asal Pengadilan', 1, 0, 'C', true);
        $pdf->Cell(40, 12, 'Nomor Perkara Tk I', 1, 0, 'C', true);
        $pdf->Cell(22, 12, 'Tgl Register', 1, 0, 'C', true);
        $pdf->Cell(40, 12, 'Nomor Perkara Banding', 1, 0, 'C', true);
        $pdf->Cell(18, 12, 'Lama Proses', 1, 0, 'C', true);
        $pdf->Cell(30, 12, 'Status Perkara Tk Banding', 1, 0, 'C', true);
        $pdf->Cell(60, 6, 'Pemberitahuan', 1, 0, 'C', true);
        $pdf->Cell(25, 12, 'Pengiriman Berkas Kasasi', 1, 1, 'C', true);

        // Baris kedua header (sub-kolom pemberitahuan)
        $pdf->SetX($pdf->GetX() + 192); // Skip kolom sebelumnya
        $pdf->Cell(20, 6, 'Putusan Banding', 1, 0, 'C', true);
        $pdf->Cell(20, 6, 'Permohonan Kasasi', 1, 0, 'C', true);
        $pdf->Cell(20, 6, 'Pengiriman Berkas Kasasi', 1, 1, 'C', true);

        // Data tabel
        $pdf->SetFont('Arial', '', 7);
        $no = 1;
        if (!empty($perkaras)) {
            foreach ($perkaras as $row) {
                $pdf->Cell(12, 8, $no++, 1, 0, 'C');
                $pdf->Cell(30, 8, substr($row->asal_pengadilan, 0, 20), 1, 0, 'L');
                $pdf->Cell(40, 8, substr($row->nomor_perkara_tk1, 0, 25), 1, 0, 'L');
                $pdf->Cell(22, 8, $row->tgl_register_banding ? date('d M Y', strtotime($row->tgl_register_banding)) : '-', 1, 0, 'C');
                $pdf->Cell(40, 8, substr($row->nomor_perkara_banding, 0, 25), 1, 0, 'L');
                $pdf->Cell(18, 8, $row->lama_proses . ' hari', 1, 0, 'C');
                $pdf->Cell(30, 8, substr($row->status_perkara_tk_banding, 0, 15), 1, 0, 'C');
                $pdf->Cell(20, 8, $row->pemberitahuan_putusan_banding ? date('d Ja Y', strtotime($row->pemberitahuan_putusan_banding)) : '-', 1, 0, 'C');
                $pdf->Cell(20, 8, $row->permohonan_kasasi ? date('d Ja Y', strtotime($row->permohonan_kasasi)) : '-', 1, 0, 'C');
                $pdf->Cell(20, 8, $row->pengiriman_berkas_kasasi ? date('d Ja Y', strtotime($row->pengiriman_berkas_kasasi)) : '-', 1, 0, 'C');
                $pdf->Cell(25, 8, $row->pengiriman_berkas_kasasi ? date('d Ja Y', strtotime($row->pengiriman_berkas_kasasi)) : '-', 1, 1, 'C');
            }
        } else {
            $pdf->Cell(277, 8, 'Tidak ada data perkara', 1, 1, 'C');
        }

        $filename = 'Laporan_Data_Perkara_' . date('Y');
        if (!empty($filters['bulan'])) {
            $bulan_nama = [
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
            $filename .= '_' . $bulan_nama[$filters['bulan']];
        }
        if (!empty($filters['perkara'])) {
            $filename .= '_' . $filters['perkara'];
        }
        $filename .= '.pdf';

        $pdf->Output('I', $filename);
    }

    // =========================
    // Cetak laporan data Excel (format sesuai gambar)
    // =========================
    public function cetak_laporan_data_excel()
    {
        $filters = [
            'bulan'           => $this->input->get('bulan', TRUE),
            'tahun'           => $this->input->get('tahun', TRUE),
            'perkara'         => $this->input->get('perkara', TRUE),
            'asal_pengadilan' => $this->input->get('asal_pengadilan', TRUE)
        ];

        $perkaras = $this->Perkara_model->get_filtered($filters);

        $filename = 'Laporan_Data_Perkara_' . ($filters['tahun'] ?? date('Y'));
        if (!empty($filters['bulan'])) {
            $bulan_nama = [
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
            $filename .= '_' . $bulan_nama[$filters['bulan']];
        }
        if (!empty($filters['perkara'])) {
            $filename .= '_' . $filters['perkara'];
        }
        $filename .= '.xls';

        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=" . $filename);

        ob_start();
?>
        <html>

        <head>
            <style>
                table {
                    border-collapse: collapse;
                    width: 100%;
                    font-family: Arial, sans-serif;
                }

                th,
                td {
                    border: 1px solid #444;
                    padding: 5px;
                    font-size: 10pt;
                    text-align: center;
                }

                th {
                    background: #198754;
                    color: #fff;
                    font-weight: bold;
                }

                .title {
                    background: #d4edda;
                    font-size: 14pt;
                    font-weight: bold;
                    padding: 10px;
                }

                .subtitle {
                    background: #f8f9fa;
                    font-size: 12pt;
                    font-weight: bold;
                    padding: 8px;
                }

                .filter-info {
                    background: #fff3cd;
                    font-size: 11pt;
                    font-weight: bold;
                    padding: 8px;
                }

                .text-left {
                    text-align: left;
                }
            </style>
        </head>

        <body>
            <table>
                <tr>
                    <td colspan="11" class="title">DATA PERKARA PIDANA BANDING PUTUSAN TAHUN <?= $filters['tahun'] ?? date('Y') ?></td>
                </tr>
                <tr>
                    <td colspan="11" class="subtitle">YANG TIDAK MENGAJUKAN UPAYA HUKUM KASASI TAHUN <?= $filters['tahun'] ?? date('Y') ?></td>
                </tr>

                <?php if (!empty(array_filter($filters))): ?>
                    <tr>
                        <td colspan="11" class="filter-info">
                            <?php
                            $filterText = '';
                            if (!empty($filters['bulan'])) {
                                $bulan_nama = [
                                    '01' => 'JANUARI',
                                    '02' => 'FEBRUARI',
                                    '03' => 'MARET',
                                    '04' => 'APRIL',
                                    '05' => 'MEI',
                                    '06' => 'JUNI',
                                    '07' => 'JULI',
                                    '08' => 'AGUSTUS',
                                    '09' => 'SEPTEMBER',
                                    '10' => 'OKTOBER',
                                    '11' => 'NOVEMBER',
                                    '12' => 'DESEMBER'
                                ];
                                $filterText .= 'BULAN: ' . $bulan_nama[$filters['bulan']];
                            }
                            if (!empty($filters['perkara'])) {
                                $filterText .= ($filterText ? ' | ' : '') . 'JENIS PERKARA: ' . $filters['perkara'];
                            }
                            if (!empty($filters['asal_pengadilan'])) {
                                $filterText .= ($filterText ? ' | ' : '') . 'PENGADILAN: ' . strtoupper($filters['asal_pengadilan']);
                            }
                            echo $filterText;
                            ?>
                        </td>
                    </tr>
                <?php endif; ?>

                <!-- Header tabel dengan rowspan -->
                <tr>
                    <th rowspan="2">No.</th>
                    <th rowspan="2">Asal Pengadilan</th>
                    <th rowspan="2">Nomor Perkara Tk I</th>
                    <th rowspan="2">Tgl Register</th>
                    <th rowspan="2">Nomor Perkara Banding</th>
                    <th rowspan="2">Lama Proses</th>
                    <th rowspan="2">Status Perkara Tk Banding</th>
                    <th colspan="3">Pemberitahuan</th>
                    <th rowspan="2">Pengiriman Berkas Kasasi</th>
                </tr>
                <tr>
                    <th>Putusan Banding</th>
                    <th>Permohonan Kasasi</th>
                    <th>Pengiriman Berkas Kasasi</th>
                </tr>

                <!-- Data tabel -->
                <?php if (!empty($perkaras)):
                    $no = 1;
                    foreach ($perkaras as $row):
                ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td class="text-left"><?= htmlspecialchars($row->asal_pengadilan) ?></td>
                            <td class="text-left"><?= htmlspecialchars($row->nomor_perkara_tk1) ?></td>
                            <td><?= $row->tgl_register_banding ? date("d M Y", strtotime($row->tgl_register_banding)) : '-' ?></td>
                            <td class="text-left"><?= htmlspecialchars($row->nomor_perkara_banding) ?></td>
                            <td><?= htmlspecialchars($row->lama_proses) ?> hari</td>
                            <td><?= htmlspecialchars($row->status_perkara_tk_banding) ?></td>
                            <td><?= $row->pemberitahuan_putusan_banding ? date("d M Y", strtotime($row->pemberitahuan_putusan_banding)) : '-' ?></td>
                            <td><?= $row->permohonan_kasasi ? date("d M Y", strtotime($row->permohonan_kasasi)) : '-' ?></td>
                            <td><?= $row->pengiriman_berkas_kasasi ? date("d M Y", strtotime($row->pengiriman_berkas_kasasi)) : '-' ?></td>
                            <td><?= $row->pengiriman_berkas_kasasi ? date("d M Y", strtotime($row->pengiriman_berkas_kasasi)) : '-' ?></td>
                        </tr>
                    <?php endforeach;
                else: ?>
                    <tr>
                        <td colspan="11">Tidak ada data perkara</td>
                    </tr>
                <?php endif; ?>
            </table>
        </body>

        </html>
    <?php
        echo ob_get_clean();
    }

    // =========================
    // Cetak Excel
    // =========================
    public function cetak_excel()
    {
        $filters = [
            'bulan'           => $this->input->get('bulan', TRUE),
            'asal_pengadilan' => $this->input->get('asal_pengadilan', TRUE),
            'klasifikasi'     => $this->input->get('klasifikasi', TRUE),
            'status'          => $this->input->get('status', TRUE)
        ];

        $perkaras = $this->Perkara_model->get_filtered($filters);

        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=Laporan_Perkara.xls");

        ob_start();
    ?>
        <html>

        <head>
            <style>
                table {
                    border-collapse: collapse;
                    width: 100%;
                    table-layout: fixed;
                    font-family: Arial, sans-serif;
                }

                th,
                td {
                    border: 1px solid #444;
                    padding: 7px 5px;
                    font-size: 10pt;
                    word-wrap: break-word;
                }

                th {
                    background: #198754;
                    color: #fff;
                    text-align: center;
                    font-weight: bold;
                    font-size: 11pt;
                }

                tr:nth-child(even) td {
                    background: #f8f9fa;
                }

                tr:hover td {
                    background: #e2f0d9;
                }

                td.center {
                    text-align: center;
                }

                td.bold {
                    font-weight: bold;
                }
            </style>
        </head>

        <body>
            <table>
                <thead>
                    <tr>
                        <th colspan="13" style="text-align:center;font-size:16pt;padding:12px 0 6px 0;letter-spacing:1px;">LAPORAN PERKARA</th>
                    </tr>
                    <?php if (!empty($filters['bulan'])): ?>
                        <tr>
                            <td colspan="13" style="background:#fff;text-align:center;font-size:11pt;padding-bottom:10px;">Laporan di Bulan <b><?= date('F Y', strtotime($filters['bulan'] . '-01')) ?></b></td>
                        </tr>
                    <?php endif; ?>
                    <tr>
                        <th style="width:45px;">No</th>
                        <th style="width:180px;">Asal Pengadilan</th>
                        <th style="width:160px;">Nomor Perkara Tk1</th>
                        <th style="width:120px;">Parent</th>
                        <th style="width:140px;">Klasifikasi</th>
                        <th style="width:120px;">Tgl Register Banding</th>
                        <th style="width:160px;">Nomor Perkara Banding</th>
                        <th style="width:90px;">Lama Proses</th>
                        <th style="width:150px;">Status Tk Banding</th>
                        <th style="width:150px;">Putusan Banding</th>
                        <th style="width:120px;">Permohonan Kasasi</th>
                        <th style="width:150px;">Pengiriman Berkas Kasasi</th>
                        <th style="width:90px;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($perkaras)): $no = 1;
                        foreach ($perkaras as $row): ?>
                            <tr>
                                <td class="center"><?= $no++ ?></td>
                                <td><?= htmlspecialchars($row->asal_pengadilan) ?></td>
                                <td><?= htmlspecialchars($row->nomor_perkara_tk1) ?></td>
                                <td><?= !empty($row->parent_nama) ? htmlspecialchars($row->parent_nama) : '-' ?></td>
                                <td><?= htmlspecialchars($row->klasifikasi) ?></td>
                                <td class="center"><?= !empty($row->tgl_register_banding) ? date("d-m-Y", strtotime($row->tgl_register_banding)) : '-' ?></td>
                                <td><?= htmlspecialchars($row->nomor_perkara_banding) ?></td>
                                <td class="center"><?= htmlspecialchars($row->lama_proses) ?></td>
                                <td><?= htmlspecialchars($row->status_perkara_tk_banding) ?></td>
                                <td class="center"><?= !empty($row->pemberitahuan_putusan_banding) ? date("d-m-Y", strtotime($row->pemberitahuan_putusan_banding)) : '-' ?></td>
                                <td class="center"><?= !empty($row->permohonan_kasasi) ? date("d-m-Y", strtotime($row->permohonan_kasasi)) : '-' ?></td>
                                <td class="center"><?= !empty($row->pengiriman_berkas_kasasi) ? date("d-m-Y", strtotime($row->pengiriman_berkas_kasasi)) : '-' ?></td>
                                <td class="center bold"><?= htmlspecialchars($row->status) ?></td>
                            </tr>
                        <?php endforeach;
                    else: ?>
                        <tr>
                            <td colspan="13" class="center">Tidak ada data perkara</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </body>

        </html>
    <?php
        echo ob_get_clean();
    }

    // =========================
    // Laporan Rekap Kasasi/Tidak Kasasi
    // =========================
    public function rekap()
    {
        // Get year and month from URL parameters
        $tahun = $this->input->get('tahun', TRUE) ?: date('Y');
        $bulan = $this->input->get('bulan', TRUE);

        // Get monthly breakdown data
        if ($bulan) {
            // If month is selected, get data only for that month
            $rekap_bulanan = $this->get_rekap_data_bulanan_filtered($tahun, $bulan);
        } else {
            // If no month selected, get all months for the year
            $rekap_bulanan = $this->get_rekap_data_bulanan($tahun);
        }

        // Calculate total for the filtered data
        $rekap_total = array(
            'jumlah_kasasi' => 0,
            'jumlah_tidak_kasasi' => 0,
            'jumlah_putus_banding' => 0
        );

        foreach ($rekap_bulanan as $data_bulan) {
            $rekap_total['jumlah_kasasi'] += $data_bulan['jumlah_kasasi'];
            $rekap_total['jumlah_tidak_kasasi'] += $data_bulan['jumlah_tidak_kasasi'];
            $rekap_total['jumlah_putus_banding'] += $data_bulan['jumlah_putus_banding'];
        }

        // Prepare month name for display
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

        $data = array(
            'rekap_bulanan' => $rekap_bulanan,
            'rekap_total' => $rekap_total,
            'tahun' => $tahun,
            'bulan' => $bulan,
            'nama_bulan_terpilih' => $bulan ? $nama_bulan[$bulan] : '',
            'tahun_options' => $this->get_tahun_options()
        );

        $this->load->view('laporan/rekap', $data);
    }

    public function cetak_rekap()
    {
        $tahun = $this->input->get('tahun', TRUE) ?: date('Y');
        $bulan = $this->input->get('bulan', TRUE);

        // Get data based on filter
        if ($bulan) {
            $rekap_bulanan = $this->get_rekap_data_bulanan_filtered($tahun, $bulan);
            $judul = 'Laporan Rekap Perkara Pidana Banding';
            $subjudul = 'Bulan ' . $rekap_bulanan[0]['nama_bulan'] . ' ' . $tahun;
        } else {
            $rekap_bulanan = $this->get_rekap_data_bulanan($tahun);
            $judul = 'Laporan Rekap Perkara Pidana Banding';
            $subjudul = 'Tahun ' . $tahun;
        }

        // Calculate total
        $rekap_total = array(
            'jumlah_kasasi' => 0,
            'jumlah_tidak_kasasi' => 0,
            'jumlah_putus_banding' => 0
        );

        foreach ($rekap_bulanan as $data_bulan) {
            $rekap_total['jumlah_kasasi'] += $data_bulan['jumlah_kasasi'];
            $rekap_total['jumlah_tidak_kasasi'] += $data_bulan['jumlah_tidak_kasasi'];
            $rekap_total['jumlah_putus_banding'] += $data_bulan['jumlah_putus_banding'];
        }

        $pdf = new FPDF('L', 'mm', 'A4'); // Landscape untuk muat semua bulan
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 10, $judul, 0, 1, 'C');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 8, $subjudul, 0, 1, 'C');
        $pdf->Ln(10);

        // Tabel rekap per bulan
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetFillColor(200, 220, 255);

        // Header tabel
        $colWidth = 21; // 13 kolom (bulan + total) x 21 = 273mm
        $pdf->Cell($colWidth, 8, 'Bulan', 1, 0, 'C', true);
        $pdf->Cell($colWidth, 8, 'Kasasi', 1, 0, 'C', true);
        $pdf->Cell($colWidth, 8, 'Tidak Kasasi', 1, 0, 'C', true);
        $pdf->Cell($colWidth, 8, 'Putus Banding', 1, 1, 'C', true);

        // Data per bulan
        $pdf->SetFont('Arial', '', 9);
        foreach ($rekap_bulanan as $row) {
            $pdf->Cell($colWidth, 7, $row['nama_bulan'], 1, 0, 'C');
            $pdf->Cell($colWidth, 7, $row['jumlah_kasasi'], 1, 0, 'C');
            $pdf->Cell($colWidth, 7, $row['jumlah_tidak_kasasi'], 1, 0, 'C');
            $pdf->Cell($colWidth, 7, $row['jumlah_putus_banding'], 1, 1, 'C');
        }

        // Total
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetFillColor(255, 255, 200);
        $pdf->Cell($colWidth, 8, 'TOTAL', 1, 0, 'C', true);
        $pdf->Cell($colWidth, 8, $rekap_total['jumlah_kasasi'], 1, 0, 'C', true);
        $pdf->Cell($colWidth, 8, $rekap_total['jumlah_tidak_kasasi'], 1, 0, 'C', true);
        $pdf->Cell($colWidth, 8, $rekap_total['jumlah_putus_banding'], 1, 1, 'C', true);

        $filename = 'Laporan_Rekap_Perkara_' . $tahun;
        if ($bulan) {
            $filename .= '_' . $rekap_bulanan[0]['nama_bulan'];
        }
        $filename .= '.pdf';

        $pdf->Output('I', $filename);
    }

    public function cetak_rekap_excel()
    {
        $tahun = $this->input->get('tahun', TRUE) ?: date('Y');
        $bulan = $this->input->get('bulan', TRUE);

        // Get data based on filter
        if ($bulan) {
            $rekap_bulanan = $this->get_rekap_data_bulanan_filtered($tahun, $bulan);
            $judul = 'LAPORAN REKAP PERKARA PIDANA BANDING';
            $subjudul = 'Bulan ' . $rekap_bulanan[0]['nama_bulan'] . ' ' . $tahun;
            $filename = 'Laporan_Rekap_Perkara_' . $tahun . '_' . $rekap_bulanan[0]['nama_bulan'] . '.xls';
        } else {
            $rekap_bulanan = $this->get_rekap_data_bulanan($tahun);
            $judul = 'LAPORAN REKAP PERKARA PIDANA BANDING';
            $subjudul = 'Tahun ' . $tahun;
            $filename = 'Laporan_Rekap_Perkara_' . $tahun . '.xls';
        }

        // Calculate total
        $rekap_total = array(
            'jumlah_kasasi' => 0,
            'jumlah_tidak_kasasi' => 0,
            'jumlah_putus_banding' => 0
        );

        foreach ($rekap_bulanan as $data_bulan) {
            $rekap_total['jumlah_kasasi'] += $data_bulan['jumlah_kasasi'];
            $rekap_total['jumlah_tidak_kasasi'] += $data_bulan['jumlah_tidak_kasasi'];
            $rekap_total['jumlah_putus_banding'] += $data_bulan['jumlah_putus_banding'];
        }

        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=" . $filename);

        ob_start();
    ?>
        <html>

        <head>
            <style>
                table {
                    border-collapse: collapse;
                    width: 100%;
                    font-family: Arial, sans-serif;
                }

                th,
                td {
                    border: 1px solid #444;
                    padding: 8px;
                    text-align: center;
                }

                th {
                    background: #198754;
                    color: #fff;
                    font-weight: bold;
                }

                .total {
                    background: #fff2cc;
                    font-weight: bold;
                }

                .title {
                    background: #d4edda;
                    font-size: 16pt;
                    font-weight: bold;
                    padding: 15px;
                }

                .subtitle {
                    background: #f8f9fa;
                    font-size: 12pt;
                    font-weight: bold;
                    padding: 10px;
                }
            </style>
        </head>

        <body>
            <table>
                <tr>
                    <td colspan="4" class="title"><?= $judul ?></td>
                </tr>
                <tr>
                    <td colspan="4" class="subtitle"><?= $subjudul ?></td>
                </tr>
                <tr>
                    <th>Bulan</th>
                    <th>Kasasi (Lanjut)</th>
                    <th>Tidak Kasasi (Tidak Lanjut)</th>
                    <th>Putus Banding</th>
                </tr>
                <?php foreach ($rekap_bulanan as $row): ?>
                    <tr>
                        <td><?= $row['nama_bulan'] ?></td>
                        <td><?= $row['jumlah_kasasi'] ?></td>
                        <td><?= $row['jumlah_tidak_kasasi'] ?></td>
                        <td><?= $row['jumlah_putus_banding'] ?></td>
                    </tr>
                <?php endforeach; ?>
                <tr class="total">
                    <td><strong>TOTAL</strong></td>
                    <td><strong><?= $rekap_total['jumlah_kasasi'] ?></strong></td>
                    <td><strong><?= $rekap_total['jumlah_tidak_kasasi'] ?></strong></td>
                    <td><strong><?= $rekap_total['jumlah_putus_banding'] ?></strong></td>
                </tr>
            </table>
        </body>

        </html>
    <?php
        echo ob_get_clean();
    }

    private function get_rekap_data()
    {
        $query = $this->db->query("
            SELECT 
                SUM(CASE WHEN permohonan_kasasi IS NOT NULL AND permohonan_kasasi <> '' THEN 1 ELSE 0 END) AS jumlah_kasasi,
                SUM(CASE WHEN permohonan_kasasi IS NULL OR permohonan_kasasi = '' THEN 1 ELSE 0 END) AS jumlah_tidak_kasasi,
                SUM(CASE WHEN pemberitahuan_putusan_banding IS NOT NULL AND pemberitahuan_putusan_banding <> '' THEN 1 ELSE 0 END) AS jumlah_putus_banding
            FROM perkara_banding
        ");

        return $query->row_array();
    }

    private function get_rekap_data_bulanan($tahun)
    {
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

        $result = [];
        for ($bulan = 1; $bulan <= 12; $bulan++) {
            $bulan_format = sprintf('%02d', $bulan);

            $query = $this->db->query("
                SELECT 
                    SUM(CASE WHEN permohonan_kasasi IS NOT NULL AND permohonan_kasasi <> '' THEN 1 ELSE 0 END) AS jumlah_kasasi,
                    SUM(CASE WHEN permohonan_kasasi IS NULL OR permohonan_kasasi = '' THEN 1 ELSE 0 END) AS jumlah_tidak_kasasi,
                    SUM(CASE WHEN pemberitahuan_putusan_banding IS NOT NULL AND pemberitahuan_putusan_banding <> '' THEN 1 ELSE 0 END) AS jumlah_putus_banding
                FROM perkara_banding 
                WHERE YEAR(tgl_register_banding) = ? AND MONTH(tgl_register_banding) = ?
            ", [$tahun, $bulan]);

            $data = $query->row_array();
            $result[] = [
                'bulan' => $bulan_format,
                'nama_bulan' => $nama_bulan[$bulan_format],
                'jumlah_kasasi' => $data['jumlah_kasasi'] ?: 0,
                'jumlah_tidak_kasasi' => $data['jumlah_tidak_kasasi'] ?: 0,
                'jumlah_putus_banding' => $data['jumlah_putus_banding'] ?: 0
            ];
        }

        return $result;
    }

    private function get_rekap_data_bulanan_filtered($tahun, $bulan)
    {
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

        $query = $this->db->query("
            SELECT 
                SUM(CASE WHEN permohonan_kasasi IS NOT NULL AND permohonan_kasasi <> '' THEN 1 ELSE 0 END) AS jumlah_kasasi,
                SUM(CASE WHEN permohonan_kasasi IS NULL OR permohonan_kasasi = '' THEN 1 ELSE 0 END) AS jumlah_tidak_kasasi,
                SUM(CASE WHEN pemberitahuan_putusan_banding IS NOT NULL AND pemberitahuan_putusan_banding <> '' THEN 1 ELSE 0 END) AS jumlah_putus_banding
            FROM perkara_banding 
            WHERE YEAR(tgl_register_banding) = ? AND MONTH(tgl_register_banding) = ?
        ", [$tahun, $bulan]);

        $data = $query->row_array();

        return [[
            'bulan' => $bulan,
            'nama_bulan' => $nama_bulan[$bulan],
            'jumlah_kasasi' => $data['jumlah_kasasi'] ?: 0,
            'jumlah_tidak_kasasi' => $data['jumlah_tidak_kasasi'] ?: 0,
            'jumlah_putus_banding' => $data['jumlah_putus_banding'] ?: 0
        ]];
    }

    private function get_tahun_options()
    {
        $query = $this->db->query("
            SELECT DISTINCT YEAR(tgl_register_banding) as tahun 
            FROM perkara_banding 
            WHERE tgl_register_banding IS NOT NULL 
            ORDER BY tahun DESC
        ");

        $result = [];
        foreach ($query->result_array() as $row) {
            $result[] = $row['tahun'];
        }

        // Tambahkan tahun ini jika belum ada
        if (!in_array(date('Y'), $result)) {
            $result[] = date('Y');
            rsort($result);
        }

        return $result;
    }

    // =========================
    // Rekapitulasi Data (format sesuai gambar)
    // =========================
    public function rekapitulasi()
    {
        $tahun = $this->input->get('tahun', TRUE) ?: date('Y');

        // Get quarterly data breakdown by case type
        $data_triwulan = $this->get_rekapitulasi_data_triwulan($tahun);

        $data = [
            'tahun' => $tahun,
            'data_triwulan' => $data_triwulan
        ];

        $this->load->view('laporan/rekapitulasi', $data);
    }

    private function get_rekapitulasi_data_triwulan($tahun)
    {
        $triwulan_bulan = [
            1 => [1, 2, 3],    // Q1: Jan-Mar
            2 => [4, 5, 6],    // Q2: Apr-Jun
            3 => [7, 8, 9],    // Q3: Jul-Sep
            4 => [10, 11, 12]  // Q4: Oct-Dec
        ];

        $result = [];

        for ($tw = 1; $tw <= 4; $tw++) {
            $bulan_list = implode(',', $triwulan_bulan[$tw]);

            // PIDANA
            $pidana_query = $this->db->query("
                SELECT 
                    COUNT(*) as putus,
                    SUM(CASE WHEN permohonan_kasasi IS NOT NULL AND permohonan_kasasi <> '' THEN 1 ELSE 0 END) AS kasasi,
                    SUM(CASE WHEN permohonan_kasasi IS NULL OR permohonan_kasasi = '' THEN 1 ELSE 0 END) AS tidak_kasasi
                FROM perkara_banding 
                WHERE YEAR(tgl_register_banding) = ? 
                AND MONTH(tgl_register_banding) IN ($bulan_list)
                AND perkara = 'PIDANA'
            ", [$tahun]);
            $pidana_data = $pidana_query->row_array();

            // PERDATA
            $perdata_query = $this->db->query("
                SELECT 
                    COUNT(*) as putus,
                    SUM(CASE WHEN permohonan_kasasi IS NOT NULL AND permohonan_kasasi <> '' THEN 1 ELSE 0 END) AS kasasi,
                    SUM(CASE WHEN permohonan_kasasi IS NULL OR permohonan_kasasi = '' THEN 1 ELSE 0 END) AS tidak_kasasi
                FROM perkara_banding 
                WHERE YEAR(tgl_register_banding) = ? 
                AND MONTH(tgl_register_banding) IN ($bulan_list)
                AND perkara = 'PERDATA'
            ", [$tahun]);
            $perdata_data = $perdata_query->row_array();

            // ANAK
            $anak_query = $this->db->query("
                SELECT 
                    COUNT(*) as putus,
                    SUM(CASE WHEN permohonan_kasasi IS NOT NULL AND permohonan_kasasi <> '' THEN 1 ELSE 0 END) AS kasasi,
                    SUM(CASE WHEN permohonan_kasasi IS NULL OR permohonan_kasasi = '' THEN 1 ELSE 0 END) AS tidak_kasasi
                FROM perkara_banding 
                WHERE YEAR(tgl_register_banding) = ? 
                AND MONTH(tgl_register_banding) IN ($bulan_list)
                AND perkara = 'ANAK'
            ", [$tahun]);
            $anak_data = $anak_query->row_array();

            // TIPIKOR
            $tipikor_query = $this->db->query("
                SELECT 
                    COUNT(*) as putus,
                    SUM(CASE WHEN permohonan_kasasi IS NOT NULL AND permohonan_kasasi <> '' THEN 1 ELSE 0 END) AS kasasi,
                    SUM(CASE WHEN permohonan_kasasi IS NULL OR permohonan_kasasi = '' THEN 1 ELSE 0 END) AS tidak_kasasi
                FROM perkara_banding 
                WHERE YEAR(tgl_register_banding) = ? 
                AND MONTH(tgl_register_banding) IN ($bulan_list)
                AND perkara = 'TIPIKOR'
            ", [$tahun]);
            $tipikor_data = $tipikor_query->row_array();

            $result[$tw] = [
                'pidana_putus' => $pidana_data['putus'] ?: 0,
                'pidana_kasasi' => $pidana_data['kasasi'] ?: 0,
                'pidana_tidak_kasasi' => $pidana_data['tidak_kasasi'] ?: 0,
                'perdata_putus' => $perdata_data['putus'] ?: 0,
                'perdata_kasasi' => $perdata_data['kasasi'] ?: 0,
                'perdata_tidak_kasasi' => $perdata_data['tidak_kasasi'] ?: 0,
                'anak_putus' => $anak_data['putus'] ?: 0,
                'anak_kasasi' => $anak_data['kasasi'] ?: 0,
                'anak_tidak_kasasi' => $anak_data['tidak_kasasi'] ?: 0,
                'tipikor_putus' => $tipikor_data['putus'] ?: 0,
                'tipikor_kasasi' => $tipikor_data['kasasi'] ?: 0,
                'tipikor_tidak_kasasi' => $tipikor_data['tidak_kasasi'] ?: 0
            ];
        }

        return $result;
    }

    public function cetak_rekapitulasi_excel()
    {
        $tahun = $this->input->get('tahun', TRUE) ?: date('Y');
        $data_triwulan = $this->get_rekapitulasi_data_triwulan($tahun);

        $filename = 'Rekapitulasi_Data_Perkara_' . $tahun . '.xls';

        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=" . $filename);

        ob_start();
    ?>
        <html>

        <head>
            <style>
                table {
                    border-collapse: collapse;
                    width: 100%;
                    font-family: Arial, sans-serif;
                }

                th,
                td {
                    border: 1px solid #000;
                    padding: 5px;
                    text-align: center;
                    font-size: 10pt;
                }

                th {
                    background: #f0f0f0;
                    font-weight: bold;
                }

                .title {
                    background: #d4edda;
                    font-size: 14pt;
                    font-weight: bold;
                    padding: 10px;
                }

                .total-row {
                    background: #fff3cd;
                    font-weight: bold;
                }
            </style>
        </head>

        <body>
            <table>
                <tr>
                    <td colspan="18" class="title">REKAPITULASI DATA PERKARA YANG TIDAK MENGAJUKAN UPAYA HUKUM KASASI</td>
                </tr>
                <tr>
                    <td colspan="18" class="title">PENGADILAN TINGGI BANJARMASIN</td>
                </tr>
                <tr>
                    <td colspan="18" class="title">TAHUN <?= $tahun ?></td>
                </tr>
                <tr>
                    <th rowspan="3">TRIWULAN</th>
                    <th colspan="3">PIDANA</th>
                    <th colspan="3">PERDATA</th>
                    <th colspan="3">ANAK</th>
                    <th colspan="3">TIPIKOR</th>
                    <th colspan="3">TOTAL</th>
                    <th colspan="2">%</th>
                </tr>
                <tr>
                    <th>PUTUS</th>
                    <th>KASASI</th>
                    <th>TIDAK KASASI</th>
                    <th>PUTUS</th>
                    <th>KASASI</th>
                    <th>TIDAK KASASI</th>
                    <th>PUTUS</th>
                    <th>KASASI</th>
                    <th>TIDAK KASASI</th>
                    <th>PUTUS</th>
                    <th>KASASI</th>
                    <th>TIDAK KASASI</th>
                    <th>PUTUS</th>
                    <th>KASASI</th>
                    <th>TIDAK KASASI</th>
                    <th>KASASI</th>
                    <th>TIDAK KASASI</th>
                </tr>

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
                        <td><?= $triwulan_names[$tw - 1] ?></td>
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
                        <td><?= $total_putus ?></td>
                        <td><?= $total_kasasi ?></td>
                        <td><?= $total_tidak_kasasi ?></td>
                        <!-- PERSENTASE -->
                        <td><?= $persen_kasasi ?></td>
                        <td><?= $persen_tidak_kasasi ?></td>
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
            </table>
        </body>

        </html>
<?php
        echo ob_get_clean();
    }

    // =========================
    // Helper
    // =========================
    private function getMultiCellHeight($w, $txt)
    {
        $cw = $w - 4;
        $chars = floor($cw * 1.8);
        $lines = explode("\n", wordwrap($txt, $chars, "\n", true));
        return count($lines) * 6;
    }

    private function multiCellColumn($pdf, $w, $txt, $align = 'L')
    {
        $x = $pdf->GetX();
        $y = $pdf->GetY();
        $pdf->MultiCell($w, 6, $txt, 1, $align);
        $pdf->SetXY($x + $w, $y);
    }
}
