<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Model untuk tabel perkara_banding
 *
 * @property CI_DB_query_builder $db
 */
class Perkara_model extends CI_Model
{
    private $table = 'perkara_banding';

    public function __construct()
    {
        parent::__construct();
    }

    // Ambil semua data perkara
    public function get_all()
    {
        return $this->db
            ->order_by('id', 'ASC')
            ->get($this->table)
            ->result(); // object
    }

    // Ambil data perkara berdasarkan id
    public function getById($id)
    {
        return $this->db
            ->get_where($this->table, ['id' => $id])
            ->row(); // object
    }

    // Ambil data dengan filter
    public function get_filtered($filters = [])
    {
        if (!empty($filters['bulan'])) {
            $this->db->like('tgl_register_banding', $filters['bulan'], 'after');
        }
        if (!empty($filters['asal_pengadilan'])) {
            $this->db->like('asal_pengadilan', $filters['asal_pengadilan']);
        }
        if (!empty($filters['klasifikasi'])) {
            $this->db->like('klasifikasi', $filters['klasifikasi']);
        }
        if (!empty($filters['status'])) {
            $this->db->like('status', $filters['status']); // pastikan sesuai kolom status di database
        }
        if (!empty($filters['user_id'])) {
            $this->db->where('user_id', $filters['user_id']);
        }

        return $this->db
            ->order_by('id', 'ASC')
            ->get($this->table)
            ->result(); // kembalikan array of objects
    }


    // Tambah data
    public function add($data)
    {
        return $this->db->insert($this->table, $data);
    }

    // Update data
    public function update($id, $data)
    {
        return $this->db
            ->where('id', $id)
            ->update($this->table, $data);
    }

    // Hapus data
    public function delete($id)
    {
        return $this->db
            ->where('id', $id)
            ->delete($this->table);
    }

    // Hitung perkara besok
    public function count_besok()
    {
        $besok = date('Y-m-d', strtotime('+1 day'));
        return $this->db
            ->where('permohonan_kasasi', $besok)
            ->where('status', 'Proses')
            ->count_all_results($this->table);
    }

    // Hitung perkara terlambat
    public function count_terlambat()
    {
        $hariIni = date('Y-m-d');
        return $this->db
            ->where('permohonan_kasasi <', $hariIni)
            ->where('status', 'Proses')
            ->count_all_results($this->table);
    }

    // Cari berdasarkan asal pengadilan
    public function search_by_pengadilan($keyword)
    {
        return $this->db
            ->like('asal_pengadilan', $keyword)
            ->order_by('id', 'ASC')
            ->get($this->table)
            ->result(); // object
    }

    // Ambil berdasarkan bulan
    public function get_by_month($bulan)
    {
        return $this->db
            ->like('tgl_register_banding', $bulan, 'after')
            ->get($this->table)
            ->result(); // object
    }
}
