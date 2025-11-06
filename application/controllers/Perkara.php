<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Controller Perkara (Admin & User)
 *
 * @property CI_Input $input
 * @property CI_Session $session
 * @property Perkara_model $Perkara_model
 * @property CI_DB_query_builder $db
 * @property User_model $User_model
 */
class Perkara extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Perkara_model');
        $this->load->model('User_model');
        $this->load->helper(['url', 'form']);
        $this->load->library('session');

        // 🔒 Hanya user login yang boleh masuk
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
    }

    /**
     * Dashboard perkara
     */
    public function dashboard()
    {
        // Get parent list for dropdown
        $data['parents'] = $this->db
            ->where('parent_id IS NULL')
            ->where('aktif', 'Y')
            ->order_by('urutan', 'ASC')
            ->get('jenis_perkara')
            ->result();

        $filters = [
            'bulan'           => $this->input->get('bulan', true),
            'asal_pengadilan' => $this->input->get('cari_pengadilan', true),
            'klasifikasi'     => $this->input->get('cari_klasifikasi', true),
            'status'          => $this->input->get('status', true),
            'parent'          => $this->input->get('parent', true),
        ];

        // kalau user biasa, filter berdasarkan user_id
        if ($this->session->userdata('role') === 'user') {
            $filters['user_id'] = $this->session->userdata('user_id');
        }

        $data['perkaras'] = $this->Perkara_model->get_filtered($filters);
        $data['filters']  = $filters;
        $data['username'] = $this->session->userdata('username');

        $user_id = $this->session->userdata('user_id');
        $data['user'] = $this->User_model->get_by_id($user_id);
        $this->load->view('navbar/header', $data);
        if ($this->session->userdata('role') === 'admin') {
            $this->load->view('admin/dashboard_admin', $data);
        } else {
            $this->load->view('user/dashboard_user', $data);
        }
        $this->load->view('navbar/footer');
    }

    /**
     * Tambah data perkara
     */
    public function tambah()
    {
        $data['error'] = '';
        $data['success'] = '';

        // Ambil data dari tabel jenis_perkara untuk dropdown klasifikasi
        $data['jenis_perkara'] = $this->db
            ->select('id, nama')
            ->where('aktif', 'Y')
            ->order_by('nama', 'ASC')
            ->get('jenis_perkara')
            ->result();

        // Ambil data pengadilan untuk dropdown asal pengadilan
        $data['pengadilan_list'] = $this->db
            ->select('id, nama_pengadilan, kode_pengadilan')
            ->order_by('nama_pengadilan', 'ASC')
            ->get('pengadilan')
            ->result();

        // Cek apakah kolom user_id ada
        $fields = $this->db->list_fields('perkara_banding');
        $has_user_id = in_array('user_id', $fields);
        if ($this->input->post()) {
            // Validasi sederhana
            $required = ['asal_pengadilan', 'klasifikasi', 'tgl_register_banding', 'status'];
            foreach ($required as $field) {
                if (empty($this->input->post($field))) {
                    $data['error'] = "Kolom '" . ucfirst(str_replace("_", " ", $field)) . "' tidak boleh kosong.";
                    break;
                }
            }

            if (empty($data['error'])) {
                $klasifikasi = $this->input->post('klasifikasi');

                $insertData = [
                    'asal_pengadilan'               => $this->input->post('asal_pengadilan'),
                    'nomor_perkara_tk1'             => $this->input->post('nomor_perkara_tk1'),
                    'perkara'                       => $this->input->post('perkara'),
                    'klasifikasi'                   => $klasifikasi,
                    'tgl_register_banding'          => $this->input->post('tgl_register_banding'),
                    'nomor_perkara_banding'         => $this->input->post('nomor_perkara_banding'),
                    'lama_proses'                   => $this->input->post('lama_proses'),
                    'status_perkara_tk_banding'     => $this->input->post('status_perkara_tk_banding'),
                    'pemberitahuan_putusan_banding' => $this->input->post('pemberitahuan_putusan_banding'),
                    'permohonan_kasasi'             => $this->input->post('permohonan_kasasi'),
                    'pengiriman_berkas_kasasi'      => $this->input->post('pengiriman_berkas_kasasi'),
                    'status'                        => $this->input->post('status')
                ];

                // Tambahkan user_id jika kolom ada
                if ($has_user_id) {
                    $insertData['user_id'] = $this->session->userdata('user_id');
                }

                if ($this->Perkara_model->add($insertData)) {
                    $data['success'] = "Data berhasil ditambahkan!";
                } else {
                    $data['error'] = "Gagal menambahkan data.";
                }
            }
        }

        // Ambil nama pengadilan dari session untuk input otomatis
        $data['asal_pengadilan_session'] = $this->session->userdata('nama_pengadilan');

        // Load view
        $this->load->view('perkara/tambah_perkara', $data);
    }

    /**
     * Edit data perkara
     */
    public function edit($id = null)
    {
        if ($id === null) {
            redirect('perkara/dashboard');
        }

        $perkara = $this->Perkara_model->getById($id); // harus ->row() di model
        if (!$perkara) {
            show_404();
        }

        // user hanya boleh edit datanya sendiri
        if (
            $this->session->userdata('role') === 'user' &&
            $perkara->user_id != $this->session->userdata('user_id')
        ) {
            show_error('🚫 Anda tidak berhak mengedit data ini.');
        }

        if ($this->input->method() === 'post') {
            $fields = [
                'asal_pengadilan',
                'nomor_perkara_tk1',
                'klasifikasi',
                'tgl_register_banding',
                'nomor_perkara_banding',
                'lama_proses',
                'status_perkara_tk_banding',
                'pemberitahuan_putusan_banding',
                'permohonan_kasasi',
                'pengiriman_berkas_kasasi',
                'status'
            ];

            $data = [];
            foreach ($fields as $field) {
                $data[$field] = $this->input->post($field, true);
            }

            if ($this->Perkara_model->update($id, $data)) {
                $this->session->set_flashdata('success', '✅ Data berhasil diperbarui.');
                redirect('perkara/dashboard');
            } else {
                $this->session->set_flashdata('error', '❌ Gagal memperbarui data.');
            }
        }

        $data['perkara'] = $perkara;

        // Ambil data pengadilan untuk dropdown
        $data['pengadilan_list'] = $this->db
            ->select('id, nama_pengadilan, kode_pengadilan')
            ->order_by('nama_pengadilan', 'ASC')
            ->get('pengadilan')
            ->result();

        $this->load->view('navbar/header');
        $this->load->view('admin/edit_perkara', $data);
        $this->load->view('navbar/footer');
    }

    public function edit_perkara($id)
    {
        $data['perkara'] = $this->Perkara_model->getById($id);
        $this->load->view('perkara/edit_perkara', $data);
    }

    /**
     * Get jenis perkara for Select2 dropdown
     */
    public function get_jenis_perkara()
    {
        $parent_id = $this->input->get('parent_id');

        $this->db->select('id, nama, nama_lengkap');
        $this->db->from('jenis_perkara');

        if ($parent_id) {
            $this->db->where('parent_id', $parent_id);
        } else {
            $this->db->where('parent_id IS NULL');
        }

        $this->db->where('aktif', 'Y');
        $this->db->order_by('urutan', 'ASC');

        $result = $this->db->get()->result();

        header('Content-Type: application/json');
        echo json_encode($result);
    }


    /**
     * Hapus data perkara
     */
    public function hapus($id = null)
    {
        if (!$id) {
            show_404();
        }

        $perkara = $this->Perkara_model->getById($id); // harus ->row() di model
        if (!$perkara) {
            show_404();
        }

        // user hanya bisa hapus data miliknya
        if (
            $this->session->userdata('role') === 'user' &&
            $perkara->user_id != $this->session->userdata('user_id')
        ) {
            show_error('🚫 Anda tidak berhak menghapus data ini.');
        }

        if ($this->Perkara_model->delete($id)) {
            $this->session->set_flashdata('success', '✅ Data berhasil dihapus.');
        } else {
            $this->session->set_flashdata('error', '❌ Gagal menghapus data.');
        }

        redirect('perkara/dashboard');
    }
}
