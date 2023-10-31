<?php

namespace App\Controllers\SkPembina;

use App\Controllers\BaseController;
use App\Models\WilayahModel;
use App\Models\WilayahUserModel;
use App\Models\SkPembinaModel;

class EditSkPembina extends BaseController
{
    public function index($id)
    {
        $sk = new SkPembinaModel();
        $user = new WilayahUserModel();
        $wilayah = new WilayahModel();
        $sk_pembina = $sk->find($id);
        $prov =$wilayah->namaProv(substr($user->getWilayah(auth()->getUser()->id),0,2));
        $kab =$wilayah->namaKab(substr($user->getWilayah(auth()->getUser()->id),2,2));
        $data = ['nama_prov'=>$prov[0]['nama_prov'],'nama_kab'=>$kab[0]['nama_kab'],'sk_pembina'=>$sk_pembina];
        return view('sk_pembina/edit_sk_pembina', $data);
    }

    public function edit($id){
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
                'rules' => 'max_size[file_sk,15360]|mime_in[file_sk,application/pdf]|ext_in[file_sk,pdf]',
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
        $sk = new SkPembinaModel();
        $nama_file = $this->request->getVar('skLama');
        $file_sk = $this->request->getFile('file_sk');
        if(($file_sk->isValid())==true){
            unlink('SK Pembina/'.($nama_file));
            $file_sk->move('SK Pembina');
            $nama_file = $file_sk->getName();
        };

        $sk->update($id,[
            'nomor_sk' => $this->request->getVar('no_sk'),
            'tanggal_sk' => $this->request->getVar('tanggal_sk'),
            'file' => $nama_file,
            'last_edit' => date('Y-m-d H:i:s')
        ]);
       
        return redirect('skpembina');
    }
}
