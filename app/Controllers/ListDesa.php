<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\WilayahModel;

class ListDesa extends BaseController
{
    public function index()
    {
        $desa = new WilayahModel();
        $desa = $desa->findDescan();
        return view('superadmin_pages/list_desa', ['desa' => $desa]);
    }

    public function tambahview()
    {
        echo 'ubah status desa menjadi desa cantik';
    }

    public function desa($kab){
        $desa = new WilayahModel();
        $descan = $desa->findDescanByKab($kab);
        return $this->response->setJSON($descan);
    }

    public function nonaktif(){
        helper('oldpassword');

        $pass = $this->request->getPost('old-password');
        if (!old_password_is_correct($pass)){
            return redirect()->back()->withInput()->with('errors', 'Password Salah!');
        };

        $desa = new WilayahModel();
        $desa->update($this->request->getPost('kode_desa'), ['descan'=>0]);
        
        return redirect()->to('/listdesa')->with('succes', 'Status Desa Cantik Berhasil Dihapus!');
    }

    public function coba(){
        dd($this->request->getPost());
    }
}
