<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Lokasi extends CI_Controller
{
    public function tambah_lokasi()
    {
        $this->load->view('lokasi/tambah_lokasi');
    }

    public function ubah_lokasi($id_lokasi)
    {
        $this->load->view('lokasi/ubah_lokasi', [
            'id_lokasi' => $id_lokasi
        ]);
    }
}
