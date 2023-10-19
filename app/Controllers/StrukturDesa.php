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
            $perangkat_desa = $perangkat->getPerangkatByKab($kode_kab);
        }else{
            $perangkat_desa = $perangkat->getPerangkatByOpr($kode_desa);
        }
        $data = ['perangkat_desa'=>$perangkat_desa];
        return view('struktur_desa', $data);
    }

    public function edit($id){
        $perangkat = new PerangkatDesaModel();
        $wilayah = new WilayahModel();
        $user = new WilayahUserModel();
        $approval="";
        if ($this->request->getVar('statusAktif') == "Non-Aktifkan"){
            $approval="Non-Aktifkan Diajukan";
        }elseif ($this->request->getVar('statusAktif') == "Aktifkan"){
            $approval="Aktifkan Diajukan";
        };
        $data = $perangkat->find($id);

        $kondisi = $perangkat->validasiPengajuan(($wilayah->find($user->getWilayah(auth()->getUser()->id)))['kode_desa'], $data['nama'], $data['jabatan'], $id);
        if ($kondisi!=null){
            session()->setFlashdata('validationExist', 'Ada Pengajuan Lain yang Belum Disetujui');
        }else{
            $perangkat->save([
                'user_id' => auth()->getUser()->id,
                'kode_desa'=> ($wilayah->find($user->getWilayah(auth()->getUser()->id)))['kode_desa'],
                'nama' => $data['nama'], 
                'email' => $data['email'], 
                'instagram' => $data['instagram'], 
                'jabatan' => $data['jabatan'],
                'gambar' => $data['gambar'],
                'approval' => $approval,
                'tanggal_pengajuan' => date('Y-m-d H:i:s')
            ]);
        }

        return redirect('daftarpengajuanstruktur');
    }
}
