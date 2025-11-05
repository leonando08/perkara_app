<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model
{

    public function get_by_username($username)
    {
        try {
            // Cek apakah tabel pengadilan sudah ada
            if ($this->db->table_exists('pengadilan')) {
                // Join dengan tabel pengadilan untuk mendapatkan nama pengadilan
                $this->db->select('users.*, pengadilan.nama_pengadilan, pengadilan.kode_pengadilan');
                $this->db->from('users');
                $this->db->join('pengadilan', 'pengadilan.id = users.pengadilan_id', 'left');
                $this->db->where('users.username', $username);
                return $this->db->get()->row();
            }
        } catch (Exception $e) {
            // Jika error, gunakan fallback
            log_message('error', 'Error in get_by_username with JOIN: ' . $e->getMessage());
        }

        // Fallback: ambil user tanpa JOIN (untuk backward compatibility)
        return $this->db->get_where('users', ['username' => $username])->row();
    }

    public function get_by_id($id)
    {
        try {
            // Cek apakah tabel pengadilan sudah ada
            if ($this->db->table_exists('pengadilan')) {
                // Join dengan tabel pengadilan
                $this->db->select('users.*, pengadilan.nama_pengadilan, pengadilan.kode_pengadilan');
                $this->db->from('users');
                $this->db->join('pengadilan', 'pengadilan.id = users.pengadilan_id', 'left');
                $this->db->where('users.id', $id);
                return $this->db->get()->row();
            }
        } catch (Exception $e) {
            log_message('error', 'Error in get_by_id with JOIN: ' . $e->getMessage());
        }

        // Fallback: ambil user tanpa JOIN
        return $this->db->get_where('users', ['id' => $id])->row();
    }

    public function get_all()
    {
        try {
            // Cek apakah tabel pengadilan sudah ada
            if ($this->db->table_exists('pengadilan')) {
                // Join dengan tabel pengadilan untuk menampilkan nama pengadilan
                $this->db->select('users.*, pengadilan.nama_pengadilan, pengadilan.kode_pengadilan');
                $this->db->from('users');
                $this->db->join('pengadilan', 'pengadilan.id = users.pengadilan_id', 'left');
                $this->db->order_by('users.id', 'ASC');
                return $this->db->get()->result_array();
            }
        } catch (Exception $e) {
            log_message('error', 'Error in get_all with JOIN: ' . $e->getMessage());
        }

        // Fallback: ambil user tanpa JOIN
        return $this->db->order_by('id', 'ASC')->get('users')->result_array();
    }

    public function get_by_pengadilan($pengadilan_id)
    {
        try {
            // Cek apakah tabel pengadilan sudah ada
            if ($this->db->table_exists('pengadilan')) {
                // Ambil user berdasarkan pengadilan
                $this->db->select('users.*, pengadilan.nama_pengadilan');
                $this->db->from('users');
                $this->db->join('pengadilan', 'pengadilan.id = users.pengadilan_id', 'left');
                $this->db->where('users.pengadilan_id', $pengadilan_id);
                $this->db->order_by('users.username', 'ASC');
                return $this->db->get()->result_array();
            }
        } catch (Exception $e) {
            log_message('error', 'Error in get_by_pengadilan: ' . $e->getMessage());
        }

        // Fallback: return empty array jika tabel belum ada
        return [];
    }

    public function add($data)
    {
        return $this->db->insert('users', $data);
    }

    public function insert($data)
    {
        return $this->db->insert('users', $data);
    }

    public function update($id, $data)
    {
        // Set updated_at timestamp
        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->db->where('id', $id)->update('users', $data);
    }

    public function delete($id)
    {
        return $this->db->where('id', $id)->delete('users');
    }
}
