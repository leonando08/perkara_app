<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_Session $session
 * @property CI_Input $input
 * @property CI_DB_query_builder $db
 * @property User_model $User_model
 */
class Kelola_user extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->helper('url'); // ✅ supaya redirect & site_url aman

        // 🔒 cek login
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }

        // 🔒 cek role admin
        if ($this->session->userdata('role') !== 'admin') {
            redirect('dashboard_user');
        }
    }

    public function index()
    {
        $data['users'] = $this->User_model->get_all();

        $this->load->view('navbar/header');
        $this->load->view('admin/kelola_user', $data);
        $this->load->view('navbar/footer');
    }

    public function add()
    {
        // ✅ validasi sederhana
        if ($this->input->post()) {
            $data = [
                'username' => $this->input->post('username', true),
                'password' => password_hash($this->input->post('password', true), PASSWORD_DEFAULT),
                'role'     => $this->input->post('role', true),
            ];
            $this->User_model->insert($data);
        }
        redirect('kelola_user');
    }

    public function edit($id)
    {
        if ($this->input->post()) {
            $data = [
                'username' => $this->input->post('username', true),
                'role'     => $this->input->post('role', true),
            ];

            // ✅ update password hanya jika diisi
            if (!empty($this->input->post('password'))) {
                $data['password'] = password_hash($this->input->post('password', true), PASSWORD_DEFAULT);
            }

            $this->User_model->update($id, $data);
        }
        redirect('kelola_user');
    }

    public function delete($id)
    {
        if (!empty($id)) {
            $this->User_model->delete($id);
        }
        redirect('kelola_user');
    }
}
