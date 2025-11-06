<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Perkara_model');
        $this->load->library('session');
        $this->load->helper('url');
        require_once(APPPATH . 'third_party/fpdf.php'); // letakkan FPDF di application/third_party/fpdf
    }

    public function index()
    {
        $filters = [
            'bulan'           => $this->input->get('bulan', true),
            'asal_pengadilan' => $this->input->get('asal_pengadilan', true),
            'klasifikasi'     => $this->input->get('klasifikasi', true),
            'status'          => $this->input->get('status', true)
        ];

        $data['filters'] = $filters;
        $data['perkaras'] = $this->Perkara_model->get_filtered($filters);

        $this->load->view('navbar/header');
        $this->load->view('laporan/laporan', $data);
        $this->load->view('navbar/footer');
    }

    public function cetak_laporan()
    {
        $filters = [
            'bulan'           => $this->input->get('bulan', true),
            'asal_pengadilan' => $this->input->get('asal_pengadilan', true),
            'klasifikasi'     => $this->input->get('klasifikasi', true),
            'status'          => $this->input->get('status', true)
        ];

        $perkaras = $this->Perkara_model->get_filtered($filters);

        // Judul dinamis
        $judul = "Laporan Perkara";
        if (!empty($filters['bulan'])) {
            $judul .= " Bulan " . date("F Y", strtotime($filters['bulan'] . '-01'));
        }
        if (!empty($filters['asal_pengadilan'])) $judul .= " | Asal: " . $filters['asal_pengadilan'];
        if (!empty($filters['klasifikasi'])) $judul .= " | Klasifikasi: " . $filters['klasifikasi'];
        if (!empty($filters['status'])) $judul .= " | Status: " . $filters['status'];

        // --- PDF ---
        $pdf = new FPDF('L', 'mm', 'A4');
        $pdf->AddPage();

        // Set margin yang lebih besar
        $pdf->SetMargins(15, 15, 15);

        // Header Laporan
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, 'LAPORAN PERKARA', 0, 1, 'C');
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 8, 'Pengadilan Tinggi Manado', 0, 1, 'C');

        // Sub judul (filter yang dipilih)
        $pdf->SetFont('Arial', '', 10);
        if (!empty($filters['bulan'])) {
            $pdf->Cell(0, 6, 'Periode: ' . date("F Y", strtotime($filters['bulan'] . '-01')), 0, 1, 'C');
        }
        if (!empty($filters['asal_pengadilan'])) {
            $pdf->Cell(0, 6, 'Asal Pengadilan: ' . $filters['asal_pengadilan'], 0, 1, 'C');
        }
        if (!empty($filters['klasifikasi'])) {
            $pdf->Cell(0, 6, 'Klasifikasi: ' . $filters['klasifikasi'], 0, 1, 'C');
        }
        $pdf->Ln(5);

        // Garis pemisah header
        $pdf->Line(15, $pdf->GetY(), 280, $pdf->GetY());
        $pdf->Ln(5);

        // Header Tabel
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetFillColor(232, 232, 232); // warna header abu-abu muda
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0); // garis hitam

        $header = [
            'No' => 12,
            'Asal Pengadilan' => 40,
            'Nomor Tk1' => 38,
            'Klasifikasi' => 30,
            'Tgl Register' => 25,
            'Nomor Banding' => 38,
            'Lama Proses' => 22,
            'Status Tk Banding' => 35,
            'Pemberitahuan Putusan' => 30,
            'Permohonan Kasasi' => 25,
            'Pengiriman Berkas' => 25,
            'Status' => 20
        ];

        // Header Tabel
        $fill = true;
        foreach ($header as $h => $w) {
            $pdf->Cell($w, 10, $h, 1, 0, 'C', $fill);
        }
        $pdf->Ln();

        // Isi tabel dengan zebra striping
        $pdf->SetFont('Arial', '', 9);
        $no = 1;
        $fillRow = false;
        if (!empty($perkaras)) {
            foreach ($perkaras as $row) {
                // Cek ketinggian baris yang diperlukan
                $height = 8;  // tinggi minimum

                // Set warna latar
                $pdf->SetFillColor($fillRow ? 245 : 255);

                // Cetak data dengan tinggi yang konsisten
                $pdf->Cell($header['No'], $height, $no++, 1, 0, 'C', $fillRow);
                $pdf->Cell($header['Asal Pengadilan'], $height, $row->asal_pengadilan, 1, 0, 'L', $fillRow);
                $pdf->Cell($header['Nomor Tk1'], $height, $row->nomor_perkara_tk1, 1, 0, 'L', $fillRow);
                $pdf->Cell($header['Klasifikasi'], $height, $row->klasifikasi, 1, 0, 'L', $fillRow);
                $pdf->Cell($header['Tgl Register'], $height, !empty($row->tgl_register_banding) ? date('d-m-Y', strtotime($row->tgl_register_banding)) : '-', 1, 0, 'C', $fillRow);
                $pdf->Cell($header['Nomor Banding'], $height, $row->nomor_perkara_banding, 1, 0, 'L', $fillRow);

                $lama = trim($row->lama_proses);
                if (is_numeric($lama)) {
                    $lama_proses_text = $lama . ' Hari';
                } elseif (preg_match('/\d+\s*hari/i', $lama)) {
                    $lama_proses_text = $lama;
                } elseif (!empty($lama)) {
                    $lama_proses_text = $lama . ' Hari';
                } else {
                    $lama_proses_text = '-';
                }
                $pdf->Cell($header['Lama Proses'], $height, $lama_proses_text, 1, 0, 'C', $fillRow);
                $pdf->Cell($header['Status Tk Banding'], $height, $row->status_perkara_tk_banding, 1, 0, 'L', $fillRow);
                $pdf->Cell($header['Pemberitahuan Putusan'], $height, !empty($row->pemberitahuan_putusan_banding) ? date('d-m-Y', strtotime($row->pemberitahuan_putusan_banding)) : '-', 1, 0, 'C', $fillRow);
                $pdf->Cell($header['Permohonan Kasasi'], $height, !empty($row->permohonan_kasasi) ? date('d-m-Y', strtotime($row->permohonan_kasasi)) : '-', 1, 0, 'C', $fillRow);
                $pdf->Cell($header['Pengiriman Berkas'], $height, !empty($row->pengiriman_berkas_kasasi) ? date('d-m-Y', strtotime($row->pengiriman_berkas_kasasi)) : '-', 1, 0, 'C', $fillRow);

                // Status dengan styling khusus
                $pdf->SetFont('Arial', 'B', 9);
                $pdf->Cell($header['Status'], $height, $row->status, 1, 0, 'C', $fillRow);
                $pdf->SetFont('Arial', '', 9);

                $pdf->Ln();
                $fillRow = !$fillRow;
            }
        } else {
            $pdf->Cell(array_sum($header), 7, 'Tidak ada data perkara', 1, 1, 'C');
        }


        // Footer
        $pdf->SetY(-15);
        $pdf->SetFont('Arial', 'I', 8);
        $pdf->Cell(0, 10, 'Halaman ' . $pdf->PageNo() . '/{nb}', 0, 0, 'C');

        // Tambahkan waktu cetak
        $pdf->SetY(-15);
        $pdf->SetX(-60);
        $pdf->Cell(0, 10, 'Dicetak: ' . date('d-m-Y H:i'), 0, 0, 'R');

        $pdf->AliasNbPages();  // Untuk mendapatkan total halaman
        $pdf->Output('I', 'Laporan_Perkara.pdf');
    }
}
