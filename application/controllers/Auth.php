<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * @property CI_Session $session
 * @property CI_Input $input
 * @property CI_DB_query_builder $db
 * @property User_model $User_model
 */

class Auth extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('User_model');
        $this->load->library('session');
        $this->load->helper(['url', 'form']);
    }

    public function login()
    {
        $data = [];

        // Generate CAPTCHA kalau belum ada
        if (!$this->session->userdata('captcha')) {
            $this->session->set_userdata('captcha', rand(1000, 9999));
        }

        if ($this->input->method() === 'post') {
            $username      = $this->input->post('username', TRUE);
            $password      = $this->input->post('password', TRUE);
            $captcha_input = $this->input->post('captcha', TRUE);

            // Cek CAPTCHA
            if ($captcha_input != $this->session->userdata('captcha')) {
                $data['error'] = "Kode CAPTCHA salah!";
            } else {
                $user = $this->User_model->get_by_username($username);

                if ($user && password_verify($password, $user->password)) {
                    // Simpan session
                    $this->session->set_userdata([
                        'user_id'   => $user->id,
                        'username'  => $user->username,
                        'role'      => $user->role,
                        'logged_in' => TRUE
                    ]);

                    // Reset CAPTCHA
                    $this->session->unset_userdata('captcha');

                    // Redirect berdasarkan role
                    if ($user->role === 'admin') {
                        redirect('admin/dashboard');
                    } else {
                        redirect('user/dashboard');
                    }
                } else {
                    $data['error'] = "Username atau password salah!";
                }
            }

            // Generate ulang CAPTCHA setiap POST
            $this->session->set_userdata('captcha', rand(1000, 9999));
        }

        $this->load->view('auth/login', $data);
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('auth/login');
    }
}
