<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Perkara_model extends CI_Model
{
    private $table = 'perkara_banding';

    public function __construct()
    {
        parent::__construct();
    }

    public function get_all_perkara()
    {
        return $this->db->get($this->table)->result_array();
    }

    public function count_besok()
    {
        $besok = date('Y-m-d', strtotime('+1 day'));
        $this->db->where('permohonan_kasasi', $besok);
        $this->db->where('status', 'Proses');
        return $this->db->count_all_results($this->table);
    }

    public function count_terlambat()
    {
        $hariIni = date('Y-m-d');
        $this->db->where('permohonan_kasasi <', $hariIni);
        $this->db->where('status', 'Proses');
        return $this->db->count_all_results($this->table);
    }

    public function get_all()
    {
        return $this->db->order_by('id', 'ASC')->get($this->table)->result_array();
    }

    public function get_by_id($id)
    {
        return $this->db->get_where($this->table, ['id' => $id])->row_array();
    }

    public function get_filtered($filters)
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
            $this->db->like('status_perkara_tk_banding', $filters['status']);
        }

        return $this->db->order_by('id', 'ASC')->get($this->table)->result_array();
    }

    public function add($data)
    {
        return $this->db->insert($this->table, $data);
    }

    public function update($id, $data)
    {
        return $this->db->where('id', $id)
            ->update($this->table, $data);
    }

    public function delete($id)
    {
        return $this->db->where('id', $id)
            ->delete($this->table);
    }

    public function search_by_pengadilan($keyword)
    {
        return $this->db->like('asal_pengadilan', $keyword)
            ->order_by('id', 'ASC')
            ->get($this->table)
            ->result_array();
    }

    public function get_by_month($bulan)
    {
        return $this->db->like('tgl_register_banding', $bulan, 'after')
            ->get($this->table)
            ->result_array();
    }
}
