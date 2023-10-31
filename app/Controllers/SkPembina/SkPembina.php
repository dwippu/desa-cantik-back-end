<?php

namespace App\Controllers\SkPembina;

use App\Controllers\BaseController;
use App\Models\SkPembinaModel;
use App\Models\WilayahUserModel;
use App\Models\WilayahModel;

class SkPembina extends BaseController
{
    public function index()
    {
        $sk = new SkPembinaModel();
        $user = new WilayahUserModel();
        $wilayah = new WilayahModel();
        $kode_desa = $user->getWilayah(auth()->getUser()->id);
        $kode_kab = substr($kode_desa,0,4);
        $sk_pembina = $sk->getSkPembina($kode_kab);
        $kab =$wilayah->namaKab(substr($kode_desa,2,2));
        $data = ['kab'=>$kab[0]['nama_kab'],'sk_pembina'=>$sk_pembina];
        return view('sk_pembina/sk_pembina', $data);
    }

    public function delete($id){
        $sk = new SkPembinaModel();
        $sk_info = $sk->find($id);
        unlink('SK Pembina/'.($sk_info['file']));
        $sk->delete($id);
        return redirect('skpembina');
    }


}
