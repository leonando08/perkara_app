<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * @property Perkara_model $Perkara_model
 * @property CI_Session $session
 * @property CI_Input $input
 * @property CI_DB_query_builder $db
 */
class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Perkara_model');
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->helper('form');

        // Hanya user yang bisa akses
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') != 'user') {
            redirect('auth/login');
        }
    }

    public function edit($id = null)
    {
        if ($id === null) {
            show_404();
        }

        // Ambil data perkara
        $data['perkara'] = $this->db->get_where('perkara_banding', ['id' => $id])->row();

        if ($data['perkara'] === null) {
            show_404();
        }

        if ($this->input->method() === 'post') {
            // Handle empty dates by setting them to NULL
            $tgl_register = $this->input->post('tgl_register_banding');
            $pemberitahuan_putusan = $this->input->post('pemberitahuan_putusan_banding');
            $permohonan_kasasi = $this->input->post('permohonan_kasasi');
            $pengiriman_berkas = $this->input->post('pengiriman_berkas_kasasi');

            $update_data = [
                'asal_pengadilan' => $this->input->post('asal_pengadilan'),
                'perkara' => $this->input->post('perkara'),
                'nomor_perkara_tk1' => $this->input->post('nomor_perkara_tk1'),
                'klasifikasi' => $this->input->post('klasifikasi'),
                'tgl_register_banding' => $tgl_register ?: null,
                'nomor_perkara_banding' => $this->input->post('nomor_perkara_banding'),
                'lama_proses' => $this->input->post('lama_proses'),
                'status_perkara_tk_banding' => $this->input->post('status_perkara_tk_banding'),
                'pemberitahuan_putusan_banding' => $pemberitahuan_putusan ?: null,
                'permohonan_kasasi' => $permohonan_kasasi ?: null,
                'pengiriman_berkas_kasasi' => $pengiriman_berkas ?: null,
                'status' => $this->input->post('status')
            ];

            // Validasi data yang required
            if (empty($update_data['asal_pengadilan']) || empty($update_data['nomor_perkara_tk1']) || empty($update_data['klasifikasi']) || empty($update_data['perkara'])) {
                $this->session->set_flashdata('error', 'Asal Pengadilan, Jenis Perkara, Nomor Perkara Tk1, dan Klasifikasi harus diisi');
                redirect('user/edit/' . $id);
                return;
            }

            $this->db->where('id', $id);
            if ($this->db->update('perkara_banding', $update_data)) {
                $this->session->set_flashdata('success', 'Data perkara berhasil diperbarui');
                redirect('user/dashboard_user');
            } else {
                $this->session->set_flashdata('error', 'Gagal memperbarui data perkara');
                redirect('user/edit/' . $id);
            }
        }

        // Ambil data jenis perkara untuk datalist
        $data['jenis_perkara'] = $this->Perkara_model->getAllJenisPerkara();

        $this->load->view('user/edit_perkara', $data);
    }

    public function hapus($id = null)
    {
        if ($id === null) {
            show_404();
        }

        // Cek apakah data ada
        $perkara = $this->db->get_where('perkara_banding', ['id' => $id])->row();
        if ($perkara === null) {
            $this->session->set_flashdata('error', 'Data perkara tidak ditemukan');
            redirect('user/dashboard_user');
            return;
        }

        // Hapus data
        if ($this->db->delete('perkara_banding', ['id' => $id])) {
            $this->session->set_flashdata('success', 'Data perkara berhasil dihapus');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus data perkara');
        }

        redirect('user/dashboard_user');
    }

    public function dashboard_user()
    {
        // Ambil input pencarian
        $filters = [
            'asal_pengadilan' => $this->input->get('cari_pengadilan', TRUE),
            'klasifikasi'     => $this->input->get('cari_klasifikasi', TRUE),
            'perkara'         => $this->input->get('perkara', TRUE),
            'user_id'         => $this->session->userdata('user_id') // Filter berdasarkan user yang login
        ];

        // Get filtered data using model
        $data['perkaras'] = $this->Perkara_model->get_filtered($filters);
        $data['filters'] = $filters;

        $this->load->view('navbar/header');
        $this->load->view('user/dashboard_user', $data);
        $this->load->view('navbar/footer');
    }
}
