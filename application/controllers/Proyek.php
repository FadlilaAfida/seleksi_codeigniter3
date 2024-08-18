<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Proyek extends CI_Controller
{
    public function tambah_proyek()
    {
        $this->load->view('proyek/tambah_proyek');
    }

    public function ubah_proyek($id_proyek)
    {
        $this->load->view('proyek/ubah_proyek', [
            'id_proyek' => $id_proyek
        ]);
    }
}
