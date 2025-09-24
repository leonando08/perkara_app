<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_Session $session
 * @property CI_Input $input
 * @property CI_DB_query_builder $db
 * @property Perkara_model $Perkara_model
 */
class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Load library, helper, dan model
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->model('Perkara_model');

        // Cek login & role admin
        if ($this->session->userdata('role') !== 'admin') {
            redirect('auth/login'); // arahkan ke halaman login
        }
    }

    public function dashboard_admin()
    {
        $data = [
            'username'   => $this->session->userdata('username'),
            'perkaras'   => $this->Perkara_model->get_all(), // method sudah ada di model
            'notif'      => $this->Perkara_model->count_besok(),
            'terlambat'  => $this->Perkara_model->count_terlambat()
        ];

        $this->load->view('admin/dashboard_admin', $data);
    }
}
