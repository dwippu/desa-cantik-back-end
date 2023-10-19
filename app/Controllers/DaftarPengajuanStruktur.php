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

        $approval="";
        $aktif="Aktif";
        $perangkat_pengajuan = $perangkat->find($id);
        $jabatan=$this->request->getVar('jabatan');
        if ($this->request->getVar('keterangan') == "Penambahan Diajukan"){
            $approval="Penambahan Disetujui";
            if($jabatan!="Agen Statistik"){
                $lastPerangkat = $perangkat->getLastActiveByJabatan($perangkat_pengajuan['kode_desa'], $jabatan);
                if ($lastPerangkat!=null){
                    $perangkat->update($lastPerangkat[0]['id'],[
                        'aktif' => 'Tidak Aktif'
                    ]);
                }
            }
        }elseif ($this->request->getVar('keterangan') == "Perubahan Diajukan"){
            $approval="Perubahan Disetujui";
            $edit_from = ($perangkat->find($id))['edit_from'];
            $perangkat_lama = $perangkat->find($edit_from);
            $perangkat->update($edit_from, ['aktif'=>null]);
            if($jabatan!="Agen Statistik"){
                $lastPerangkat = $perangkat->getLastActiveByJabatan($perangkat_pengajuan['kode_desa'], $jabatan);
                if ($lastPerangkat!=null){
                    $perangkat->update($lastPerangkat[0]['id'],[
                        'aktif' => 'Tidak Aktif'
                    ]);
                }
            }
        }elseif ($this->request->getVar('keterangan') == "Aktifkan Diajukan"){
            $approval="Aktifkan Disetujui";
            if($jabatan!="Agen Statistik"){
                $lastPerangkat = $perangkat->getLastActiveByJabatan($perangkat_pengajuan['kode_desa'], $jabatan);
                if ($lastPerangkat!=null){
                    $perangkat->update($lastPerangkat[0]['id'],[
                        'aktif' => 'Tidak Aktif'
                    ]);
                }
            }
        }elseif ($this->request->getVar('keterangan') == "Non-Aktifkan Diajukan"){
            $approval="Non-Aktifkan Disetujui";
            $aktif="Tidak Aktif";
        };

        $lastPerangkat = $perangkat->getLastActive($perangkat_pengajuan['kode_desa'], $this->request->getVar('nama'), $this->request->getVar('jabatan'));
        if ($lastPerangkat!=null){
            $perangkat->update($lastPerangkat['id'],[
                'aktif' => null
            ]);
        }
        
        $perangkat->update($id,[
            'nama' => $this->request->getVar('nama'), 
            'email' => $this->request->getVar('email'), 
            'instagram' => $this->request->getVar('ig'), 
            'jabatan' => $this->request->getVar('jabatan'),
            'aktif' => $aktif,
            'approval'=>$approval,
            'tanggal_konfirmasi' => date('Y-m-d H:i:s')
        ]);
        return redirect('daftarpengajuanstruktur');
    }

    public function tolak($id){
        $perangkat = new PerangkatDesaModel();
        $approval="";
        $aktif=null;
        if ($this->request->getVar('keterangan') == "Penambahan Diajukan"){
            $approval="Penambahan Ditolak";
            $aktif="Tidak Aktif";
        }elseif ($this->request->getVar('keterangan') == "Perubahan Diajukan"){
            $approval="Perubahan Ditolak";
        }elseif ($this->request->getVar('keterangan') == "Aktifkan Diajukan"){
            $approval="Aktifkan Ditolak";
        }elseif ($this->request->getVar('keterangan') == "Non-Aktifkan Diajukan"){
            $approval="Non-Aktifkan Ditolak";
        };
        $perangkat->update($id,[
            'approval'=>$approval,
            'aktif'=>$aktif,
            'tanggal_konfirmasi' => date('Y-m-d H:i:s')
        ]);
        return redirect('daftarpengajuanstruktur');
    }
}
