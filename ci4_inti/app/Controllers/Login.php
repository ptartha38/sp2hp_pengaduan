<?php

namespace App\Controllers;

use Config\Services;
use CodeIgniter\Controller;
use App\Models\sp2hpModel;

class Login extends BaseController
{
    public $output = [
        'sukses'    => false,
        'pesan'     => '',
        'data'      => [],
    ];

    public function index()
    {
        $data = [];
        echo view('login/index.php', $data);
    }
    public function blokir_kendaraan()
    {
        echo view('login/blokir_kendaraan.php');
    }
    public function hilang_stnk()
    {
        echo view('login/hilang_stnk.php');
    }
    public function rck()
    {
        echo view('login/rck.php');
    }
    public function cari_sp2hp()
    {
        $request = Services::request();
        $model = new sp2hpModel($request);
        if ($request->getMethod(true) == 'POST') {
            $data = $model->cari_data();
            if ($data) {
                $this->output['sukses'] = true;
                $this->output['pesan']  = 'Data ditemukan';
                $this->output['data']   = $data;
            }
            echo json_encode($this->output);
        }
    }
}
