<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * @property CI_Session $session
 * @property CI_Input $input
 * @property CI_DB_query_builder $db
 * @property User_model $User_model
 * @property CI_Form_validation $form_validation
 */

class Auth extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library(['session', 'form_validation']);
        $this->load->helper(['url', 'form']);
    }

    public function login()
    {
        // Jika sudah login, redirect sesuai role
        if ($this->session->userdata('logged_in')) {
            if ($this->session->userdata('role') === 'admin') {
                redirect('admin/dashboard_admin');
            } else {
                redirect('user/dashboard_user');
            }
        }

        // Generate captcha
        if (!$this->session->userdata('captcha')) {
            $this->session->set_userdata('captcha', rand(1000, 9999));
        }

        if ($this->input->post()) {
            $username = $this->input->post('username', TRUE);
            $password = $this->input->post('password', TRUE);
            $captcha  = $this->input->post('captcha', TRUE);

            if ($captcha != $this->session->userdata('captcha')) {
                $data['error'] = "Captcha salah!";
            } else {
                $user = $this->User_model->get_by_username($username);
                if ($user && password_verify($password, $user->password)) {
                    $this->session->set_userdata([
                        'user_id' => $user->id,
                        'username' => $user->username,
                        'role' => $user->role,
                        'logged_in' => TRUE
                    ]);
                    $this->session->unset_userdata('captcha');

                    // Set flash message untuk login berhasil
                    $this->session->set_flashdata('login_success', 'Login berhasil! Selamat datang ' . $user->username);

                    if ($user->role === 'admin') redirect('admin/dashboard_admin');
                    else redirect('user/dashboard_user');
                } else {
                    $data['error'] = "Username atau password salah!";
                }
            }
            // regenerate captcha
            $this->session->set_userdata('captcha', rand(1000, 9999));
        }

        $this->load->view('login/login_form', isset($data) ? $data : []);
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('auth/login');
    }

    public function register()
    {
        // Jika sudah login, redirect sesuai role
        if ($this->session->userdata('logged_in')) {
            if ($this->session->userdata('role') === 'admin') {
                redirect('admin/dashboard_admin');
            } else {
                redirect('user/dashboard_user');
            }
        }

        if ($this->input->post()) {
            $this->form_validation->set_rules('username', 'Username', 'required|is_unique[users.username]');
            $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
            $this->form_validation->set_rules('confirm_password', 'Konfirmasi Password', 'required|matches[password]');

            if ($this->form_validation->run()) {
                $data = [
                    'username' => $this->input->post('username', TRUE),
                    'password' => password_hash($this->input->post('password', TRUE), PASSWORD_DEFAULT),
                    'role' => 'user', // default role
                    'created_at' => date('Y-m-d H:i:s')
                ];

                if ($this->User_model->add($data)) {
                    $this->session->set_flashdata('success', 'Registrasi berhasil! Silakan login.');
                    redirect('auth/login');
                } else {
                    $data['error'] = 'Registrasi gagal! Silakan coba lagi.';
                }
            }
        }

        $this->load->view('login/register', isset($data) ? $data : []);
    }
}
