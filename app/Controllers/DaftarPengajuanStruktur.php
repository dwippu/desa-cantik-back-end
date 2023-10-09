<?php

namespace App\Controllers;
use App\Models\WilayahModel;
use App\Models\WilayahUserModel;
use App\Models\PerangkatDesaModel;

class DaftarPengajuanStruktur extends BaseController
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
        return view('daftar_pengajuan_struktur', $data);
    }

    public function view($id){
        $perangkat = new PerangkatDesaModel();
        $wilayah = new WilayahModel();
        $pengajuan = $perangkat->find($id);
        $info_desa = $wilayah->find($pengajuan['kode_desa']);
        $data = ['info_desa' => $info_desa, 'pengajuan'=>$pengajuan];
        return $this->response->setJSON($data);
    }

    public function delete($id){
        $perangkat = new PerangkatDesaModel();
        if ($this->request->getVar('keterangan') == "Penambahan Diajukan"){
            unlink('Foto Perangkat/'.(($perangkat->find($id))['gambar']));
        }
        $perangkat->delete($id);
        return redirect('daftarpengajuanstruktur');
    }

    public function setujui($id){
        $perangkat = new PerangkatDesaModel();
        $wilayah = new WilayahModel();
        $user = new WilayahUserModel();
        $lastPerangkat = $perangkat->getLastActive(($wilayah->find($user->getWilayah(auth()->getUser()->id)))['kode_desa'], $this->request->getVar('nama'), $this->request->getVar('jabatan'));
        if ($lastPerangkat!=null){
            $perangkat->update($lastPerangkat['id'],[
                'aktif' => null
            ]);
        }
        $approval="";
        if ($this->request->getVar('keterangan') == "Penambahan Diajukan"){
            $approval="Penambahan Disetujui";
        }elseif ($this->request->getVar('keterangan') == "Perubahan Diajukan"){
            $approval="Perubahan Disetujui";
        }elseif ($this->request->getVar('keterangan') == "Aktivasi Diajukan"){
            $approval="Aktivasi Disetujui";
        }elseif ($this->request->getVar('keterangan') == "Deaktivasi Diajukan"){
            $approval="Deaktivasi Disetujui";
        };
        $perangkat->update($id,[
            'nama' => $this->request->getVar('nama'), 
            'email' => $this->request->getVar('email'), 
            'instagram' => $this->request->getVar('ig'), 
            'jabatan' => $this->request->getVar('jabatan'),
            'aktif' => 'Aktif',
            'approval'=>$approval,
            'tanggal_konfirmasi' => date('Y-m-d H:i:s')
        ]);
        return redirect('daftarpengajuanstruktur');
    }

    public function tolak($id){
        $perangkat = new PerangkatDesaModel();
        $approval="";
        if ($this->request->getVar('keterangan') == "Penambahan Diajukan"){
            $approval="Penambahan Ditolak";
        }elseif ($this->request->getVar('keterangan') == "Perubahan Diajukan"){
            $approval="Perubahan Ditolak";
        }elseif ($this->request->getVar('keterangan') == "Aktivasi Diajukan"){
            $approval="Aktivasi Ditolak";
        }elseif ($this->request->getVar('keterangan') == "Deaktivasi Diajukan"){
            $approval="Deaktivasi Ditolak";
        };
        $perangkat->update($id,[
            'approval'=>$approval,
            'tanggal_konfirmasi' => date('Y-m-d H:i:s')
        ]);
        return redirect('daftarpengajuanstruktur');
    }
}
