<?php

namespace App\Controllers\SkAgen;

use App\Controllers\BaseController;
use App\Models\PengajuanSkAgenModel;
use App\Models\SkAgenModel;
use App\Models\WilayahUserModel;
use App\Models\WilayahModel;

class DaftarPengajuanSkAgen extends BaseController
{
    public function index()
    {
        $sk = new PengajuanSkAgenModel();
        $user = new WilayahUserModel();
        $wilayah = new WilayahModel();
        $kode_desa = $user->getWilayah(auth()->getUser()->id);
        if(auth()->user()->inGroup('adminkab')){
            $kode_kab = substr($kode_desa,0,4);
            $sk_agen = $sk->getRiwayatByKab($kode_kab);
        }elseif(auth()->user()->inGroup('verifikator')){
            $sk_agen = $sk->getRiwayatByDesa($kode_desa);
        }
        else{
            $sk_agen = $sk->getRiwayatByOpr($kode_desa, auth()->getUser()->id);
        }
        $data = ['sk_agen'=>$sk_agen];
        return view('sk_agen/daftar_pengajuan_sk_agen', $data);
    }

    public function view($id){
        $sk = new PengajuanSkAgenModel();
        $sk_view = $sk->find($id);
        $data = ['sk_agen' => $sk_view];
        return $this->response->setJSON($data);
    }

    public function delete($id){
        $sk = new PengajuanSkAgenModel();
        $sk_agen = new SkAgenModel();
        if ($this->request->getVar('keterangan') == "SK Diajukan"){
            unlink('SK Agen/'.(($sk->find($id))['file']));
        }elseif ($this->request->getVar('keterangan') == "Perubahan SK Diajukan"){
            if(($sk_agen->find(($sk->find($id))['id_sk']))['file'] != ($sk->find($id))['file']){
                unlink('SK Agen/'.(($sk->find($id))['file']));
            }
        }
        $sk->delete($id);
        return redirect('daftarskagenstatistik');
    }

    public function setujui($id){
        $pengajuan_sk = new PengajuanSkAgenModel();
        $pengajuan = $pengajuan_sk->find($id);
        $sk = new SkAgenModel();
        $approval="";
        $id_sk=null;
        $jabatan=$this->request->getVar('jabatan');
        if ($this->request->getVar('keterangan') == "SK Diajukan"){
            $approval="SK Disetujui";
            
            $input = $sk->insert([
                'kode_desa'=> $pengajuan['kode_desa'],
                'nomor_sk' => $this->request->getVar('no_sk'),
                'tanggal_sk' => $this->request->getVar('tanggal_sk'),
                'file' => $pengajuan['file'],
                'last_edit' => date('Y-m-d H:i:s')
            ]);
            $id_sk=$input;
        }elseif ($this->request->getVar('keterangan') == "Perubahan SK Diajukan"){
            $approval="Perubahan SK Disetujui";

            $input = $sk->update($pengajuan['id_sk'],[
                'nomor_sk' => $this->request->getVar('no_sk'),
                'tanggal_sk' => $this->request->getVar('tanggal_sk'),
                'file' => $pengajuan['file'],
                'last_edit' => date('Y-m-d H:i:s')
            ]);
            $id_sk=$pengajuan['id_sk'];
        }elseif ($this->request->getVar('keterangan') == "Hapus SK Diajukan"){
            $id_sk = $pengajuan['id_sk'];
            unlink('SK Agen/'.($pengajuan['file']));
            $pengajuan_sk->deleteBySk($id_sk);
            $sk->delete($id_sk);
        };
        
        if($approval!=""){
            $pengajuan_sk->update($id,[
                'nomor_sk' => $this->request->getVar('no_sk'),
                'id_sk' => $id_sk,
                'tanggal_sk' => $this->request->getVar('tanggal_sk'),
                'approval'=>$approval,
                'tanggal_konfirmasi' => date('Y-m-d H:i:s')
            ]);
        }
        
        return redirect('daftarskagenstatistik');
    }

    public function tolak($id){
        $sk = new PengajuanSkAgenModel();
        $approval="";
        if ($this->request->getVar('keterangan') == "SK Diajukan"){
            $approval="SK Ditolak";
        }elseif ($this->request->getVar('keterangan') == "Perubahan SK Diajukan"){
            $approval="Perubahan SK Ditolak";
        }elseif ($this->request->getVar('keterangan') == "Hapus SK Diajukan"){
            $approval="Hapus SK Ditolak";
        };
        $sk->update($id,[
            'approval'=>$approval,
            'tanggal_konfirmasi' => date('Y-m-d H:i:s')
        ]);
        return redirect('daftarskagenstatistik');
    }
}
