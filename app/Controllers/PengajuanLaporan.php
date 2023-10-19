<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\WilayahModel;
use App\Models\WilayahUserModel;
use App\Models\PengajuanLaporanBulananModel;
use App\Models\LaporanBulananModel;

class PengajuanLaporan extends BaseController
{
    public function index()
    {
        $user = new WilayahUserModel();
        $wilayah = new WilayahModel();
        $info_desa = $wilayah->find($user->getWilayah(auth()->getUser()->id));
        $data = ['info_desa'=> $info_desa];
        return view('pengajuan_laporan', $data);
    }

    public function pengajuan(){
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
                'rules' => 'uploaded[file_laporan]|max_size[file_laporan,15360]|mime_in[file_laporan,application/pdf]|ext_in[file_laporan,pdf]',
                'errors' => [
                    'uploaded'=>'Upload Laporan Terlebih Dahulu',
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
        $laporan = new LaporanBulananModel();
        $file_laporan = $this->request->getFile('file_laporan');
        $file_laporan->move('Laporan');
        $nama_file = $file_laporan->getName();

        $pengajuan_laporan->save([
            'user_id' => auth()->getUser()->id,
            'kode_desa'=> ($wilayah->find($user->getWilayah(auth()->getUser()->id)))['kode_desa'],
            'nama_kegiatan' => $this->request->getVar('nama_kegiatan'),
            'peserta_kegiatan' => $this->request->getVar('peserta_kegiatan'),
            'tanggal_kegiatan' => $this->request->getVar('tanggal_kegiatan'),
            'file' => $nama_file,
            'approval' => 'Laporan Diajukan',
            'tanggal_pengajuan' => date('Y-m-d H:i:s')
        ]);

        return redirect('daftarpengajuanlaporan');
    }
}
