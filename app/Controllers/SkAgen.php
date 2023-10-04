<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SkAgenModel;
use App\Models\WilayahUserModel;
use App\Models\WilayahModel;

class SkAgen extends BaseController
{
    public function index()
    {
        $sk = new SkAgenModel();
        $user = new WilayahUserModel();
        $wilayah = new WilayahModel();
        $kode_desa = $user->getWilayah(auth()->getUser()->id);
        $sk_agen = $sk->getRiwayat($kode_desa);
        $desa = $wilayah->find($kode_desa);

        $data = ['sk_agen'=>$sk_agen, 'desa'=>$desa];
        return view('sk_agen', $data);
    }
}
