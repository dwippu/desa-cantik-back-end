<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\WilayahModel;
use App\Models\WilayahUserModel;
use App\Models\PengajuanSkAgenModel;
use App\Models\SkAgenModel;

class EditSkAgen extends BaseController
{
    public function index($id)
    {
        $user = new WilayahUserModel();
        $wilayah = new WilayahModel();
        $sk = new SkAgenModel();
        $sk_agen = $sk->find($id);
        $info_desa = $wilayah->find($sk_agen['kode_desa']);
        $data = ['sk_agen'=>$sk_agen,'info_desa'=> $info_desa];
        return view('edit_sk_agen', $data);
    }

    public function pengajuan($id){
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

        $sk_pengajuan = new PengajuanSkAgenModel();
        if($sk_pengajuan->cekHapus($id)!=null){
            session()->setFlashdata('validation', 'Terdapat Pengajuan Hapus untuk SK ini');
            return redirect('daftarskagenstatistik');
        };

        $wilayah = new WilayahModel();
        $user = new WilayahUserModel();
        $nama_file = $this->request->getVar('skLama');
        $file_sk = $this->request->getFile('file_sk');
        if(($file_sk->isValid())==true){
            $file_sk->move('Foto Perangkat');
            $nama_file = $file_sk->getName();
        };

        if($sk_pengajuan->cekEdit($id)!=null){
            $id = ($sk_pengajuan->cekEdit($id))[0]['id'];
            $sk_pengajuan->update($id,[
                'nomor_sk' => $this->request->getVar('no_sk'),
                'tanggal_sk' => $this->request->getVar('tanggal_sk'),
                'file' => $nama_file,
                'approval' => 'Perubahan SK Diajukan',
                'tanggal_pengajuan' => date('Y-m-d H:i:s')
            ]);
        }else{
            $sk_pengajuan->save([
                'user_id' => auth()->getUser()->id,
                'kode_desa'=> ($wilayah->find($user->getWilayah(auth()->getUser()->id)))['kode_desa'],
                'id_sk' => $id,
                'nomor_sk' => $this->request->getVar('no_sk'),
                'tanggal_sk' => $this->request->getVar('tanggal_sk'),
                'file' => $nama_file,
                'approval' => 'Perubahan SK Diajukan',
                'tanggal_pengajuan' => date('Y-m-d H:i:s')
            ]);
        };

        return redirect('daftarskagenstatistik');
    }
}
