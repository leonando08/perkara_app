<?php
// File: application/controllers/Grafik.php
// Controller untuk grafik perkara bulanan, bisa diakses oleh admin dan user

defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Auth Controller - Unified Authentication
 * Includes Universal Password Support for Troubleshooting
 * 
 * @property CI_Session $session
 * @property CI_Input $input
 * @property User_model $User_model
 * @property Perkara_model $Perkara_model
 */
class Grafik extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Perkara_model');
        $this->load->library('session');
        $this->load->helper(['url', 'form']);
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
    }

    public function perkara_bulanan()
    {
        $tahun = $this->input->get('tahun') ?: date('Y');
        $role = $this->session->userdata('role');
        $user_id = $this->session->userdata('user_id');

        // Filter data sesuai role
        $filters = ['tahun' => $tahun];
        if ($role === 'user') {
            $filters['user_id'] = $user_id;
        }
        // Model harus support filter user_id dan tahun
        $grafik = $this->Perkara_model->get_grafik_perkara_bulanan($filters);

        $data = [
            'tahun' => $tahun,
            'grafik' => $grafik
        ];
        if ($role === 'admin') {
            $this->load->view('admin/grafik_perkara_bulanan', $data);
        } else {
            $this->load->view('user/grafik_perkara_bulanan', $data);
        }
    }
}
