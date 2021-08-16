<?php

namespace App\Controllers;

use Config\Services;
use CodeIgniter\Controller;
use App\Models\anggotaModel;

class anggota extends BaseController
{
    public $output = [
        'sukses'    => false,
        'pesan'     => '',
        'data'      => [],
    ];

    public function data_anggota()
    {
        $session = session();
        $db = \Config\Database::connect();
        $builder = $db->table('personel')->get();
        $data_anggota = $builder->getResultArray();
        $data = [
            'judul' => 'DATA ANGGOTA POLRES SUMBAWA',
            'isi'   => 'data_anggota/data_anggota.php',
            'data_personel' => $data_anggota,
            'session' => $session
        ];
        echo view('layout/v_wrapper', $data);
    }
    public function form_insert()
    {
        $session = session();
        $data = [
            'judul' => 'INPUT ANGGOTA POLRES SUMBAWA',
            'isi'   => 'data_anggota/form_insert_anggota.php',
            'session' => $session,
            'validation' => \Config\Services::validation()
        ];
        echo view('layout/v_wrapper', $data);
    }
    public function insert_data_personel()
    {
        helper('form');
        if (!$this->validate([
            'nama' => [
                'rules' => 'required|is_unique[personel.nama]',
                'errors' => [
                    'required' => 'Nama Harus Diisi dong Bos',
                    'is_unique' => 'Nama Anggota Sudah diinput Sebelumnya',
                ]
            ],
            'nrp' => [
                'rules' => 'required|is_unique[personel.nrp]',
                'errors' => [
                    'required' => 'NRP Harus Diisi',
                    'is_unique' => 'NRP Anggota Sudah diinput Sebelumnya',
                ]
            ],
            'pangkat' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Pangkat Harus Dipilih',
                ]
            ],
            'jabatan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Jabatan Harus Dipilih',
                ]
            ],
            'type' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Golongan Harus Dipilih',
                ]
            ],
            'telp' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'No Handphone Harus Diisi',
                ]
            ],
            'username' => [
                'rules' => 'required|is_unique[personel.username]',
                'errors' => [
                    'required' => 'Username Harus Diisi',
                    'is_unique' => 'Username Sudah diinput Sebelumnya',
                ]
            ],
            'password' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Password Harus Diisi',
                ]
            ],
            'foto' => [
                'rules' => 'max_size[foto,1048]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Ukuran Gambar tidak Boleh Lebih dari 1 MB',
                    'is_image' => 'Gambar / Foto Harus Berformat JPG dan PNG',
                    'mime_in' => 'Gambar / Foto Harus Berformat JPG dan PNG'
                ]
            ],
        ])) {
            // $validation = \Config\Services::validation();
            // return redirect()->to(base_url() . '/anggota/form_insert')->withInput()->with('validation', $validation);
            return redirect()->to(base_url() . '/anggota/form_insert')->withInput();
        }
        $request = Services::request();
        $anggota_model = new anggotaModel($request);
        $foto = $this->request->getFile('foto');
        if ($foto != "") {
            $nama_baru = $foto->getRandomName();
            $foto->move('assets/uploads/ft', $nama_baru);
        } else {
            $nama_baru = "";
        }
        $data = [
            'nama' => $this->request->getVar('nama'),
            'nrp' => $this->request->getVar('nrp'),
            'pangkat' => $this->request->getVar('pangkat'),
            'jabatan' => $this->request->getVar('jabatan'),
            'type' => $this->request->getVar('type'),
            'username' => $this->request->getVar('username'),
            'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
            'telp' => $this->request->getVar('telp'),
            'foto' => $nama_baru
        ];
        $simpan = $anggota_model->insert_anggota($data);
        if ($simpan) {
            return redirect()->to(base_url() . '/anggota/form_insert')->with('status', 'Data Anggota Berhasil di Simpan');
        }
    }
    public function hapus()
    {
        helper('filesystem');
        $request = Services::request();
        $id_anggota = $this->request->getVar('delete_id');
        $nama_file = $this->request->getVar('nama_file');
        if ($nama_file != null) {
            $delete_foto =  unlink('assets/uploads/ft/' . $nama_file);
        } else {
            $delete_foto = "";
        }
        $anggota_model = new anggotaModel($request);
        if ($request->getMethod(true) == 'POST') {
            $hapus_anggota = $anggota_model->hapus_anggota($id_anggota);
            if ($hapus_anggota) {
                $this->output['sukses'] = true;
                $this->output['pesan']  = 'Data telah dihapus';
            }
            echo json_encode($this->output);
        }
    }
    public function edit()
    {
        $request = Services::request();
        $anggotaModel = new anggotaModel($request);
        if ($request->getMethod(true) == 'POST') {
            $res = $anggotaModel->edit();
            $foto = $res->foto;
            if ($foto != null) {
                $gambar = $foto;
            } else {
                $gambar = "res.png";
            };
            if ($res) {
                $this->output['sukses'] = true;
                $this->output['pesan']  = 'Data ditemukan';
                $this->output['data']   = $res;
                $this->output['data2']   = $gambar;
            }
            echo json_encode($this->output);
        }
    }
    public function update_data_personel()
    {
        helper('filesystem');
        $request = Services::request();
        $anggota_model = new anggotaModel($request);
        $nama_foto = $this->request->getVar('nama_foto');
        $foto = $this->request->getFile('foto');
        if ($nama_foto && $foto != "") {
            if (is_file('assets/uploads/ft/' . $nama_foto))
                unlink('assets/uploads/ft/' . $nama_foto);
            $nama = $foto->getRandomName();
            $foto->move('assets/uploads/ft', $nama);
        } else if ($foto  != "") {
            $nama = $foto->getRandomName();
            $foto->move('assets/uploads/ft', $nama);
        } else if ($nama_foto != "") {
            $nama = $nama_foto;
        } else {
            $nama = "";
        }

        if ($request->getMethod(true) == 'POST') {
            $data = [
                'nama' => $this->request->getVar('nama'),
                'nrp' => $this->request->getVar('nrp'),
                'pangkat' => $this->request->getVar('pangkat'),
                'jabatan' => $this->request->getVar('jabatan'),
                'type' => $this->request->getVar('type'),
                'username' => $this->request->getVar('username'),
                'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
                'telp' => $this->request->getVar('telp'),
                'foto' => $nama
            ];
            $id_update = $this->request->getVar('id_update');
            $ubah = $anggota_model->ubah($data, $id_update);
            if ($ubah) {
                return redirect()->to(base_url() . '/anggota/data_anggota')->with('status', 'Data Anggota Berhasil di Simpan');
            }
        }
    }

    public function update_data_pribadi()
    {
        helper('filesystem');
        $request = Services::request();
        $anggota_model = new anggotaModel($request);

        if ($request->getMethod(true) == 'POST') {
            $data = [
                'username' => $this->request->getVar('username_pribadi'),
                'password' => password_hash($this->request->getVar('password_pribadi'), PASSWORD_DEFAULT),
                'telp' => $this->request->getVar('telp_pribadi'),
            ];
            $id_update = $this->request->getVar('id_update_pribadi');
            $ubah = $anggota_model->ubah($data, $id_update);
            if ($ubah) {
                return redirect()->to(base_url('login/logout'));
            }
        }
    }
}
