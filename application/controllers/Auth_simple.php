<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Simple Auth Controller - Without Captcha
 * @property CI_Session $session
 * @property CI_Input $input
 * @property User_model $User_model
 * @property Pengadilan_model $Pengadilan_model
 * @property CI_Form_validation $form_validation
 * @property CI_DB_query_builder $db
 */
class Auth_simple extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(['User_model', 'Pengadilan_model']);
        $this->load->library(['session', 'form_validation']);
        $this->load->helper(['url', 'form']);
        $this->load->database();
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

        if ($this->input->post()) {
            $username = $this->input->post('username', TRUE);
            $password = $this->input->post('password', TRUE);

            // Simple validation (skip captcha check for simplified login)
            if (empty($username) || empty($password)) {
                $data['error'] = "Username dan password harus diisi!";
            } else {
                $user = $this->User_model->get_by_username($username);
                if ($user && password_verify($password, $user->password)) {
                    // Set session data (simple fields only)
                    $session_data = [
                        'user_id' => $user->id,
                        'username' => $user->username,
                        'role' => $user->role,
                        'email' => $user->email,
                        'logged_in' => TRUE,
                        'login_time' => time()
                    ];

                    // Tambahkan data pengadilan ke session jika ada
                    if (isset($user->pengadilan_id) && !empty($user->pengadilan_id)) {
                        $session_data['pengadilan_id'] = $user->pengadilan_id;
                        $session_data['nama_pengadilan'] = $user->nama_pengadilan ?? '';
                        $session_data['kode_pengadilan'] = $user->kode_pengadilan ?? '';
                    }

                    $this->session->set_userdata($session_data);

                    // Set flash message
                    $welcome_msg = 'Login berhasil! Selamat datang ' . $user->username;
                    if (isset($user->nama_pengadilan)) {
                        $welcome_msg .= ' - Asal: ' . $user->nama_pengadilan;
                    }
                    $this->session->set_flashdata('login_success', $welcome_msg);

                    // Redirect sesuai role
                    if ($user->role === 'admin') {
                        redirect('admin/dashboard_admin');
                    } else {
                        redirect('user/dashboard_user');
                    }
                } else {
                    $data['error'] = "Username atau password salah!";
                }
            }
        }

        $this->load->view('login/login_form', isset($data) ? $data : []);
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('auth_simple/login');
    }

    public function test()
    {
        echo "<h1>Auth Controller Working!</h1>";
        echo "<p>Current time: " . date('Y-m-d H:i:s') . "</p>";

        // Test database connection
        echo "<h2>Database Test:</h2>";
        try {
            $users = $this->User_model->get_all();
            echo "<p>✅ Database connected! Found " . count($users) . " users.</p>";

            if (!empty($users)) {
                echo "<h3>Users:</h3><ul>";
                foreach ($users as $user) {
                    echo "<li>{$user['username']} - {$user['role']}</li>";
                }
                echo "</ul>";
            }
        } catch (Exception $e) {
            echo "<p>❌ Database error: " . $e->getMessage() . "</p>";
        }

        echo "<p><a href='" . site_url('auth_simple/login') . "'>Go to Login</a></p>";
    }

    public function captcha()
    {
        // Simple captcha placeholder - just returns a simple image
        header('Content-Type: image/png');
        $image = imagecreate(180, 50);
        $bg = imagecolorallocate($image, 255, 255, 255);
        $text_color = imagecolorallocate($image, 0, 0, 0);

        $text = 'SKIP';
        imagestring($image, 5, 70, 15, $text, $text_color);

        imagepng($image);
        imagedestroy($image);
        exit;
    }

    public function refresh_captcha()
    {
        // Same as captcha method for simplicity
        $this->captcha();
    }

    public function register()
    {
        // Get pengadilan list for dropdown
        $data['pengadilan_list'] = [];

        try {
            // Try using model first
            $data['pengadilan_list'] = $this->Pengadilan_model->get_all(false); // false = ambil semua tanpa filter aktif
        } catch (Exception $e) {
            // Jika ada error dengan Pengadilan_model, coba ambil langsung dari database
            try {
                $query = $this->db->get('pengadilan');
                $data['pengadilan_list'] = $query->result();
            } catch (Exception $e2) {
                // Log error untuk debugging
                log_message('error', 'Failed to get pengadilan list: ' . $e2->getMessage());
            }
        }

        // Check if pengadilan table exists and has data
        if (empty($data['pengadilan_list'])) {
            // Set error message dengan detail lebih jelas
            $error_msg = 'Belum ada data pengadilan. Silakan hubungi administrator untuk menambahkan data pengadilan terlebih dahulu.';
            $this->session->set_flashdata('error', $error_msg);

            // Log untuk debugging
            log_message('error', 'Register failed: No pengadilan data found');

            redirect('auth_simple/login');
            return;
        }

        // Load register view dengan data pengadilan
        $this->load->view('login/register', $data);
    }
    public function process_register()
    {
        // Get pengadilan list for dropdown (for form reload if validation fails)
        try {
            $data['pengadilan_list'] = $this->Pengadilan_model->get_all(false); // false = ambil semua
        } catch (Exception $e) {
            // Fallback: ambil langsung dari tabel
            try {
                $query = $this->db->get('pengadilan');
                $data['pengadilan_list'] = $query->result();
            } catch (Exception $e2) {
                $data['pengadilan_list'] = [];
            }
        }

        if ($this->input->post()) {
            // Set validation rules (hanya field yang diperlukan)
            $this->form_validation->set_rules('username', 'Username', 'required|trim|min_length[4]|max_length[50]|alpha_numeric|is_unique[users.username]');
            $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|max_length[100]|is_unique[users.email]');
            $this->form_validation->set_rules('password', 'Password', 'required|min_length[8]|max_length[100]|callback_validate_password');
            $this->form_validation->set_rules('confirm_password', 'Konfirmasi Password', 'required|matches[password]');
            $this->form_validation->set_rules('pengadilan_id', 'Asal Pengadilan', 'required|numeric');

            // Custom error messages
            $this->form_validation->set_message('required', '{field} harus diisi');
            $this->form_validation->set_message('min_length', '{field} minimal {param} karakter');
            $this->form_validation->set_message('max_length', '{field} maksimal {param} karakter');
            $this->form_validation->set_message('alpha_numeric', '{field} hanya boleh huruf dan angka');
            $this->form_validation->set_message('is_unique', '{field} sudah digunakan');
            $this->form_validation->set_message('valid_email', '{field} tidak valid');
            $this->form_validation->set_message('matches', '{field} tidak cocok');
            $this->form_validation->set_message('numeric', '{field} harus berupa angka');

            if ($this->form_validation->run() == FALSE) {
                // Validation failed, reload form with errors
                $this->load->view('login/register', $data);
                return;
            }

            // Validation passed, create user (hanya field yang diperlukan)
            $user_data = [
                'username' => strtolower($this->input->post('username', TRUE)),
                'email' => strtolower($this->input->post('email', TRUE)),
                'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                'role' => 'user', // Default role
                'pengadilan_id' => $this->input->post('pengadilan_id', TRUE),
                'aktif' => 'Y',
                'created_at' => date('Y-m-d H:i:s')
            ];

            // Try to insert user
            try {
                if ($this->User_model->add($user_data)) {
                    $this->session->set_flashdata('success', 'Registrasi berhasil! Silakan login dengan akun yang baru saja didaftarkan.');
                    redirect('auth_simple/login');
                } else {
                    $data['error'] = 'Gagal menyimpan data. Silakan coba lagi.';
                }
            } catch (Exception $e) {
                $data['error'] = 'Terjadi kesalahan: ' . $e->getMessage();
            }
        }

        $this->load->view('login/register', $data);
    }

    public function register_simple()
    {
        if ($this->input->post()) {
            // Set validation rules
            $this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'required|trim|max_length[100]');
            $this->form_validation->set_rules('username', 'Username', 'required|trim|min_length[4]|max_length[50]|alpha_numeric|is_unique[users.username]');
            $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|max_length[100]|is_unique[users.email]');
            $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]|max_length[100]');
            $this->form_validation->set_rules('confirm_password', 'Konfirmasi Password', 'required|matches[password]');
            $this->form_validation->set_rules('nip', 'NIP', 'trim|max_length[30]');
            $this->form_validation->set_rules('jabatan', 'Jabatan', 'trim|max_length[50]');

            // Custom error messages
            $this->form_validation->set_message('required', '{field} harus diisi');
            $this->form_validation->set_message('min_length', '{field} minimal {param} karakter');
            $this->form_validation->set_message('max_length', '{field} maksimal {param} karakter');
            $this->form_validation->set_message('alpha_numeric', '{field} hanya boleh huruf dan angka');
            $this->form_validation->set_message('is_unique', '{field} sudah digunakan');
            $this->form_validation->set_message('valid_email', '{field} tidak valid');
            $this->form_validation->set_message('matches', '{field} tidak cocok');

            if ($this->form_validation->run() == FALSE) {
                // Validation failed, reload form with errors
                $this->load->view('login/register_simple');
                return;
            }

            // Validation passed, create user
            $user_data = [
                'nama_lengkap' => $this->input->post('nama_lengkap', TRUE),
                'username' => strtolower($this->input->post('username', TRUE)),
                'email' => strtolower($this->input->post('email', TRUE)),
                'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                'role' => 'user', // Default role
                'nip' => $this->input->post('nip', TRUE),
                'jabatan' => $this->input->post('jabatan', TRUE),
                'aktif' => 'Y',
                'created_at' => date('Y-m-d H:i:s')
            ];

            // Remove empty optional fields
            if (empty($user_data['nip'])) {
                unset($user_data['nip']);
            }
            if (empty($user_data['jabatan'])) {
                unset($user_data['jabatan']);
            }

            // Try to insert user
            try {
                if ($this->User_model->add($user_data)) {
                    $this->session->set_flashdata('success', 'Registrasi berhasil! Silakan login dengan akun yang baru saja didaftarkan.');
                    redirect('auth_simple/login');
                } else {
                    $data['error'] = 'Gagal menyimpan data. Silakan coba lagi.';
                }
            } catch (Exception $e) {
                $data['error'] = 'Terjadi kesalahan: ' . $e->getMessage();
            }
        }

        $this->load->view('login/register_simple', isset($data) ? $data : []);
    }

    /**
     * Custom validation untuk password
     * Harus minimal 8 karakter, mengandung huruf besar, dan karakter khusus
     */
    public function validate_password($password)
    {
        // Cek minimal 8 karakter
        if (strlen($password) < 8) {
            $this->form_validation->set_message('validate_password', 'Password minimal 8 karakter');
            return FALSE;
        }

        // Cek harus ada huruf besar (uppercase)
        if (!preg_match('/[A-Z]/', $password)) {
            $this->form_validation->set_message('validate_password', 'Password harus mengandung minimal 1 huruf besar (A-Z)');
            return FALSE;
        }

        // Cek harus ada huruf kecil (lowercase)
        if (!preg_match('/[a-z]/', $password)) {
            $this->form_validation->set_message('validate_password', 'Password harus mengandung minimal 1 huruf kecil (a-z)');
            return FALSE;
        }

        // Cek harus ada angka
        if (!preg_match('/[0-9]/', $password)) {
            $this->form_validation->set_message('validate_password', 'Password harus mengandung minimal 1 angka (0-9)');
            return FALSE;
        }

        // Cek harus ada karakter khusus
        if (!preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password)) {
            $this->form_validation->set_message('validate_password', 'Password harus mengandung minimal 1 karakter khusus (!@#$%^&*(),.?":{}|<>)');
            return FALSE;
        }

        return TRUE;
    }
}
