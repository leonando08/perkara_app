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
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 10, $judul, 0, 1, 'C');
        $pdf->Ln(5);

        // Header
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->SetFillColor(200, 220, 255); // warna header biru lembut
        $pdf->SetTextColor(0, 0, 0); // teks hitam
        $pdf->SetDrawColor(50, 50, 50); // garis abu gelap

        $header = [
            'No' => 10,
            'Asal Pengadilan' => 35,
            'Nomor Tk1' => 35,
            'Klasifikasi' => 35,
            'Tgl Register' => 25,
            'Nomor Banding' => 35,
            'Lama Proses' => 20,
            'Status Tk Banding' => 35,
            'Pemberitahuan Putusan' => 35,
            'Permohonan Kasasi' => 25,
            'Pengiriman Berkas' => 25,
            'Status' => 20
        ];

        // Header
        $fill = true;
        foreach ($header as $h => $w) {
            $pdf->Cell($w, 8, $h, 1, 0, 'C', $fill);
        }
        $pdf->Ln();

        // Isi tabel dengan zebra striping
        $pdf->SetFont('Arial', '', 8);
        $no = 1;
        $fillRow = false;
        if (!empty($perkaras)) {
            foreach ($perkaras as $row) {
                $pdf->SetFillColor($fillRow ? 240 : 255); // baris selang-seling
                $pdf->Cell(10, 7, $no++, 1, 0, 'C', $fillRow);
                $pdf->Cell(35, 7, $row->asal_pengadilan, 1, 0, 'L', $fillRow);
                $pdf->Cell(35, 7, $row->nomor_perkara_tk1, 1, 0, 'L', $fillRow);
                $pdf->Cell(35, 7, $row->klasifikasi, 1, 0, 'L', $fillRow);
                $pdf->Cell(25, 7, !empty($row->tgl_register_banding) ? date('d-m-Y', strtotime($row->tgl_register_banding)) : '-', 1, 0, 'C', $fillRow);
                $pdf->Cell(35, 7, $row->nomor_perkara_banding, 1, 0, 'L', $fillRow);
                $pdf->Cell(20, 7, $row->lama_proses, 1, 0, 'C', $fillRow);
                $pdf->Cell(35, 7, $row->status_perkara_tk_banding, 1, 0, 'L', $fillRow);
                $pdf->Cell(35, 7, !empty($row->pemberitahuan_putusan_banding) ? date('d-m-Y', strtotime($row->pemberitahuan_putusan_banding)) : '-', 1, 0, 'C', $fillRow);
                $pdf->Cell(25, 7, !empty($row->permohonan_kasasi) ? date('d-m-Y', strtotime($row->permohonan_kasasi)) : '-', 1, 0, 'C', $fillRow);
                $pdf->Cell(25, 7, !empty($row->pengiriman_berkas_kasasi) ? date('d-m-Y', strtotime($row->pengiriman_berkas_kasasi)) : '-', 1, 0, 'C', $fillRow);
                $pdf->Cell(20, 7, $row->status, 1, 0, 'C', $fillRow);
                $pdf->Ln();
                $fillRow = !$fillRow; // toggle warna baris
            }
        } else {
            $pdf->Cell(array_sum($header), 7, 'Tidak ada data perkara', 1, 1, 'C');
        }


        $pdf->Output('I', 'Laporan_Perkara.pdf');
    }
}
