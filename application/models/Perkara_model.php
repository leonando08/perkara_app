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
    // Ambil semua data dengan parent name
    // ======================
    public function get_all()
    {
        return $this->db
            ->select('
                pb.id,
                pb.asal_pengadilan,
                pb.nomor_perkara_tk1,
                pb.parent,
                jp.nama as parent_nama,
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
            ->join('jenis_perkara jp', 'pb.parent = jp.id', 'left')
            ->order_by('pb.id', 'ASC')
            ->get()
            ->result();
    }

    // ======================
    // Ambil data berdasarkan ID dengan parent name
    // ======================
    public function getById($id)
    {
        return $this->db
            ->select('
                pb.id,
                pb.asal_pengadilan,
                pb.nomor_perkara_tk1,
                pb.parent,
                jp.nama as parent_nama,
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
            ->join('jenis_perkara jp', 'pb.parent = jp.id', 'left')
            ->where('pb.id', $id)
            ->get()
            ->row();
    }

    // ======================
    // Ambil data dengan filter (untuk laporan) dengan parent name
    // ======================
    public function get_filtered($filters = [])
    {
        $this->db->select('
            pb.id,
            pb.asal_pengadilan,
            pb.nomor_perkara_tk1,
            pb.parent,
            jp.nama as parent_nama,
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
        $this->db->join('jenis_perkara jp', 'pb.parent = jp.id', 'left');

        if (!empty($filters['bulan'])) {
            $this->db->like('pb.tgl_register_banding', $filters['bulan'], 'after');
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
        if (!empty($filters['parent'])) {
            $this->db->where('pb.parent', $filters['parent']);
        }
        if (!empty($filters['user_id'])) {
            // Cek apakah kolom user_id ada
            $fields = $this->db->list_fields($this->table);
            if (in_array('user_id', $fields)) {
                $this->db->where('pb.user_id', $filters['user_id']);
            }
        }

        // Pastikan data terfilter berdasarkan parent yang aktif
        $this->db->where('(jp.aktif = "Y" OR jp.aktif IS NULL)');

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
    // Cari berdasarkan asal pengadilan dengan parent name
    // ======================
    public function search_by_pengadilan($keyword)
    {
        return $this->db
            ->select('
                pb.id,
                pb.asal_pengadilan,
                pb.nomor_perkara_tk1,
                pb.parent,
                jp.nama as parent_nama,
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
            ->join('jenis_perkara jp', 'pb.parent = jp.id', 'left')
            ->like('pb.asal_pengadilan', $keyword)
            ->where('(jp.aktif = "Y" OR jp.aktif IS NULL)')
            ->order_by('pb.id', 'ASC')
            ->get()
            ->result();
    }

    // ======================
    // Ambil berdasarkan bulan dengan parent name
    // ======================
    public function get_by_month($bulan)
    {
        return $this->db
            ->select('
                pb.id,
                pb.asal_pengadilan,
                pb.nomor_perkara_tk1,
                pb.parent,
                jp.nama as parent_nama,
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
            ->join('jenis_perkara jp', 'pb.parent = jp.id', 'left')
            ->like('pb.tgl_register_banding', $bulan, 'after')
            ->where('(jp.aktif = "Y" OR jp.aktif IS NULL)')
            ->order_by('pb.id', 'ASC')
            ->get()
            ->result();
    }
}
