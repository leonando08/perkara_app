<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_Session $session
 * @property CI_Input $input
 * @property CI_DB_query_builder $db
 * @property User_model $User_model
 */
class Login extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(['url', 'form']);
        $this->load->model('User_model');
        $this->load->library('session');
        $this->load->database();
    }

    public function index()
    {
        $data = [];

        // Generate captcha
        $captcha = rand(1000, 9999);
        $this->session->set_userdata('captcha', $captcha);
        $data['captcha'] = $captcha;

        if ($this->input->post()) {
            $username = $this->input->post('username', TRUE);
            $password = $this->input->post('password', TRUE);
            $inputCaptcha = $this->input->post('captcha', TRUE);
            $savedCaptcha = $this->session->userdata('captcha');

            // Validasi CAPTCHA
            if ($inputCaptcha != $savedCaptcha) {
                $data['error'] = 'Captcha salah!';
                $this->load->view('login/login_form', $data);
                return;
            }

            // Validasi user
            $user = $this->User_model->get_by_username($username);

            if ($user && password_verify($password, $user->password)) {
                // Simpan session
                $this->session->set_userdata([
                    'user_id'   => $user->id,
                    'username'  => $user->username,
                    'role'      => $user->role,
                    'logged_in' => TRUE
                ]);

                // Redirect sesuai role
                if ($user->role === 'admin') {
                    redirect('admin/dashboard_admin'); // pastikan controller Admin.php method dashboard_admin
                } else {
                    redirect('user/dashboard_user');   // pastikan controller User.php method dashboard_user
                }
                return;
            } else {
                $data['error'] = 'Username atau password salah!';
            }
        }

        $this->load->view('login/login_form', $data);
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('login');
    }
}
