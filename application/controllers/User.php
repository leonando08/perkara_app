<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * @property Perkara_model $Perkara_model
 * @property CI_Session $session
 * @property CI_Input $input
 * @property CI_DB_query_builder $db
 */
class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Perkara_model');
        $this->load->library('session');
        $this->load->helper('url');

        // Hanya user yang bisa akses
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') != 'user') {
            redirect('auth/login');
        }
    }

    public function dashboard_user()
    {
        // Ambil data sesuai kebutuhan user
        $data['perkaras'] = $this->Perkara_model->get_all();
        $this->load->view('user/dashboard_user', $data);
    }
}
