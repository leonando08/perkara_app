<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_DB_query_builder $db
 * @property CI_DB_query_builder $db
 */
class User_model extends CI_Model
{
    private $table = 'users';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Cek login user
     * @param string $username
     * @param string $password
     * @return object|false
     */
    public function login($username, $password)
    {
        $this->db->where('username', $username);
        $user = $this->db->get($this->table)->row(); // pakai object, biar konsisten

        if ($user && password_verify($password, $user->password)) {
            return $user; // login sukses
        }
        return false; // gagal login
    }

    /**
     * Register user baru
     * @param string $username
     * @param string $password
     * @param string $role
     * @return bool
     */
    public function register($username, $password, $role = 'user')
    {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $data = [
            'username' => $username,
            'password' => $hashedPassword,
            'role'     => $role
        ];

        return $this->db->insert($this->table, $data);
        $this->load->database();
    }

    /**
     * Ambil user berdasarkan username
     * @param string $username
     * @return object|null
     */
    public function get_by_username($username)
    {
        return $this->db->get_where($this->table, ['username' => $username])->row();
    }
}
