<?php

namespace App\Controllers\SkPembina;

use App\Controllers\BaseController;
use App\Models\WilayahModel;
use App\Models\WilayahUserModel;
use App\Models\SkPembinaModel;

class PengajuanSkPembina extends BaseController
{
    public function index()
    {
        $user = new WilayahUserModel();
        $wilayah = new WilayahModel();
        $kode_desa = $user->getWilayah(auth()->getUser()->id);
        $prov = $wilayah->namaProv(substr($kode_desa,0,2));
        $kab = $wilayah->namaKab(substr($kode_desa,2,2));
        $data = ['nama_prov'=>$prov[0]['nama_prov'],'nama_kab'=>$kab[0]['nama_kab']];
        return view('sk_pembina/pengajuan_sk_pembina', $data);
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
                    'uploaded'=>'Upload SK Pembina Terlebih Dahulu',
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
        $sk_pembina = new SkPembinaModel();
        $file_sk = $this->request->getFile('file_sk');
        $file_sk->move('SK Pembina');
        $nama_file = $file_sk->getName();

        $sk_pembina->save([
            'kode_kab'=> substr($user->getWilayah(auth()->getUser()->id),0,4),
            'nomor_sk' => $this->request->getVar('no_sk'),
            'tanggal_sk' => $this->request->getVar('tanggal_sk'),
            'file' => $nama_file,
            'last_edit' => date('Y-m-d H:i:s')
        ]);

        return redirect('skpembina');
    }
}
