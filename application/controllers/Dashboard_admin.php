<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * @property CI_Session $session
 * @property CI_Input $input
 * @property CI_DB_query_builder $db
 * @property User_model $User_model
 * @property Perkara_model $Perkara_model
 */
class Dashboard_admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->model('Perkara_model');

        // Proteksi halaman hanya untuk admin
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') !== 'admin') {
            redirect('auth/login');
        }
    }

    public function index()
    {
        // Data user
        $data['username'] = $this->session->userdata('username');

        // Notifikasi permohonan kasasi besok (menggunakan model)
        $data['notif'] = $this->Perkara_model->count_besok();

        // Notifikasi terlambat (menggunakan model)
        $data['terlambat'] = $this->Perkara_model->count_terlambat();

        // Ambil data perkara dengan filter (menggunakan model yang sudah ada filter pengadilan)
        $filters = [
            'perkara' => $this->input->get('perkara'),
            'asal_pengadilan' => $this->input->get('cari_pengadilan'),
            'status' => $this->input->get('status')
        ];

        $data['perkaras'] = $this->Perkara_model->get_filtered($filters);

        $this->load->view('admin/dashboard_admin', $data);
    }

    public function grafik_perkara_bulanan()
    {
        // Proteksi hanya untuk admin
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') !== 'admin') {
            redirect('auth/login');
        }
        $tahun = $this->input->get('tahun') ?: date('Y');
        $data['tahun'] = $tahun;
        $data['grafik'] = $this->Perkara_model->get_jumlah_perkara_per_bulan($tahun);
        $this->load->view('admin/grafik_perkara_bulanan', $data);
    }
}
