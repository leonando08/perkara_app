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
        $this->load->library('session');
    }

    /**
     * Helper method untuk menambahkan filter pengadilan secara otomatis
     * Dipanggil oleh semua method query untuk isolasi data per pengadilan
     */
    private function apply_pengadilan_filter()
    {
        // Super admin bisa melihat semua data
        if ($this->session->userdata('role') === 'super_admin') {
            return;
        }

        // PERBAIKAN: Gunakan pengadilan_id yang lebih akurat
        $pengadilan_id = $this->session->userdata('pengadilan_id');
        $nama_pengadilan = $this->session->userdata('nama_pengadilan');

        // Log untuk debugging
        log_message('debug', "Filter pengadilan - ID: {$pengadilan_id}, Nama: {$nama_pengadilan}");

        if ($pengadilan_id) {
            // Cek apakah kolom pengadilan_id ada di tabel perkara_banding
            $fields = $this->db->list_fields($this->table);

            if (in_array('pengadilan_id', $fields)) {
                // Jika ada kolom pengadilan_id, gunakan itu (lebih akurat)
                $this->db->where('pb.pengadilan_id', $pengadilan_id);
            } elseif ($nama_pengadilan) {
                // Fallback: gunakan nama_pengadilan dengan filter LIKE untuk menangani variasi nama
                // Support untuk SEMUA 13 Pengadilan Negeri di Kalimantan Selatan
                $keyword = $this->_extract_pengadilan_keyword($nama_pengadilan);

                if ($keyword) {
                    $this->db->where("(pb.asal_pengadilan LIKE '%{$keyword}%' OR pb.asal_pengadilan = '{$nama_pengadilan}')");
                    log_message('debug', "Filter menggunakan keyword: {$keyword}");
                } else {
                    $this->db->where('pb.asal_pengadilan', $nama_pengadilan);
                }
            }
        }
    }

    /**
     * Extract keyword dari nama pengadilan untuk filter yang lebih robust
     * Mendukung 13 Pengadilan Negeri di Kalimantan Selatan
     */
    private function _extract_pengadilan_keyword($nama_pengadilan)
    {
        // Convert ke uppercase untuk matching yang konsisten
        $nama_upper = strtoupper($nama_pengadilan);

        // Daftar keyword untuk 13 Pengadilan Negeri + 1 Pengadilan Tinggi
        $pengadilan_keywords = [
            'BANJARMASIN' => 'BANJARMASIN',
            'BANJARBARU'  => 'BANJARBARU',
            'KANDANGAN'   => 'KANDANGAN',
            'MARTAPURA'   => 'MARTAPURA',
            'KOTABARU'    => 'KOTABARU',
            'BARABAI'     => 'BARABAI',
            'AMUNTAI'     => 'AMUNTAI',
            'TANJUNG'     => 'TANJUNG',
            'RANTAU'      => 'RANTAU',
            'PELAIHARI'   => 'PELAIHARI',
            'MARABAHAN'   => 'MARABAHAN',
            'BATULICIN'   => 'BATULICIN',
            'PARINGIN'    => 'PARINGIN',
            // Pengadilan Tinggi
            'TINGGI'      => 'TINGGI'
        ];

        // Cari keyword yang match
        foreach ($pengadilan_keywords as $key => $value) {
            if (strpos($nama_upper, $key) !== false) {
                return $value;
            }
        }

        // Fallback: ambil kata terakhir dari nama pengadilan
        $parts = explode(' ', $nama_pengadilan);
        return strtoupper(end($parts));
    }

    // ======================
    // Ambil semua data
    // ======================
    public function get_all()
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
            ')
            ->from($this->table . ' pb');

        // Apply filter pengadilan untuk isolasi data
        $this->apply_pengadilan_filter();

        return $this->db->order_by('pb.id', 'ASC')
            ->get()
            ->result();
    }

    // ======================
    // Ambil data berdasarkan ID
    // ======================
    public function getById($id)
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
            ')
            ->from($this->table . ' pb')
            ->where('pb.id', $id);

        // Apply filter pengadilan untuk isolasi data
        $this->apply_pengadilan_filter();

        return $this->db->get()->row();
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

        // Apply filter pengadilan untuk isolasi data
        $this->apply_pengadilan_filter();

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
        // Auto-assign pengadilan_id dan asal_pengadilan dari session (kecuali super_admin yang bisa pilih manual)
        if ($this->session->userdata('role') !== 'super_admin') {
            // Set pengadilan_id dari session
            if (!isset($data['pengadilan_id'])) {
                $pengadilan_id = $this->session->userdata('pengadilan_id');
                if ($pengadilan_id) {
                    $data['pengadilan_id'] = $pengadilan_id;
                }
            }

            // Set asal_pengadilan dari session (backward compatibility)
            if (!isset($data['asal_pengadilan'])) {
                $nama_pengadilan = $this->session->userdata('nama_pengadilan');
                if ($nama_pengadilan) {
                    $data['asal_pengadilan'] = $nama_pengadilan;
                }
            }
        }

        // Log untuk debugging
        log_message('debug', "Adding perkara with pengadilan_id: " . ($data['pengadilan_id'] ?? 'NULL'));

        return $this->db->insert($this->table, $data);
    }

    // ======================
    // Update data
    // ======================
    public function update($id, $data)
    {
        $this->db->where('id', $id);

        // Apply filter pengadilan untuk keamanan (user tidak bisa update data pengadilan lain)
        if ($this->session->userdata('role') !== 'super_admin') {
            $pengadilan_id = $this->session->userdata('pengadilan_id');
            $nama_pengadilan = $this->session->userdata('nama_pengadilan');

            // Cek apakah kolom pengadilan_id ada
            $fields = $this->db->list_fields($this->table);

            if (in_array('pengadilan_id', $fields) && $pengadilan_id) {
                // Filter berdasarkan pengadilan_id (lebih akurat)
                $this->db->where('pengadilan_id', $pengadilan_id);
            } elseif ($nama_pengadilan) {
                // Fallback: filter berdasarkan nama
                $this->db->where('asal_pengadilan', $nama_pengadilan);
            }
        }

        return $this->db->update($this->table, $data);
    }

    // ======================
    // Hapus data
    // ======================
    public function delete($id)
    {
        $this->db->where('id', $id);

        // Apply filter pengadilan untuk keamanan (user tidak bisa delete data pengadilan lain)
        if ($this->session->userdata('role') !== 'super_admin') {
            $pengadilan_id = $this->session->userdata('pengadilan_id');
            $nama_pengadilan = $this->session->userdata('nama_pengadilan');

            // Cek apakah kolom pengadilan_id ada
            $fields = $this->db->list_fields($this->table);

            if (in_array('pengadilan_id', $fields) && $pengadilan_id) {
                // Filter berdasarkan pengadilan_id (lebih akurat)
                $this->db->where('pengadilan_id', $pengadilan_id);
            } elseif ($nama_pengadilan) {
                // Fallback: filter berdasarkan nama
                $this->db->where('asal_pengadilan', $nama_pengadilan);
            }
        }

        return $this->db->delete($this->table);
    }

    // ======================
    // Hitung perkara besok
    // ======================
    public function count_besok()
    {
        $besok = date('Y-m-d', strtotime('+1 day'));
        $this->db->from($this->table . ' pb');
        $this->db->where('pb.permohonan_kasasi', $besok);
        $this->db->where('pb.status', 'Proses');

        // Apply filter pengadilan_id
        $this->apply_pengadilan_filter();

        return $this->db->count_all_results();
    }

    // ======================
    // Hitung perkara terlambat
    // ======================
    public function count_terlambat()
    {
        $hariIni = date('Y-m-d');
        $this->db->from($this->table . ' pb');
        $this->db->where('pb.permohonan_kasasi <', $hariIni);
        $this->db->where('pb.status', 'Proses');

        // Apply filter pengadilan_id
        $this->apply_pengadilan_filter();

        return $this->db->count_all_results();
    }

    // ======================
    // Cari berdasarkan asal pengadilan
    // ======================
    public function search_by_pengadilan($keyword)
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
            ')
            ->from($this->table . ' pb')
            ->like('pb.asal_pengadilan', $keyword);

        // Apply filter pengadilan
        $this->apply_pengadilan_filter();

        return $this->db->order_by('pb.id', 'ASC')
            ->get()
            ->result();
    }

    // ======================
    // Ambil berdasarkan bulan
    // ======================
    public function get_by_month($bulan)
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
            ')
            ->from($this->table . ' pb')
            ->like('pb.tgl_register_banding', $bulan, 'after');

        // Apply filter pengadilan
        $this->apply_pengadilan_filter();

        return $this->db->order_by('pb.id', 'ASC')
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
