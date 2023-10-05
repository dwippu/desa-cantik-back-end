<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProfilDesaModel;
use App\Models\WilayahModel;
use App\Models\WilayahUserModel;

class ProfileDesa extends BaseController
{
    public function index()
    {
        $profil = new ProfilDesaModel();
        $user = new WilayahUserModel();
        $kode_desa = $user->getWilayah(auth()->getUser()->id);
        if(auth()->user()->inGroup('adminkab')){
            $kode_kab = substr($kode_desa,0,4);
            $profil_desa = $profil->getRiwayatByKab($kode_kab);
        }
        else{
            $profil_desa = $profil->getRiwayat($kode_desa);
        }
        $data = ['profil_desa'=>$profil_desa];
        return view('riwayat_profile_desa', $data);
    }

    public function delete($id){
        $profil = new ProfilDesaModel();
        $profil->delete($id);
        return redirect('profiledesa');
    }

    public function profile($id){
        $profil = new ProfilDesaModel();
        $wilayah = new WilayahModel();
        $pengajuan = $profil->find($id);
        $info_desa = $wilayah->find($pengajuan['kode_desa']);
        $data = ['info_desa' => $info_desa, 'pengajuan'=>$pengajuan];
        return $this->response->setJSON($data);
    }

    public function setujui($id){
        $profil = new ProfilDesaModel();
        $profil->update($id,[
            'alamat' => $this->request->getPost('alamat'), 
            'email' => $this->request->getPost('email'), 
            'telp' => $this->request->getPost('telp'), 
            'info_umum' => $this->request->getPost('info'), 
            'html_tag'=> $this->request->getPost('maps'),
            'approval'=>'disetujui',
            'tanggal_konfirmasi' => date('Y-m-d H:i:s')
        ]);
        return redirect('profiledesa');
    }

    public function tolak($id){
        $profil = new ProfilDesaModel();
        $profil->update($id,[
            'approval'=>'ditolak',
            'tanggal_konfirmasi' => date('Y-m-d H:i:s')
        ]);
        return redirect('profiledesa');
    }
}
