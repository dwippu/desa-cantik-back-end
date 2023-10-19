<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\WilayahModel;
use App\Models\WilayahUserModel;
use App\Models\PengajuanSkAgenModel;
use App\Models\SkAgenModel;

class PengajuanSkAgen extends BaseController
{
    public function index()
    {
        $user = new WilayahUserModel();
        $wilayah = new WilayahModel();
        $info_desa = $wilayah->find($user->getWilayah(auth()->getUser()->id));
        $data = ['info_desa'=> $info_desa];
        return view('pengajuan_sk_agen', $data);
    }

    public function pengajuan(){
        if(!$this->validate([
            'no_sk' => [
                'rules' => 'required',
                'errors' => ['required'=>'Nomor SK Harus Diisikan']
            ],
            'tanggal_sk' => [
                'rules' => 'required',
                'errors' => ['required'=>'Tanggal SK Harus Diisikan']
            ],
            'file_sk' =>[
                'rules' => 'uploaded[file_sk]|max_size[file_sk,15360]|mime_in[file_sk,application/pdf]|ext_in[file_sk,pdf]',
                'errors' => [
                    'uploaded'=>'Upload SK Agen Terlebih Dahulu',
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
        $sk = new PengajuanSkAgenModel();
        $sk_agen = new SkAgenModel();
        if($sk_agen->cekNomorSk($this->request->getVar('no_sk'))!=null){
            session()->setFlashdata('validation', 'File SK Sudah Ada');
        }elseif($sk->cekNomorSk($this->request->getVar('no_sk'))!=null){
            session()->setFlashdata('validation', 'File SK Sudah Diajukan');
        }else{
            $file_sk = $this->request->getFile('file_sk');
            $file_sk->move('SK Agen');
            $nama_file = $file_sk->getName();

            $sk->save([
                'user_id' => auth()->getUser()->id,
                'kode_desa'=> ($wilayah->find($user->getWilayah(auth()->getUser()->id)))['kode_desa'],
                'nomor_sk' => $this->request->getVar('no_sk'),
                'tanggal_sk' => $this->request->getVar('tanggal_sk'),
                'file' => $nama_file,
                'approval' => 'SK Diajukan',
                'tanggal_pengajuan' => date('Y-m-d H:i:s')
            ]);
        };

        return redirect('daftarskagenstatistik');
    }
}
