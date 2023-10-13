<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SkDescanModel;
use App\Models\WilayahModel;

class SkDescan extends BaseController
{
    public function index()
    {
        $model = new SkDescanModel();
        $data = $model->findAll();
        return view('superadmin_pages/skdescan', ['sk' => $data]);
    }

    public function uploadview()
    {
        return view('superadmin_pages/uploadsk');
    }

    public function uploadpost(){
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
            ],
            'kode_desa'=>[
                'rules' => 'required',
                'errors' => ['required'=>'Daftar Kode Desa Harus Diisikan']
            ]
        ])){
            $validation = \Config\Services::validation();
            session()->setFlashdata('validation', $validation->getErrors());
            return redirect()->back()->withInput();
        };

        $list_desa = "";
        $wilayah = new WilayahModel();
        foreach($this->request->getVar('kode_desa') as $kode){
            echo $kode;
            if(! $wilayah->find($kode)){
                session()->setFlashdata('validation', ['kode_desa'=>'kode desa ['.$kode.'] tidak valid']);
                return redirect()->back()->withInput();
            }
            $wilayah->update($kode, ['descan'=>1]);
            $list_desa = $list_desa.$kode.'; ';
        };
        dd($list_desa);

        $sk = new SkDescanModel();
        $file_sk = $this->request->getFile('file_sk');
        $file_sk->move('SK Descan');
        $nama_file = $file_sk->getName();
        
        $sk->save([
            'nomor_sk' => $this->request->getVar('no_sk'),
            'tahun' => $this->request->getVar('tahun'),
            'tanggal_sk' => $this->request->getVar('tanggal_sk'),
            'file' => $nama_file,
            'list_descan' => $list_desa,
            'tanggal_upload' => date('Y-m-d H:i:s'),
            'status' => 'ACTIVE',
        ]);

        return redirect('skdescan');
    }
}
