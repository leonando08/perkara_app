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

        // cek login
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }

        // FPDF ada di application/third_party/fpdf.php
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

        // Judul laporan
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

        // Buat PDF
        $pdf = new FPDF('L', 'mm', 'A4');
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 10, $judul, 0, 1, 'C');
        $pdf->Ln(5);

        // Header tabel
        $pdf->SetFont('Arial', 'B', 8);
        $header = [
            'No' => 8,
            'Asal Pengadilan' => 28,
            'Nomor Tk1' => 28,
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

        // Isi tabel
        $pdf->SetFont('Arial', '', 8);
        $no = 1;
        if (!empty($perkaras)) {
            foreach ($perkaras as $row) {
                // Hitung tinggi maksimal baris
                $heights = [
                    6,
                    $this->getMultiCellHeight($header['Asal Pengadilan'], $row->asal_pengadilan),
                    $this->getMultiCellHeight($header['Nomor Tk1'], $row->nomor_perkara_tk1),
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

                // Kolom No
                $pdf->Cell($header['No'], $maxHeight, $no++, 1, 0, 'C');

                // Kolom Asal Pengadilan
                $this->multiCellColumn($pdf, $header['Asal Pengadilan'], $row->asal_pengadilan);

                // Kolom Nomor Tk1
                $this->multiCellColumn($pdf, $header['Nomor Tk1'], $row->nomor_perkara_tk1);

                // Kolom Klasifikasi
                $this->multiCellColumn($pdf, $header['Klasifikasi'], $row->klasifikasi);

                // Kolom Tgl Register
                $pdf->Cell(
                    $header['Tgl Register'],
                    $maxHeight,
                    !empty($row->tgl_register_banding) ? date('d-m-Y', strtotime($row->tgl_register_banding)) : '-',
                    1,
                    0,
                    'C'
                );

                // Kolom Nomor Banding
                $this->multiCellColumn($pdf, $header['Nomor Banding'], $row->nomor_perkara_banding);

                // Kolom Lama Proses
                $pdf->Cell($header['Lama Proses'], $maxHeight, $row->lama_proses, 1, 0, 'C');

                // Kolom Status Tk Banding
                $this->multiCellColumn($pdf, $header['Status Tk Banding'], $row->status_perkara_tk_banding);

                // Kolom tanggal-tanggal
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

                // Kolom Status
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
    // Ekspor Excel (HTML table)
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
                @page {
                    size: A4 landscape;
                    margin: 0.5cm;
                }

                body {
                    font-family: Arial, sans-serif;
                    font-size: 9pt;
                }

                h2 {
                    font-size: 14pt;
                    text-align: center;
                    margin-bottom: 5px;
                }

                p {
                    margin: 2px 0;
                    font-size: 9pt;
                }

                table {
                    border-collapse: collapse;
                    width: 100%;
                    margin-top: 5px;
                    table-layout: fixed;
                }

                th,
                td {
                    border: 1px solid black;
                    padding: 4px;
                    font-size: 8pt;
                    word-wrap: break-word;
                }

                th {
                    background: #f2f2f2;
                    font-weight: bold;
                    text-align: center;
                }

                .shrink {
                    zoom: 70%;
                }
            </style>
        </head>

        <body>
            <h2>Laporan Perkara</h2>
            <?php if (!empty($filters['bulan'])): ?>
                <p>Bulan: <?= date("F Y", strtotime($filters['bulan'] . '-01')) ?></p>
            <?php endif; ?>
            <?php if (!empty($filters['asal_pengadilan'])): ?>
                <p>Asal Pengadilan: <?= $filters['asal_pengadilan'] ?></p>
            <?php endif; ?>
            <?php if (!empty($filters['klasifikasi'])): ?>
                <p>Klasifikasi: <?= $filters['klasifikasi'] ?></p>
            <?php endif; ?>
            <?php if (!empty($filters['status'])): ?>
                <p>Status: <?= $filters['status'] ?></p>
            <?php endif; ?>

            <div class="shrink">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
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
                        <?php if (!empty($perkaras)): ?>
                            <?php $no = 1;
                            foreach ($perkaras as $row): ?>
                                <tr>
                                    <td align="center"><?= $no++ ?></td>
                                    <td><?= $row->asal_pengadilan ?></td>
                                    <td><?= $row->nomor_perkara_tk1 ?></td>
                                    <td><?= $row->klasifikasi ?></td>
                                    <td align="center"><?= !empty($row->tgl_register_banding) ? date("d-m-Y", strtotime($row->tgl_register_banding)) : '-' ?></td>
                                    <td><?= $row->nomor_perkara_banding ?></td>
                                    <td align="center"><?= $row->lama_proses ?></td>
                                    <td><?= $row->status_perkara_tk_banding ?></td>
                                    <td align="center"><?= !empty($row->pemberitahuan_putusan_banding) ? date("d-m-Y", strtotime($row->pemberitahuan_putusan_banding)) : '-' ?></td>
                                    <td align="center"><?= !empty($row->permohonan_kasasi) ? date("d-m-Y", strtotime($row->permohonan_kasasi)) : '-' ?></td>
                                    <td align="center"><?= !empty($row->pengiriman_berkas_kasasi) ? date("d-m-Y", strtotime($row->pengiriman_berkas_kasasi)) : '-' ?></td>
                                    <td align="center" style="font-weight:bold;"><?= $row->status ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="12" align="center">Tidak ada data perkara</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </body>

        </html>
<?php
        $html = ob_get_clean();
        echo $html;
    }

    // =========================
    // Helper function
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
