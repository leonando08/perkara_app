<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * @property CI_Session $session
 * @property CI_Input $input
 * @property CI_DB_query_builder $db
 * @property User_model $User_model
 */
class Dashboard_admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
        $this->load->helper('url');

        // Proteksi halaman hanya untuk admin
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') !== 'admin') {
            redirect('auth/login');
        }
    }

    public function index()
    {
        // Data user
        $data['username'] = $this->session->userdata('username');

        // Notifikasi permohonan kasasi besok
        $besok = date('Y-m-d', strtotime('+1 day'));
        $data['notif'] = $this->db
            ->where('permohonan_kasasi', $besok)
            ->where('status', 'Proses')
            ->get('perkara_banding')
            ->num_rows();

        // Notifikasi terlambat
        $hariIni = date('Y-m-d');
        $data['terlambat'] = $this->db
            ->where('permohonan_kasasi <', $hariIni)
            ->where('status', 'Proses')
            ->get('perkara_banding')
            ->num_rows();

        // Ambil semua data perkara
        $data['perkaras'] = $this->db->order_by('id', 'ASC')->get('perkara_banding')->result_array();

        $this->load->view('admin/dashboard_admin', $data);
    }
}
