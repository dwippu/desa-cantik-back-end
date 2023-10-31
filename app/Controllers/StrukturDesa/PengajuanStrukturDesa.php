<?php

namespace App\Controllers\StrukturDesa;

use App\Controllers\BaseController;
use App\Models\WilayahModel;
use App\Models\WilayahUserModel;
use App\Models\PerangkatDesaModel;

class PengajuanStrukturDesa extends BaseController
{
    public function index()
    {
        return view('struktur_desa/pengajuan_struktur_desa');
    }

    public function pengajuan(){
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
                'rules' => 'uploaded[foto]|max_size[foto,2048]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'uploaded'=>'Upload Foto Perangkat Desa Terkait Terlebih Dahulu',
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
        $kondisi = $perangkat->validasiNama(($wilayah->find($user->getWilayah(auth()->getUser()->id)))['kode_desa'], $this->request->getVar('nama'), $this->request->getVar('jabatan'));
        if ($kondisi==false){
            session()->setFlashdata('validationExist', 'Pengurus sudah terdaftar atau penambahan sudah diajukan');
        }else{
            $file_sk = $this->request->getFile('foto');
            $file_sk->move('Foto Perangkat');
            $nama_file = $file_sk->getName();

            $perangkat->save([
                'user_id' => auth()->getUser()->id,
                'kode_desa'=> ($wilayah->find($user->getWilayah(auth()->getUser()->id)))['kode_desa'],
                'nama' => $this->request->getVar('nama'), 
                'email' => $this->request->getVar('email'), 
                'instagram' => $this->request->getVar('ig'), 
                'jabatan' => $this->request->getVar('jabatan'),
                'gambar' => $nama_file,
                'approval' => 'Penambahan Diajukan',
                'tanggal_pengajuan' => date('Y-m-d H:i:s')
            ]);

        };
        return redirect('daftarpengajuanstruktur');
    }
}
