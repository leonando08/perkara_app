<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Test_register extends CI_Controller
{
    public function index()
    {
        echo "<!DOCTYPE html>";
        echo "<html><head><title>Test Register</title></head>";
        echo "<body>";
        echo "<h1>Test Register Controller</h1>";
        echo "<p>Jika halaman ini terbuka, berarti CodeIgniter routing bekerja dengan baik.</p>";
        echo "<p>Sekarang coba akses: <a href='" . base_url('index.php/auth_simple/register') . "'>Auth_simple Register</a></p>";
        echo "</body></html>";
    }
}
