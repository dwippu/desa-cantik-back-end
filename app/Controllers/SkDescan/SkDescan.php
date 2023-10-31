<?php

namespace App\Controllers\SkDescan;

use App\Controllers\BaseController;
use App\Models\SkDescanModel;
use App\Models\WilayahModel;

class SkDescan extends BaseController
{
    public function index()
    {
        $model = new SkDescanModel();
        $data = $model->findAll();
        return view('sk_descan/skdescan', ['sk' => $data]);
    }

    public function uploadview()
    {
        return view('sk_descan/uploadsk');
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
        $i = 1;
        foreach($this->request->getPost('kode_desa') as $kode){
            if(! $wilayah->find($kode)){
                session()->setFlashdata('validation', ['kode_desa'.$i=>'kode desa ['.$kode.'] tidak valid']);
                return redirect()->back()->withInput();
            }
            $wilayah->update($kode, ['descan'=>1]);
            $list_desa = $list_desa.$kode.'; ';
            $i+=1;
        };

        $sk = new SkDescanModel();
        $file_sk = $this->request->getFile('file_sk');
        $file_sk->move('SK Descan');
        $nama_file = $file_sk->getName();
        
        $new_sk = [
            'nomor_sk' => $this->request->getPost('no_sk'),
            'tanggal_sk' => $this->request->getPost('tanggal_sk'),
            'file' => $nama_file,
            'list_descan' => $list_desa,
            'tanggal_upload' => date('Y-m-d H:i:s'),
            'status' => 'ACTIVE',
        ];

        $sk->save($new_sk);

        return redirect('skdescan')->with('succes', 'SK Desa Cantik berhasil ditambahkan');
    }

    public function hapus($id){
        helper('oldpassword');
        $pass = $this->request->getPost('old-password');
        if (!old_password_is_correct($pass)){
            return redirect()->back()->withInput()->with('errors', 'Password Salah!');
        };
        
        $sk = new SkDescanModel();
        unlink('SK Descan/'.(($sk->find($id))['file']));
        $sk->delete($id);
        return redirect('skdescan')->with('succes', 'SK Berhasil Dihapus');
    }

    public function edit($id){
        $sk = new SkDescanModel();
        $sk_descan = $sk->find($id);
        $sk_descan['list_descan'] = explode('; ', $sk_descan['list_descan']);
        array_pop($sk_descan['list_descan']);
        $data = ['sk_descan'=>$sk_descan];
        return view('sk_descan/edit_sk_descan', $data);
    }

    public function editaction($id){
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

        $nama_file = $this->request->getVar('skLama');
        $file_sk = $this->request->getFile('file_sk');
        if($file_sk->isValid()){
            unlink('Sk Descan/'.$nama_file);
            $file_sk->move('Sk Descan');
            $nama_file = $file_sk->getName();
        };
        
        $list_desa = "";
        $wilayah = new WilayahModel();
        $i = 1;
        foreach($this->request->getPost('kode_desa') as $kode){
            if(! $wilayah->find($kode)){
                session()->setFlashdata('validation', ['kode_desa'.$i=>'kode desa ['.$kode.'] tidak valid']);
                return redirect()->back()->withInput();
            }
            $wilayah->update($kode, ['descan'=>1]);
            $list_desa = $list_desa.$kode.'; ';
            $i+=1;
        };

        $sk = new SkDescanModel();
        $sk -> update($id, [
            'nomor_sk' => $this->request->getPost('no_sk'),
            'tanggal_sk' => $this->request->getPost('tanggal_sk'),
            'file' => $nama_file,
            'list_descan' => $list_desa,
            'tanggal_upload' => date('Y-m-d H:i:s')
        ]);

        return redirect()->to('skdescan')->with('succes', 'SK berhasil diedit');
    }
}