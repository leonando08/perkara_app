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
        $this->load->helper('url'); // supaya site_url(), base_url() bisa dipakai
        $this->load->library('session');

        // cek login
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }

        // FPDF ada di application/third_party/fpdf.php
        require_once(APPPATH . 'third_party/fpdf.php');
    }

    // Halaman laporan
    public function index()
    {
        // Ambil filter dari GET, aman dengan XSS filter
        $filters = [
            'bulan'           => $this->input->get('bulan', TRUE),
            'asal_pengadilan' => $this->input->get('asal_pengadilan', TRUE),
            'klasifikasi'     => $this->input->get('klasifikasi', TRUE),
            'status'          => $this->input->get('status', TRUE)
        ];

        $useFilter = array_filter($filters); // cek jika ada filter yg diisi

        if ($useFilter) {
            $data['perkaras'] = $this->Perkara_model->get_filtered($filters);
        } else {
            $data['perkaras'] = $this->Perkara_model->get_all();
        }

        $data['filters'] = $filters;

        $this->load->view('navbar/header');
        $this->load->view('laporan/laporan', $data); // folder laporan/laporan.php
        $this->load->view('navbar/footer');
    }

    // Method untuk cetak laporan PDF
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

        // Set fill warna header abu muda
        $pdf->SetFillColor(200, 200, 200);
        foreach ($header as $h => $w) {
            $pdf->Cell($w, 7, $h, 1, 0, 'C', true);
        }
        $pdf->Ln();

        // Isi tabel
        // Isi tabel
        $pdf->SetFont('Arial', '', 6); // ukuran font lebih kecil supaya muat
        $no = 1;
        if (!empty($perkaras)) {
            foreach ($perkaras as $row) {
                $pdf->Cell(8, 6, $no++, 1);
                $pdf->Cell(28, 6, substr($row->asal_pengadilan, 0, 20), 1); // potong teks terlalu panjang
                $pdf->Cell(28, 6, substr($row->nomor_perkara_tk1, 0, 20), 1);
                $pdf->Cell(25, 6, substr($row->klasifikasi, 0, 15), 1);
                $pdf->Cell(20, 6, !empty($row->tgl_register_banding) ? date('d-m-Y', strtotime($row->tgl_register_banding)) : '-', 1);
                $pdf->Cell(28, 6, substr($row->nomor_perkara_banding, 0, 20), 1);
                $pdf->Cell(18, 6, $row->lama_proses, 1);
                $pdf->Cell(30, 6, substr($row->status_perkara_tk_banding, 0, 18), 1);
                $pdf->Cell(30, 6, !empty($row->pemberitahuan_putusan_banding) ? date('d-m-Y', strtotime($row->pemberitahuan_putusan_banding)) : '-', 1);
                $pdf->Cell(25, 6, !empty($row->permohonan_kasasi) ? date('d-m-Y', strtotime($row->permohonan_kasasi)) : '-', 1);
                $pdf->Cell(25, 6, !empty($row->pengiriman_berkas_kasasi) ? date('d-m-Y', strtotime($row->pengiriman_berkas_kasasi)) : '-', 1);
                $pdf->Cell(20, 6, substr($row->status, 0, 15), 1);
                $pdf->Ln();
            }
        } else {
            $pdf->Cell(array_sum($header), 6, 'Tidak ada data perkara', 1, 1, 'C');
        }


        $pdf->Output('I', 'Laporan_Perkara.pdf');
    }
}
