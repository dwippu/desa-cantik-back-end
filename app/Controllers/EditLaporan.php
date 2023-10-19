<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\WilayahModel;
use App\Models\WilayahUserModel;
use App\Models\PengajuanLaporanBulananModel;
use App\Models\LaporanBulananModel;

class EditLaporan extends BaseController
{
    public function index($id)
    {
        $user = new WilayahUserModel();
        $wilayah = new WilayahModel();
        $info_desa = $wilayah->find($user->getWilayah(auth()->getUser()->id));
        $laporan = new LaporanBulananModel();
        $laporan_bulanan = $laporan->find($id);
        $data = ['laporan'=> $laporan_bulanan, 'info_desa'=> $info_desa];
        return view('edit_laporan', $data);
    }

    public function pengajuan($id){
        if(!$this->validate([
            'nama_kegiatan' => [
                'rules' => 'required',
                'errors' => ['required'=>'Nama Kegiatan Harus Diisikan']
            ],
            'peserta_kegiatan' => [
                'rules' => 'required',
                'errors' => ['required'=>'Peserta Kegiatan Harus Diisikan']
            ],
            'tanggal_kegiatan' => [
                'rules' => 'required',
                'errors' => ['required'=>'Tanggal Kegiatan Harus Diisikan']
            ],
            'file_laporan' =>[
                'rules' => 'max_size[file_laporan,15360]|mime_in[file_laporan,application/pdf]|ext_in[file_laporan,pdf]',
                'errors' => [
                    'max_size'=>'Ukuran File Melebihi Batas (Max 15 MB)',
                    'mime_in'=>'File Harus Memiliki Format PDF',
                    'ext_in'=>'File Harus Memiliki Format PDF'
                ]
            ]
        ])){
            $validation = \Config\Services::validation();
            session()->setFlashdata('validation', $validation->getErrors());
            return redirect()->back()->withInput();
        };

        $wilayah = new WilayahModel();
        $user = new WilayahUserModel();
        $pengajuan_laporan = new PengajuanLaporanBulananModel();

        if($pengajuan_laporan->cekHapus($id)!=null){
            session()->setFlashdata('validation', 'Terdapat Pengajuan Hapus untuk Laporan ini');
            return redirect('daftarpengajuanlaporan');
        };

        $nama_file = $this->request->getVar('laporanLama');
        $file_laporan = $this->request->getFile('file_laporan');
        if(($file_laporan->isValid())==true){
            $file_laporan->move('Laporan');
            $nama_file = $file_laporan->getName();
        };

        if($pengajuan_laporan->cekEdit($id)!=null){
            $id = ($pengajuan_laporan->cekEdit($id))[0]['id'];
            $pengajuan_laporan->update($id,[
                'nama_kegiatan' => $this->request->getVar('nama_kegiatan'),
                'peserta_kegiatan' => $this->request->getVar('peserta_kegiatan'),
                'tanggal_kegiatan' => $this->request->getVar('tanggal_kegiatan'),
                'file' => $nama_file,
                'approval' => 'Perubahan Laporan Diajukan',
                'tanggal_pengajuan' => date('Y-m-d H:i:s')
            ]);
        }else{
            $pengajuan_laporan->save([
                'user_id' => auth()->getUser()->id,
                'kode_desa'=> ($wilayah->find($user->getWilayah(auth()->getUser()->id)))['kode_desa'],
                'id_kegiatan' => $id,
                'nama_kegiatan' => $this->request->getVar('nama_kegiatan'),
                'peserta_kegiatan' => $this->request->getVar('peserta_kegiatan'),
                'tanggal_kegiatan' => $this->request->getVar('tanggal_kegiatan'),
                'file' => $nama_file,
                'approval' => 'Perubahan Laporan Diajukan',
                'tanggal_pengajuan' => date('Y-m-d H:i:s')
            ]);
        };

        return redirect('daftarpengajuanlaporan');
    }
}
