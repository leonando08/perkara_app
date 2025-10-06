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

    // ======================
    // Ambil semua data
    // ======================
    public function get_all()
    {
        return $this->db
            ->select('
                pb.id,
                pb.asal_pengadilan,
                pb.perkara,
                pb.nomor_perkara_tk1,
                pb.klasifikasi, 
                pb.tgl_register_banding,
                pb.nomor_perkara_banding,
                pb.lama_proses,
                pb.status_perkara_tk_banding,
                pb.pemberitahuan_putusan_banding,
                pb.permohonan_kasasi,
                pb.pengiriman_berkas_kasasi,
                pb.status
            ')
            ->from($this->table . ' pb')
            ->order_by('pb.id', 'ASC')
            ->get()
            ->result();
    }

    // ======================
    // Ambil data berdasarkan ID
    // ======================
    public function getById($id)
    {
        return $this->db
            ->select('
                pb.id,
                pb.asal_pengadilan,
                pb.perkara,
                pb.nomor_perkara_tk1,
                pb.klasifikasi,
                pb.tgl_register_banding,
                pb.nomor_perkara_banding,
                pb.lama_proses,
                pb.status_perkara_tk_banding,
                pb.pemberitahuan_putusan_banding,
                pb.permohonan_kasasi,
                pb.pengiriman_berkas_kasasi,
                pb.status
            ')
            ->from($this->table . ' pb')
            ->where('pb.id', $id)
            ->get()
            ->row();
    }

    // ======================
    // Ambil data dengan filter (untuk laporan)
    // ======================
    public function get_filtered($filters = [])
    {
        $this->db->select('
            pb.id,
            pb.asal_pengadilan,
            pb.perkara,
            pb.nomor_perkara_tk1,
            pb.klasifikasi,
            pb.tgl_register_banding,
            pb.nomor_perkara_banding,
            pb.lama_proses,
            pb.status_perkara_tk_banding,
            pb.pemberitahuan_putusan_banding,
            pb.permohonan_kasasi,
            pb.pengiriman_berkas_kasasi,
            pb.status
        ');
        $this->db->from($this->table . ' pb');

        if (!empty($filters['bulan'])) {
            $this->db->like('pb.tgl_register_banding', $filters['bulan'], 'after');
        }
        if (!empty($filters['tahun'])) {
            $this->db->where('YEAR(pb.tgl_register_banding)', $filters['tahun']);
        }
        if (!empty($filters['asal_pengadilan'])) {
            $this->db->like('pb.asal_pengadilan', $filters['asal_pengadilan']);
        }
        if (!empty($filters['klasifikasi'])) {
            $this->db->like('pb.klasifikasi', $filters['klasifikasi']);
        }
        if (!empty($filters['status'])) {
            $this->db->like('pb.status', $filters['status']);
        }
        if (!empty($filters['perkara'])) {
            $this->db->where('pb.perkara', $filters['perkara']);
        }
        if (!empty($filters['user_id'])) {
            // Cek apakah kolom user_id ada
            $fields = $this->db->list_fields($this->table);
            if (in_array('user_id', $fields)) {
                $this->db->where('pb.user_id', $filters['user_id']);
            }
        }

        return $this->db->order_by('pb.id', 'ASC')->get()->result();
    }

    // ======================
    // Tambah data
    // ======================
    public function add($data)
    {
        return $this->db->insert($this->table, $data);
    }

    // ======================
    // Update data
    // ======================
    public function update($id, $data)
    {
        return $this->db
            ->where('id', $id)
            ->update($this->table, $data);
    }

    // ======================
    // Hapus data
    // ======================
    public function delete($id)
    {
        return $this->db
            ->where('id', $id)
            ->delete($this->table);
    }

    // ======================
    // Hitung perkara besok
    // ======================
    public function count_besok()
    {
        $besok = date('Y-m-d', strtotime('+1 day'));
        return $this->db
            ->where('permohonan_kasasi', $besok)
            ->where('status', 'Proses')
            ->count_all_results($this->table);
    }

    // ======================
    // Hitung perkara terlambat
    // ======================
    public function count_terlambat()
    {
        $hariIni = date('Y-m-d');
        return $this->db
            ->where('permohonan_kasasi <', $hariIni)
            ->where('status', 'Proses')
            ->count_all_results($this->table);
    }

    // ======================
    // Cari berdasarkan asal pengadilan
    // ======================
    public function search_by_pengadilan($keyword)
    {
        return $this->db
            ->select('
                pb.id,
                pb.asal_pengadilan,
                pb.perkara,
                pb.nomor_perkara_tk1,
                pb.klasifikasi,
                pb.tgl_register_banding,
                pb.nomor_perkara_banding,
                pb.lama_proses,
                pb.status_perkara_tk_banding,
                pb.pemberitahuan_putusan_banding,
                pb.permohonan_kasasi,
                pb.pengiriman_berkas_kasasi,
                pb.status
            ')
            ->from($this->table . ' pb')
            ->like('pb.asal_pengadilan', $keyword)
            ->order_by('pb.id', 'ASC')
            ->get()
            ->result();
    }

    // ======================
    // Ambil berdasarkan bulan
    // ======================
    public function get_by_month($bulan)
    {
        return $this->db
            ->select('
                pb.id,
                pb.asal_pengadilan,
                pb.perkara,
                pb.nomor_perkara_tk1,
                pb.klasifikasi,
                pb.tgl_register_banding,
                pb.nomor_perkara_banding,
                pb.lama_proses,
                pb.status_perkara_tk_banding,
                pb.pemberitahuan_putusan_banding,
                pb.permohonan_kasasi,
                pb.pengiriman_berkas_kasasi,
                pb.status
            ')
            ->from($this->table . ' pb')
            ->like('pb.tgl_register_banding', $bulan, 'after')
            ->order_by('pb.id', 'ASC')
            ->get()
            ->result();
    }

    public function getAllJenisPerkara()
    {
        return $this->db
            ->select('nama')
            ->from('jenis_perkara')
            ->where('aktif', 'Y')
            ->order_by('nama', 'ASC')
            ->get()
            ->result();
    }
}
