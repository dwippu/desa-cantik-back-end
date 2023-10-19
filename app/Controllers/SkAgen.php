<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SkAgenModel;
use App\Models\PengajuanSkAgenModel;
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
        if(auth()->user()->inGroup('adminkab')){
            $kode_kab = substr($kode_desa,0,4);
            $sk_agen = $sk->getSkAgenBykab($kode_kab);
        }else{
            $sk_agen = $sk->getSkAgen($kode_desa);
        }
        $data = ['sk_agen'=>$sk_agen];
        return view('sk_agen', $data);
    }

    public function hapus($id){
        $wilayah = new WilayahModel();
        $user = new WilayahUserModel();
        $sk = new SkAgenModel();
        $sk_pengajuan = new PengajuanSkAgenModel();
        $sk_agen = $sk->find($id);

        if($sk_pengajuan->cekEdit($id)!=null){
            session()->setFlashdata('validation', 'Terdapat Pengajuan Hapus untuk SK ini');
            return redirect('daftarskagenstatistik');
        };
        
        if($sk_pengajuan->cekHapus($id)==null){
            $sk_pengajuan->save([
                'user_id' => auth()->getUser()->id,
                'kode_desa'=> ($wilayah->find($user->getWilayah(auth()->getUser()->id)))['kode_desa'],
                'id_sk' => $id,
                'nomor_sk' => $sk_agen['nomor_sk'],
                'tanggal_sk' => $sk_agen['tanggal_sk'],
                'file' => $sk_agen['file'],
                'approval' => 'Hapus SK Diajukan',
                'tanggal_pengajuan' => date('Y-m-d H:i:s')
            ]);
        }else{
            session()->setFlashdata('validation', 'Pengajuan Hapus untuk SK ini sudah ada');
        };

        return redirect('daftarskagenstatistik');
    }
}
