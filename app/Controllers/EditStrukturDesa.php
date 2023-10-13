<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\WilayahModel;
use App\Models\WilayahUserModel;
use App\Models\PerangkatDesaModel;

class EditStrukturDesa extends BaseController
{
    public function index($id)
    {
        $perangkat = new PerangkatDesaModel();
        $data = $perangkat->find($id);
        $data = ['perangkat_desa'=>$data];
        return view('edit_struktur_desa', $data);
    }

    public function edit($id){
        if(!$this->validate([
            'nama' => [
                'rules' => 'required',
                'errors' => ['required'=>'Nama Harus Diisikan']
            ],
            'jabatan' => [
                'rules' => 'required',
                'errors' => ['required'=>'Jabatan Harus Diisikan']
            ],
            'foto' =>[
                'rules' => 'max_size[foto,2048]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size'=>'Ukuran File Melebihi Batas (Max 2 MB)',
                    'is_image'=>'File Harus dalam Format Gambar',
                    'mime_in'=>'File Harus dalam Format Gambar jpg/jpeg/png'
                ]
            ]
        ])){
            $validation = \Config\Services::validation();
            session()->setFlashdata('validation', $validation->getErrors());
            return redirect()->back()->withInput();
        };

        $perangkat = new PerangkatDesaModel();
        $wilayah = new WilayahModel();
        $user = new WilayahUserModel();
        $nama_file = $this->request->getVar('fotoLama');
        $file_sk = $this->request->getFile('foto');
        if(($file_sk->isValid())==true){
            $file_sk->move('Foto Perangkat');
            $nama_file = $file_sk->getName();
        };

        $data_asal = $perangkat->find($id);
        $kondisi = $perangkat->validasiPengajuan(($wilayah->find($user->getWilayah(auth()->getUser()->id)))['kode_desa'], $data_asal['nama'], $data_asal['jabatan'], null);
        if ($kondisi!=null){
            session()->setFlashdata('validationExist', 'Ada Pengajuan Aktifkan atau Non-Aktifkan Belum Disetujui');
        }else{
            $lastPerangkat = $perangkat->checkUpdateExist($data_asal['kode_desa'], $id);
            if ($lastPerangkat!=null){
                $perangkat->update($lastPerangkat[0]['id'],[
                    'user_id' => auth()->getUser()->id,
                    'kode_desa'=> ($wilayah->find($user->getWilayah(auth()->getUser()->id)))['kode_desa'],
                    'nama' => $this->request->getVar('nama'), 
                    'email' => $this->request->getVar('email'), 
                    'instagram' => $this->request->getVar('ig'), 
                    'jabatan' => $this->request->getVar('jabatan'),
                    'gambar' => $nama_file,
                    'approval' => 'Perubahan Diajukan',
                    'tanggal_pengajuan' => date('Y-m-d H:i:s'),
                    'edit_from' => $id
                ]);
            }else{
                $perangkat->save([
                    'user_id' => auth()->getUser()->id,
                    'kode_desa'=> ($wilayah->find($user->getWilayah(auth()->getUser()->id)))['kode_desa'],
                    'nama' => $this->request->getVar('nama'), 
                    'email' => $this->request->getVar('email'), 
                    'instagram' => $this->request->getVar('ig'), 
                    'jabatan' => $this->request->getVar('jabatan'),
                    'gambar' => $nama_file,
                    'approval' => 'Perubahan Diajukan',
                    'tanggal_pengajuan' => date('Y-m-d H:i:s'),
                    'edit_from' => $id
                ]);
            }
        }
        return redirect('daftarpengajuanstruktur');
    }
}
