<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PengajuanLaporanBulananModel;
use App\Models\LaporanBulananModel;
use App\Models\WilayahUserModel;
use App\Models\WilayahModel;

class DaftarPengajuanLaporanBulanan extends BaseController
{
    public function index()
    {
        $laporan = new PengajuanLaporanBulananModel();
        $user = new WilayahUserModel();
        $wilayah = new WilayahModel();
        $kode_desa = $user->getWilayah(auth()->getUser()->id);
        if(auth()->user()->inGroup('adminkab')){
            $kode_kab = substr($kode_desa,0,4);
            $laporan_bulanan = $laporan->getRiwayatByKab($kode_kab);
        }elseif(auth()->user()->inGroup('verifikator')){
            $laporan_bulanan = $laporan->getRiwayatByDesa($kode_desa);
        }
        else{
            $laporan_bulanan = $laporan->getRiwayatByOpr($kode_desa, auth()->getUser()->id);
        }
        $data = ['laporan'=>$laporan_bulanan];
        return view('daftar_pengajuan_laporan_bulanan', $data);
    }

    public function view($id){
        $laporan = new PengajuanLaporanBulananModel();
        $laporan_view = $laporan->find($id);
        $data = ['laporan' => $laporan_view];
        return $this->response->setJSON($data);
    }

    public function delete($id){
        $pengajuan_laporan = new PengajuanLaporanBulananModel();
        $laporan = new LaporanBulananModel();
        if ($this->request->getVar('keterangan') == "Laporan Diajukan"){
            unlink('Laporan/'.(($pengajuan_laporan->find($id))['file']));
        }elseif($this->request->getVar('keterangan') == "Perubahan Laporan Diajukan"){
            if(($laporan->find(($pengajuan_laporan->find($id))['id_kegiatan']))['file'] != ($pengajuan_laporan->find($id))['file']){
                unlink('Laporan/'.(($pengajuan_laporan->find($id))['file']));
            }
        }
        $pengajuan_laporan->delete($id);
        return redirect('daftarpengajuanlaporan');
    }

    public function setujui($id){
        $pengajuan_laporan = new PengajuanLaporanBulananModel();
        $pengajuan = $pengajuan_laporan->find($id);
        $laporan = new LaporanBulananModel();
        $approval="";
        $id_kegiatan=null;
        if ($this->request->getVar('keterangan') == "Laporan Diajukan"){
            $approval="Laporan Disetujui";
            
            $input = $laporan->insert([
                'kode_desa'=> $pengajuan['kode_desa'],
                'nama_kegiatan' => $this->request->getVar('nama_kegiatan'),
                'peserta_kegiatan' => $this->request->getVar('peserta_kegiatan'),
                'tanggal_kegiatan' => $this->request->getVar('tanggal_kegiatan'),
                'file' => $pengajuan['file'],
                'last_edit' => date('Y-m-d H:i:s')
            ]);
            $id_kegiatan=$input;
        }elseif ($this->request->getVar('keterangan') == "Perubahan Laporan Diajukan"){
            $approval="Perubahan Laporan Disetujui";

            $input = $laporan->update($pengajuan['id_kegiatan'],[
                'nama_kegiatan' => $this->request->getVar('nama_kegiatan'),
                'peserta_kegiatan' => $this->request->getVar('peserta_kegiatan'),
                'tanggal_kegiatan' => $this->request->getVar('tanggal_kegiatan'),
                'file' => $pengajuan['file'],
                'last_edit' => date('Y-m-d H:i:s')
            ]);
            $id_kegiatan=$pengajuan['id_kegiatan'];
        }elseif ($this->request->getVar('keterangan') == "Hapus Laporan Diajukan"){
            $id_kegiatan = $pengajuan['id_kegiatan'];
            unlink('Laporan/'.($pengajuan['file']));
            $pengajuan_laporan->deleteByLaporan($id_kegiatan);
            $laporan->delete($id_kegiatan);
        };
        
        if($approval!=""){
            $pengajuan_laporan->update($id,[
                'id_kegiatan' => $id_kegiatan,
                'nama_kegiatan' => $this->request->getVar('nama_kegiatan'),
                'peserta_kegiatan' => $this->request->getVar('peserta_kegiatan'),
                'tanggal_kegiatan' => $this->request->getVar('tanggal_kegiatan'),
                'approval'=>$approval,
                'tanggal_konfirmasi' => date('Y-m-d H:i:s')
            ]);
        }
        
        return redirect('daftarpengajuanlaporan');
    }

    public function tolak($id){
        $pengajuan_laporan = new PengajuanLaporanBulananModel();
        $approval="";
        if ($this->request->getVar('keterangan') == "Laporan Diajukan"){
            $approval="Laporan Ditolak";
        }elseif ($this->request->getVar('keterangan') == "Perubahan Laporan Diajukan"){
            $approval="Perubahan Laporan Ditolak";
        }elseif ($this->request->getVar('keterangan') == "Hapus Laporan Diajukan"){
            $approval="Hapus Laporan Ditolak";
        };
        $pengajuan_laporan->update($id,[
            'approval'=>$approval,
            'tanggal_konfirmasi' => date('Y-m-d H:i:s')
        ]);
        return redirect('daftarpengajuanlaporan');
    }
}
