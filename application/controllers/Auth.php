
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
                redirect('user/dashboard');
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
}
