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
