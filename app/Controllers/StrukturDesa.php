<?php

namespace App\Controllers;
use App\Models\WilayahModel;
use App\Models\WilayahUserModel;
use App\Models\PerangkatDesaModel;

class StrukturDesa extends BaseController
{
    public function index(): string
    {
        $perangkat = new PerangkatDesaModel();
        $user = new WilayahUserModel();
        $kode_desa = $user->getWilayah(auth()->getUser()->id);
        if(auth()->user()->inGroup('adminkab')){
            $kode_kab = substr($kode_desa,0,4);
            $perangkat_desa = $perangkat->getRiwayatByKab($kode_kab);
        }elseif(auth()->user()->inGroup('verifikator')){
            $perangkat_desa = $perangkat->getRiwayatByDesa($kode_desa);
        }
        else{
            $perangkat_desa = $perangkat->getRiwayatByOpr($kode_desa, auth()->getUser()->id);
        }
        $data = ['perangkat_desa'=>$perangkat_desa];
        return view('struktur_desa', $data);
    }
}
