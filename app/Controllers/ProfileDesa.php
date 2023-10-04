<?php

namespace App\Controllers;
use App\Models\WilayahModel;
use App\Models\WilayahUserModel;
use App\Models\ProfilDesaModel;

class ProfileDesa extends BaseController
{
    public function index()
    {
        $user = new WilayahUserModel();
        $wilayah = new WilayahModel();
        $id = auth()->getUser()->id;
        $info_desa = $wilayah->find($user->getWilayah($id));

        $profil = new ProfilDesaModel();
        $profil_desa = $profil->nowProfil($info_desa['kode_desa']);

        $data = ['info_desa' => $info_desa, 'profil_desa'=>$profil_desa];
        return view('profile_desa', $data);
    }

    public function pengajuan()
    {
        $wilayah = new WilayahModel();
        $user = new WilayahUserModel();
        $profil = new ProfilDesaModel();
        $info_desa = $wilayah->find($user->getWilayah(auth()->getUser()->id));
        $profil_desa = $profil->nowProfil(($wilayah->find($user->getWilayah(auth()->getUser()->id)))['kode_desa']);
        $data = ['info_desa' => $info_desa, 'profil_desa'=>$profil_desa];

        $profil->insert([
            'kode_desa'=> ($wilayah->find($user->getWilayah(auth()->getUser()->id)))['kode_desa'],
            'alamat' => $this->request->getPost('alamat'), 
            'email' => $this->request->getPost('email'), 
            'telp' => $this->request->getPost('telp'), 
            'info_umum' => $this->request->getPost('info'), 
            'html_tag'=> $this->request->getPost('maps'),
            'approval'=> 'diajukan'
        ]);
        
        return view('dashboard');
    }
}
