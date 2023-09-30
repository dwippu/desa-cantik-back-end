<?php

namespace App\Controllers;
use App\Models\WilayahModel;
use App\Models\WilayahUserModel;
use App\Models\ProfilDesaModel;

class ProfileDesa extends BaseController
{
    public function index()
    {
        $id = auth()->getUser()->id;
        $user = new WilayahUserModel();
        $wilayah = new WilayahModel();
        $info_desa = $wilayah->find($user->getWilayah($id));

        $profil = new ProfilDesaModel();
        $profil_desa = $profil->nowProfil($info_desa['kode_desa']);

        $data = ['info_desa' => $info_desa, 'profil_desa'=>$profil_desa];
        return view('profile_desa', $data);
    }

    public function pengajuan()
    {
        
    }
}
