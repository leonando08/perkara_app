<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_Input $input
 * @property CI_Session $session
 * @property Perkara_model $Perkara_model
 * @property CI_DB_query_builder $db
 */
class Perkara extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Perkara_model');
        $this->load->helper('url');
        $this->load->library('session');

        // Contoh validasi session admin
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') != 'admin') {
            redirect('auth/login');
        }
    }

    // Dashboard / list data
    public function dashboard()
    {
        $filters = [
            'bulan'            => $this->input->get('bulan'),
            'asal_pengadilan'  => $this->input->get('cari_pengadilan'),
            'klasifikasi'      => $this->input->get('cari_klasifikasi'),
            'status'           => $this->input->get('status')
        ];

        $data['perkaras'] = $this->Perkara_model->get_filtered($filters);
        $this->load->view('perkara/dashboard', $data);
    }

    // Tambah data
    public function tambah()
    {
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $data = $this->input->post();
            $this->Perkara_model->add($data);
            redirect('perkara/dashboard');
        }

        $this->load->view('perkara/tambah');
    }

    // Edit data
    public function edit($id = null)
    {
        if (!$id) show_404();

        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $data = $this->input->post();
            $this->Perkara_model->update($id, $data);
            redirect('perkara/dashboard');
        }

        $data['perkara'] = $this->Perkara_model->get_by_id($id);
        $this->load->view('perkara/edit', $data);
    }

    // Hapus data
    public function hapus($id = null)
    {
        if (!$id) show_404();
        $this->Perkara_model->delete($id);
        redirect('perkara/dashboard');
    }
}
