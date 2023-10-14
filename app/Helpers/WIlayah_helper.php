<?php

use App\Models\WilayahModel;
use App\Models\WilayahUserModel;
use CodeIgniter\Shield\Entities\User;

function wilayah_user (User $user){
    $wilayah = new WilayahModel();
    $wilayah_user = new WilayahUserModel();
    $usergroup = $wilayah_user->getWilayah($user->id);
    if ($user->inGroup('operator') || $user->inGroup('verifikator')){
        $desa = $wilayah->find($usergroup);
        $kode_kab = substr($usergroup,2,2);
        $kab = $wilayah->namaKab($kode_kab);
        return $desa['nama_desa'].', '.$kab[0]['nama_kab'];
    }
    else if ($user->inGroup('adminkab')){
        $kode_kab = substr($usergroup,2,2);
        $kab = $wilayah->namaKab($kode_kab);
        return $kab[0]['nama_kab'];
    }
    else if ($user->inGroup('superadmin')){
        $kode_prov = substr($usergroup,0,2);
        $prov = $wilayah->namaProv($kode_prov);
        return $prov[0]['nama_prov'];
    }
    return false;
}