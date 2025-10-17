<?php
defined('BASEPATH') or exit('No direct script access allowed');

// Load Composer autoloader
require_once APPPATH . '../vendor/autoload.php';

use Gregwar\Captcha\CaptchaBuilder;

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

    public function captcha()
    {
        // Selalu generate captcha baru saat di-refresh
        $this->_generateNewCaptcha();
        $captcha_data = $this->session->userdata('captcha_data');

        if (!$captcha_data || !isset($captcha_data['image_data'])) {
            $this->_createErrorImage();
            return;
        }

        // Security headers
        header('Content-Type: image/jpeg');
        header('Cache-Control: no-cache, no-store, must-revalidate');
        header('Pragma: no-cache');
        header('Expires: 0');
        header('X-Content-Type-Options: nosniff');

        echo $captcha_data['image_data'];
    }

    public function refresh_captcha()
    {
        // Endpoint khusus untuk refresh captcha
        $this->_generateNewCaptcha();
        $captcha_data = $this->session->userdata('captcha_data');

        if (!$captcha_data || !isset($captcha_data['image_data'])) {
            $this->_createErrorImage();
            return;
        }

        // Security headers
        header('Content-Type: image/jpeg');
        header('Cache-Control: no-cache, no-store, must-revalidate');
        header('Pragma: no-cache');
        header('Expires: 0');
        header('X-Content-Type-Options: nosniff');

        echo $captcha_data['image_data'];
    }

    public function debug_session()
    {
        // Debug endpoint - hanya untuk development
        if (ENVIRONMENT !== 'development') {
            show_404();
            return;
        }

        header('Content-Type: application/json');
        $ip = $this->input->ip_address();
        $cooldown_key = 'captcha_cooldown_' . md5($ip);
        $attempts_key = 'captcha_attempts_' . md5($ip);
        $cooldown_time = $this->session->userdata($cooldown_key);

        echo json_encode([
            'captcha_data' => $this->session->userdata('captcha_data'),
            'session_id' => session_id(),
            'ip' => $ip,
            'captcha_attempts' => $this->session->userdata($attempts_key),
            'captcha_cooldown' => $cooldown_time,
            'current_time' => time(),
            'cooldown_remaining' => $cooldown_time ? max(0, 180 - (time() - $cooldown_time)) : 0,
            'cooldown_expired' => $cooldown_time ? (time() - $cooldown_time) >= 180 : true
        ]);
    }

    public function clear_rate_limit()
    {
        // Method untuk clear rate limit - hanya untuk development
        if (ENVIRONMENT !== 'development') {
            show_404();
            return;
        }

        $ip = $this->input->ip_address();

        // Clear all captcha rate limit keys
        $keys_to_clear = [];
        foreach ($_SESSION as $key => $value) {
            if (strpos($key, 'captcha_rate_') === 0) {
                $keys_to_clear[] = $key;
            }
        }

        foreach ($keys_to_clear as $key) {
            $this->session->unset_userdata($key);
        }

        // Clear captcha data untuk force regenerate
        $this->session->unset_userdata('captcha_data');

        echo "Rate limit cleared for IP: " . $ip;
    }

    public function clear_cooldown()
    {
        // Method untuk clear cooldown - hanya untuk development
        if (ENVIRONMENT !== 'development') {
            show_404();
            return;
        }

        $ip = $this->input->ip_address();

        // Clear cooldown keys
        $captcha_cooldown_key = 'captcha_cooldown_' . md5($ip);
        $attempts_key = 'captcha_attempts_' . md5($ip);
        $this->session->unset_userdata($captcha_cooldown_key);
        $this->session->unset_userdata($attempts_key);

        // Clear captcha data
        $this->session->unset_userdata('captcha_data');

        echo "Cooldown and attempts cleared for IP: " . $ip;
    }
    private function _generateSecurePhrase($length = 5)
    {
        // Use mixed characters excluding confusing ones (0, O, l, 1, I)
        $chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
        $phrase = '';
        for ($i = 0; $i < $length; $i++) {
            $phrase .= $chars[random_int(0, strlen($chars) - 1)];
        }
        return $phrase;
    }

    private function _createErrorImage()
    {
        $image = imagecreate(180, 50);
        $bg = imagecolorallocate($image, 255, 0, 0);
        $text = imagecolorallocate($image, 255, 255, 255);
        imagestring($image, 3, 50, 15, 'RATE LIMIT', $text);
        imagejpeg($image);
        imagedestroy($image);
    }

    private function _generateNewCaptcha()
    {
        // Clear existing captcha data
        $this->session->unset_userdata('captcha_data');

        // Generate new captcha
        $builder = new CaptchaBuilder();

        // Enhanced security settings
        $builder->setDistortion(true);
        $builder->setMaxBehindLines(3);
        $builder->setMaxFrontLines(3);
        $builder->setBackgroundColor(240, 240, 240);
        $builder->setMaxAngle(8);
        $builder->setMaxOffset(5);

        // Build with custom phrase
        $phrase = $this->_generateSecurePhrase();
        $builder->setPhrase($phrase);
        $builder->build(180, 50);

        // Generate session data
        $timestamp = time();
        $ip = $this->input->ip_address();

        // Store captcha data in session
        $captcha_data = [
            'phrase' => $builder->getPhrase(),
            'timestamp' => $timestamp,
            'ip' => $ip,
            'image_data' => $builder->get()
        ];

        $this->session->set_userdata('captcha_data', $captcha_data);
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

        // Generate captcha jika belum ada atau sudah expired
        $captcha_data = $this->session->userdata('captcha_data');
        if (!$captcha_data || (time() - $captcha_data['timestamp']) > 180) { // 5 menit expired
            $this->_generateNewCaptcha();
        }

        // Check dan reset cooldown yang sudah expired saat halaman dimuat
        $ip = $this->input->ip_address();
        $captcha_cooldown_key = 'captcha_cooldown_' . md5($ip);
        $attempts_key = 'captcha_attempts_' . md5($ip);
        $cooldown_time = $this->session->userdata($captcha_cooldown_key);

        if ($cooldown_time && (time() - $cooldown_time) >= 180) {
            // Cooldown sudah habis, reset semua
            $this->session->unset_userdata($captcha_cooldown_key);
            $this->session->unset_userdata($attempts_key);
            log_message('debug', "Page load: Cooldown expired for IP: {$ip}, attempts reset");
        }

        if ($this->input->post()) {
            $username = $this->input->post('username', TRUE);
            $password = $this->input->post('password', TRUE);
            $captcha = $this->input->post('captcha', TRUE);

            // Rate limiting per IP untuk login attempts
            $ip = $this->input->ip_address();
            $login_key = 'login_attempts_' . md5($ip);
            $login_attempts = $this->session->userdata($login_key) ?: 0;

            if ($login_attempts > 5) {
                $data['error'] = "Terlalu banyak percobaan login. Coba lagi dalam 10 menit.";
                $this->_generateNewCaptcha();
                $this->load->view('login/login_form', $data);
                return;
            }

            // Verifikasi captcha dengan enhanced security
            $captcha_data = $this->session->userdata('captcha_data');

            // Check captcha cooldown
            $captcha_cooldown_key = 'captcha_cooldown_' . md5($ip);
            $cooldown_time = $this->session->userdata($captcha_cooldown_key);

            // Check attempts counter (terpisah dari captcha data)
            $attempts_key = 'captcha_attempts_' . md5($ip);
            $current_attempts = $this->session->userdata($attempts_key) ?: 0;

            if ($cooldown_time && (time() - $cooldown_time) < 180) { // 5 menit cooldown
                $remaining = 180 - (time() - $cooldown_time);
                $minutes = floor($remaining / 60);
                $seconds = $remaining % 60;
                $data['error'] = "Terlalu banyak kesalahan captcha. Coba lagi dalam {$minutes} menit {$seconds} detik.";
                $data['cooldown'] = true;
                $this->load->view('login/login_form', $data);
                return;
            } elseif ($cooldown_time && (time() - $cooldown_time) >= 180) {
                // Cooldown selesai, reset attempts counter dan cooldown
                $this->session->unset_userdata($captcha_cooldown_key);
                $this->session->unset_userdata($attempts_key);
                $current_attempts = 0; // Reset counter
                log_message('debug', "Cooldown finished for IP: {$ip}, attempts reset");
            }            // Check captcha validity
            if (!$captcha_data) {
                $data['error'] = "Captcha expired. Silakan refresh halaman.";
                $this->_generateNewCaptcha();
            } elseif ($captcha_data['ip'] !== $ip) {
                $data['error'] = "IP address mismatch!";
                $this->_generateNewCaptcha();
            } elseif ((time() - $captcha_data['timestamp']) > 180) {
                $data['error'] = "Captcha expired. Silakan refresh.";
                $this->_generateNewCaptcha();
            } elseif ($current_attempts >= 5) {
                // Set cooldown dan generate captcha baru
                $this->session->set_userdata($captcha_cooldown_key, time());
                $data['error'] = "Terlalu banyak percobaan captcha salah. Coba lagi dalam 3 menit.";
                $data['cooldown'] = true;
                $this->_generateNewCaptcha();
            } elseif (strtoupper(trim($captcha)) !== strtoupper($captcha_data['phrase'])) {
                // Update attempts counter (terpisah dari captcha data)
                $current_attempts++;
                $this->session->set_userdata($attempts_key, $current_attempts);

                // Debug log
                log_message('debug', "Captcha attempt #{$current_attempts} failed for IP: {$ip}");

                if ($current_attempts >= 5) {
                    // Set cooldown ketika mencapai 5 attempts
                    $this->session->set_userdata($captcha_cooldown_key, time());
                    $data['error'] = "Terlalu banyak kesalahan captcha. Coba lagi dalam 3 menit.";
                    $data['cooldown'] = true;
                    $this->_generateNewCaptcha();
                } else {
                    $data['error'] = "Captcha salah! Sisa percobaan: " . (5 - $current_attempts);
                    // Generate captcha baru tapi attempts tetap
                    $this->_generateNewCaptcha();
                }
            } else {
                // Captcha benar, lanjut verifikasi login
                $user = $this->User_model->get_by_username($username);
                if ($user && password_verify($password, $user->password)) {
                    // Reset semua session counter
                    $this->session->unset_userdata('captcha_data');
                    $this->session->unset_userdata($login_key);
                    $this->session->unset_userdata($attempts_key);
                    $this->session->unset_userdata($captcha_cooldown_key);

                    $this->session->set_userdata([
                        'user_id' => $user->id,
                        'username' => $user->username,
                        'role' => $user->role,
                        'logged_in' => TRUE,
                        'login_time' => time(),
                        'login_ip' => $ip
                    ]);

                    // Set flash message untuk login berhasil
                    $this->session->set_flashdata('login_success', 'Login berhasil! Selamat datang ' . $user->username);

                    if ($user->role === 'admin') redirect('admin/dashboard_admin');
                    else redirect('user/dashboard_user');
                } else {
                    // Increment login attempts
                    $this->session->set_userdata($login_key, $login_attempts + 1);
                    $data['error'] = "Username atau password salah!";
                    $this->_generateNewCaptcha();
                }
            }
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
