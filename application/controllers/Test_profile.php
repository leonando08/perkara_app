<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_DB_query_builder $db
 */
class Test_profile extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->database(); // Ensure database library is loaded
    }

    public function index()
    {
        echo "<h1>Test Profile Controller</h1>";
        echo "<p>Base URL: " . base_url() . "</p>";
        echo "<p>Site URL: " . site_url() . "</p>";

        // Test URLs
        echo "<h3>Test Links:</h3>";
        echo '<a href="' . base_url('profile') . '" target="_blank">Profile Index</a><br>';
        echo '<a href="' . base_url('profile/edit') . '" target="_blank">Profile Edit</a><br>';
        echo '<a href="' . base_url('profile/change_password') . '" target="_blank">Change Password</a><br>';

        // Test if Profile controller exists
        if (file_exists(APPPATH . 'controllers/Profile.php')) {
            echo "<p style='color: green;'>✓ Profile controller exists</p>";
        } else {
            echo "<p style='color: red;'>✗ Profile controller NOT found</p>";
        }

        // Test database connection
        if ($this->db->conn_id) {
            echo "<p style='color: green;'>✓ Database connected</p>";
        } else {
            echo "<p style='color: red;'>✗ Database connection failed</p>";
        }
    }
}
