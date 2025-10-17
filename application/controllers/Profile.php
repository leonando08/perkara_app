<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_Session $session
 * @property CI_Input $input
 * @property CI_DB_query_builder $db
 * @property User_model $User_model
 * @property CI_Form_validation $form_validation
 * @property CI_Upload $upload
 */

class Profile extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library(['session', 'form_validation', 'upload']);
        $this->load->helper(['url', 'form', 'security']);

        // Check if user is logged in
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
    }

    public function debug()
    {
        echo "<h1>Profile Controller Debug</h1>";
        echo "<p>Controller loaded successfully!</p>";
        echo "<p>Session data:</p>";
        echo "<pre>";
        print_r($this->session->userdata());
        echo "</pre>";

        echo "<p>Test links:</p>";
        echo '<a href="' . base_url('profile') . '">Profile Index</a><br>';
        echo '<a href="' . base_url('profile/edit') . '">Profile Edit</a><br>';
        echo '<a href="' . base_url('profile/change_password') . '">Change Password</a><br>';
    }

    public function index()
    {
        $user_id = $this->session->userdata('user_id');
        $data['user'] = $this->User_model->get_by_id($user_id);
        $data['title'] = 'Profil Pengguna';

        // Load header dan view
        $this->load->view('navbar/header', $data);
        $this->load->view('profile/index', $data);
    }

    public function edit()
    {
        $user_id = $this->session->userdata('user_id');
        $data['user'] = $this->User_model->get_by_id($user_id);
        $data['title'] = 'Edit Profil';

        if ($this->input->post()) {
            $this->form_validation->set_rules('username', 'Username', 'required|trim');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim');
            $this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'required|trim');

            // Validasi password hanya jika diisi
            if ($this->input->post('password')) {
                $this->form_validation->set_rules('password', 'Password Baru', 'min_length[6]');
                $this->form_validation->set_rules('confirm_password', 'Konfirmasi Password', 'matches[password]');
                $this->form_validation->set_rules('current_password', 'Password Saat Ini', 'required');
            }

            if ($this->form_validation->run()) {
                $update_data = [
                    'username' => $this->input->post('username', TRUE),
                    'email' => $this->input->post('email', TRUE),
                    'nama_lengkap' => $this->input->post('nama_lengkap', TRUE),
                    'updated_at' => date('Y-m-d H:i:s')
                ];

                // Jika password diisi, validasi password lama dan update password baru
                if ($this->input->post('password')) {
                    $current_password = $this->input->post('current_password', TRUE);
                    if (!password_verify($current_password, $data['user']->password)) {
                        $data['error'] = 'Password saat ini salah!';
                    } else {
                        $update_data['password'] = password_hash($this->input->post('password', TRUE), PASSWORD_DEFAULT);
                    }
                }

                if (!isset($data['error'])) {
                    if ($this->User_model->update($user_id, $update_data)) {
                        // Update session username jika berubah
                        if ($this->session->userdata('username') !== $update_data['username']) {
                            $this->session->set_userdata('username', $update_data['username']);
                        }

                        $this->session->set_flashdata('success', 'Profil berhasil diperbarui!');
                        redirect('profile');
                    } else {
                        $data['error'] = 'Gagal memperbarui profil!';
                    }
                }
            }
        }

        // Load header dan view
        $this->load->view('navbar/header', $data);
        $this->load->view('profile/edit', $data);
    }

    public function change_password()
    {
        $user_id = $this->session->userdata('user_id');
        $data['user'] = $this->User_model->get_by_id($user_id);
        $data['title'] = 'Ubah Password';

        if ($this->input->post()) {
            $this->form_validation->set_rules('current_password', 'Password Saat Ini', 'required');
            $this->form_validation->set_rules('new_password', 'Password Baru', 'required|min_length[6]');
            $this->form_validation->set_rules('confirm_password', 'Konfirmasi Password', 'required|matches[new_password]');

            if ($this->form_validation->run()) {
                $current_password = $this->input->post('current_password', TRUE);
                $new_password = $this->input->post('new_password', TRUE);

                if (password_verify($current_password, $data['user']->password)) {
                    $update_data = [
                        'password' => password_hash($new_password, PASSWORD_DEFAULT),
                        'updated_at' => date('Y-m-d H:i:s')
                    ];

                    if ($this->User_model->update($user_id, $update_data)) {
                        $this->session->set_flashdata('success', 'Password berhasil diubah!');
                        redirect('profile');
                    } else {
                        $data['error'] = 'Gagal mengubah password!';
                    }
                } else {
                    $data['error'] = 'Password saat ini salah!';
                }
            }
        }

        // Load header dan view
        $this->load->view('navbar/header', $data);
        $this->load->view('profile/change_password', $data);
    }
}
