<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_Session $session
 * @property CI_Input $input
 * @property CI_DB_query_builder $db
 * @property CI_Form_validation $form_validation
 * @property Perkara_model $Perkara_model
 * @property User_model $User_model
 */
class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Load library, helper, dan model
        $this->load->library(['session', 'form_validation']);
        $this->load->helper(['url', 'form']);
        $this->load->model(['Perkara_model', 'User_model']);

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

    public function kelola_user()
    {
        // Ambil semua data user
        $data['users'] = $this->User_model->get_all();
        $data['username'] = $this->session->userdata('username');

        $this->load->view('admin/kelola_user', $data);
    }

    public function tambah_user()
    {
        $data['error'] = '';
        $data['success'] = '';

        if ($this->input->post()) {
            // Set validation rules
            $this->form_validation->set_rules('username', 'Username', 'required|min_length[3]|is_unique[users.username]');
            $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
            $this->form_validation->set_rules('confirm_password', 'Konfirmasi Password', 'required|matches[password]');
            $this->form_validation->set_rules('role', 'Role', 'required|in_list[admin,user]');

            if ($this->form_validation->run() == TRUE) {
                $username = $this->input->post('username', TRUE);
                $password = $this->input->post('password', TRUE);
                $role = $this->input->post('role', TRUE);

                // Hash password
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                $user_data = [
                    'username' => $username,
                    'password' => $hashed_password,
                    'role' => $role
                ];

                if ($this->User_model->add($user_data)) {
                    $data['success'] = "User berhasil ditambahkan!";
                    // Reset form data
                    $_POST = array();
                } else {
                    $data['error'] = "Gagal menambahkan user. Silakan coba lagi.";
                }
            } else {
                $data['error'] = validation_errors();
            }
        }

        $this->load->view('admin/tambah_user', $data);
    }

    public function edit_user($id)
    {
        $data['error'] = '';
        $data['success'] = '';

        // Ambil data user berdasarkan ID
        $data['user'] = $this->User_model->get_by_id($id);

        if (!$data['user']) {
            show_404();
        }

        if ($this->input->post()) {
            // Set validation rules
            $this->form_validation->set_rules('username', 'Username', 'required|min_length[3]');
            $this->form_validation->set_rules('role', 'Role', 'required|in_list[admin,user]');

            // Password optional for edit
            if ($this->input->post('password')) {
                $this->form_validation->set_rules('password', 'Password', 'min_length[6]');
                $this->form_validation->set_rules('confirm_password', 'Konfirmasi Password', 'matches[password]');
            }

            if ($this->form_validation->run() == TRUE) {
                $username = $this->input->post('username', TRUE);
                $role = $this->input->post('role', TRUE);

                $user_data = [
                    'username' => $username,
                    'role' => $role
                ];

                // Update password jika diisi
                if ($this->input->post('password')) {
                    $user_data['password'] = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
                }

                if ($this->User_model->update($id, $user_data)) {
                    $data['success'] = "User berhasil diupdate!";
                    $data['user'] = $this->User_model->get_by_id($id); // Reload data
                } else {
                    $data['error'] = "Gagal mengupdate user. Silakan coba lagi.";
                }
            } else {
                $data['error'] = validation_errors();
            }
        }

        $this->load->view('admin/edit_user', $data);
    }

    public function hapus_user($id)
    {
        // Tidak bisa hapus diri sendiri
        if ($id == $this->session->userdata('user_id')) {
            $this->session->set_flashdata('error', 'Tidak dapat menghapus akun sendiri!');
            redirect('admin/kelola_user');
        }

        $user = $this->User_model->get_by_id($id);
        if (!$user) {
            show_404();
        }

        if ($this->User_model->delete($id)) {
            $this->session->set_flashdata('success', 'User berhasil dihapus!');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus user!');
        }

        redirect('admin/kelola_user');
    }
}
