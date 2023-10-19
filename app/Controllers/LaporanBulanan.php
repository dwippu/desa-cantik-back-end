<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\LaporanBulananModel;
use App\Models\PengajuanLaporanBulananModel;
use App\Models\WilayahUserModel;
use App\Models\WilayahModel;

class LaporanBulanan extends BaseController
{
    public function index()
    {
        $laporan = new LaporanBulananModel();
        $user = new WilayahUserModel();
        $wilayah = new WilayahModel();
        $kode_desa = $user->getWilayah(auth()->getUser()->id);
        if(auth()->user()->inGroup('adminkab')){
            $kode_kab = substr($kode_desa,0,4);
            $laporan_bulanan = $laporan->getLaporanBulananByKab($kode_kab);
        }else{
            $laporan_bulanan = $laporan->getLaporanBulanan($kode_desa);
        }

        $data = ['laporan'=>$laporan_bulanan];
        return view('laporan_bulanan', $data);
    }

    public function view($id){
        $laporan = new LaporanBulananModel();
        $laporan_view = $laporan->find($id);
        $data = ['laporan' => $laporan_view];
        return $this->response->setJSON($data);
    }

    public function hapus($id){
        $wilayah = new WilayahModel();
        $user = new WilayahUserModel();
        $pengajuan_laporan = new PengajuanLaporanBulananModel();
        $laporan = new LaporanBulananModel();
        $laporan_bulanan = $laporan->find($id);

        if($pengajuan_laporan->cekEdit($id)!=null){
            session()->setFlashdata('validation', 'Terdapat Pengajuan Perubahan untuk Laporan ini');
            return redirect('daftarpengajuanlaporan');
        };
        
        if($pengajuan_laporan->cekHapus($id)==null){
            $pengajuan_laporan->save([
                'user_id' => auth()->getUser()->id,
                'kode_desa'=> ($wilayah->find($user->getWilayah(auth()->getUser()->id)))['kode_desa'],
                'id_kegiatan' => $id,
                'nama_kegiatan' => $laporan_bulanan['nama_kegiatan'],
                'peserta_kegiatan' => $laporan_bulanan['peserta_kegiatan'],
                'tanggal_kegiatan' => $laporan_bulanan['tanggal_kegiatan'],
                'file' => $laporan_bulanan['file'],
                'approval' => 'Hapus Laporan Diajukan',
                'tanggal_pengajuan' => date('Y-m-d H:i:s')
            ]);
        }else{
            session()->setFlashdata('validation', 'Pengajuan Hapus untuk Laporan ini sudah ada');
        };

        return redirect('daftarpengajuanlaporan');
    }
}
