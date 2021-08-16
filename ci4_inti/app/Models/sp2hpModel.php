<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\HTTP\RequestInterface;

class sp2hpModel extends Model
{
    protected $table = "pengaduan";
    protected $request;
    protected $db;


    function __construct(RequestInterface $request)
    {
        parent::__construct();
        $this->db = db_connect();
        $this->request = $request;
    }

    public function cari_data()
    {
        $nama = $this->request->getPost('nama_pelapor');
        $hp = $this->request->getPost('nomor_handphone');
        $this->builder = $this->db->table($this->table);
        $query = $this->builder->getWhere(['nama_pelapor' => $nama, 'no_hp_plp' => $hp]);
        return $query->getRow();
    }
}
