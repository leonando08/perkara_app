<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_Session $session
 * @property CI_Input $input
 * @property CI_DB_query_builder $db
 * @property User_model $User_model
 */
#[\AllowDynamicProperties]
class Login extends CI_Controller

{
    public function __construct()
    {
        parent::__construct();
        // kalau sudah autoload session, baris ini HAPUS:
        // $this->load->library('session');

        $this->load->helper(['url', 'form']);
        $this->load->model('User_model');
        $this->load->database();
    }


    public function index()
    {
        $data = [];

        // --- Generate Captcha setiap kali halaman login dibuka ---
        $captcha = rand(1000, 9999);
        $this->session->set_userdata('captcha', $captcha);
        $data['captcha'] = $captcha;

        // Kalau form login di-submit
        if ($this->input->post()) {
            $username = $this->input->post('username', TRUE);
            $password = $this->input->post('password', TRUE);
            $inputCaptcha = $this->input->post('captcha', TRUE);
            $savedCaptcha = $this->session->userdata('captcha');

            // Validasi captcha
            if ($inputCaptcha != $savedCaptcha) {
                $data['error'] = 'Captcha salah!';
                $this->load->view('login/login_form', $data);
                return;
            }

            // Validasi user
            $user = $this->User_model->get_by_username($username);

            if ($user && password_verify($password, $user->password)) {
                // Simpan session user
                $this->session->set_userdata([
                    'user_id'   => $user->id,
                    'username'  => $user->username,
                    'role'      => $user->role,
                    'logged_in' => TRUE
                ]);

                // Redirect berdasarkan role
                if ($user->role === 'admin') {
                    redirect('admin/dashboard');
                } else {
                    redirect('user/dashboard');
                }
                return;
            } else {
                $data['error'] = 'Username atau password salah!';
            }
        }

        // Tampilkan form login + captcha
        $this->load->view('login/login_form', $data);
    }
}
