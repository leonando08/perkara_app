<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Pengadilan Model
 * 
 * Model untuk mengelola data master pengadilan dalam sistem multi-instansi
 * 
 * @package    Perkara_App
 * @subpackage Models
 * @category   Master Data
 * @author     Sistem Informasi Perkara
 */
class Pengadilan_model extends CI_Model
{
    /**
     * Nama tabel
     */
    private $table = 'pengadilan';

    /**
     * Konstruktor
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Check if column exists in table
     * 
     * @param string $column_name
     * @return bool
     */
    private function _column_exists($column_name)
    {
        try {
            $query = $this->db->query("SHOW COLUMNS FROM {$this->table} LIKE '{$column_name}'");
            return $query->num_rows() > 0;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Get all pengadilan
     * 
     * @param bool $aktif_only Hanya ambil pengadilan yang aktif
     * @return array
     */
    public function get_all($aktif_only = true)
    {
        try {
            // Cek apakah kolom 'aktif' ada di tabel
            if ($aktif_only && $this->_column_exists('aktif')) {
                $this->db->where('aktif', 'Y');
            }
        } catch (Exception $e) {
            // Jika ada error, lanjutkan tanpa filter aktif
            log_message('error', 'Error checking aktif column in pengadilan: ' . $e->getMessage());
        }

        $this->db->order_by('nama_pengadilan', 'ASC');
        return $this->db->get($this->table)->result();
    }

    /**
     * Get pengadilan by ID
     * 
     * @param int $id
     * @return object|null
     */
    public function get_by_id($id)
    {
        return $this->db->get_where($this->table, ['id' => $id])->row();
    }

    /**
     * Get pengadilan by kode
     * 
     * @param string $kode
     * @return object|null
     */
    public function get_by_kode($kode)
    {
        return $this->db->get_where($this->table, ['kode' => $kode])->row();
    }

    /**
     * Insert pengadilan baru
     * 
     * @param array $data
     * @return int|bool Insert ID atau false jika gagal
     */
    public function insert($data)
    {
        // Validasi data yang wajib ada
        if (!isset($data['kode']) || !isset($data['nama_pengadilan'])) {
            return false;
        }

        // Set default values (hanya jika kolom aktif ada)
        if (!isset($data['aktif']) && $this->_column_exists('aktif')) {
            $data['aktif'] = 'Y';
        }

        // Hapus field yang tidak boleh di-insert manual
        unset($data['id']);
        unset($data['created_at']);
        unset($data['updated_at']);

        if ($this->db->insert($this->table, $data)) {
            return $this->db->insert_id();
        }
        return false;
    }

    /**
     * Update pengadilan
     * 
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update($id, $data)
    {
        // Hapus field yang tidak boleh di-update manual
        unset($data['id']);
        unset($data['created_at']);

        // Set updated_at akan otomatis oleh database (ON UPDATE CURRENT_TIMESTAMP)

        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }

    /**
     * Delete pengadilan (soft delete dengan ubah status aktif)
     * 
     * @param int $id
     * @return bool
     */
    public function delete($id)
    {
        // Cek apakah ada user yang terikat dengan pengadilan ini
        $this->db->where('pengadilan_id', $id);
        $count_users = $this->db->count_all_results('users');

        if ($count_users > 0) {
            // Jangan hapus jika masih ada user
            return false;
        }

        // Soft delete - ubah status aktif menjadi 'N' (hanya jika kolom aktif ada)
        if ($this->_column_exists('aktif')) {
            return $this->update($id, ['aktif' => 'N']);
        }

        // Jika kolom aktif tidak ada, lakukan hard delete
        return $this->hard_delete($id);
    }

    /**
     * Hard delete pengadilan (hapus permanen dari database)
     * HATI-HATI: Ini akan menghapus data permanen!
     * 
     * @param int $id
     * @return bool
     */
    public function hard_delete($id)
    {
        // Cek apakah ada relasi dengan tabel lain
        $this->db->where('pengadilan_id', $id);
        $count_users = $this->db->count_all_results('users');

        $this->db->where('pengadilan_id', $id);
        $count_perkara = $this->db->count_all_results('perkara_banding');

        if ($count_users > 0 || $count_perkara > 0) {
            // Jangan hapus jika masih ada relasi
            return false;
        }

        $this->db->where('id', $id);
        return $this->db->delete($this->table);
    }

    /**
     * Get count of users per pengadilan
     * 
     * @param int $pengadilan_id
     * @return int
     */
    public function count_users($pengadilan_id)
    {
        $this->db->where('pengadilan_id', $pengadilan_id);
        return $this->db->count_all_results('users');
    }

    /**
     * Get count of perkara per pengadilan
     * 
     * @param int $pengadilan_id
     * @return int
     */
    public function count_perkara($pengadilan_id)
    {
        $this->db->where('pengadilan_id', $pengadilan_id);
        return $this->db->count_all_results('perkara_banding');
    }

    /**
     * Get pengadilan dengan statistik (jumlah user dan perkara)
     * 
     * @param bool $aktif_only
     * @return array
     */
    public function get_all_with_stats($aktif_only = true)
    {
        $pengadilan_list = $this->get_all($aktif_only);

        foreach ($pengadilan_list as $pengadilan) {
            $pengadilan->jumlah_user = $this->count_users($pengadilan->id);
            $pengadilan->jumlah_perkara = $this->count_perkara($pengadilan->id);
        }

        return $pengadilan_list;
    }

    /**
     * Check apakah kode pengadilan sudah digunakan
     * 
     * @param string $kode
     * @param int|null $exclude_id ID yang dikecualikan (untuk update)
     * @return bool
     */
    public function is_kode_exists($kode, $exclude_id = null)
    {
        $this->db->where('kode', $kode);
        if ($exclude_id !== null) {
            $this->db->where('id !=', $exclude_id);
        }
        return $this->db->count_all_results($this->table) > 0;
    }

    /**
     * Get dropdown options untuk select box
     * 
     * @param bool $aktif_only
     * @return array Key-value pair [id => nama_pengadilan]
     */
    public function get_dropdown($aktif_only = true)
    {
        $pengadilan_list = $this->get_all($aktif_only);
        $dropdown = [];

        foreach ($pengadilan_list as $pengadilan) {
            $dropdown[$pengadilan->id] = $pengadilan->nama_pengadilan;
        }

        return $dropdown;
    }

    /**
     * Aktivasi atau deaktivasi pengadilan
     * 
     * @param int $id
     * @param string $status 'Y' atau 'N'
     * @return bool
     */
    public function set_status($id, $status)
    {
        // Hanya update jika kolom aktif ada
        if (!$this->_column_exists('aktif')) {
            return false; // Tidak bisa set status jika kolom tidak ada
        }

        $status = ($status === 'Y') ? 'Y' : 'N';
        return $this->update($id, ['aktif' => $status]);
    }
}
