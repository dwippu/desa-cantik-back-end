<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UsersModel;
use App\Models\WilayahUserModel;
use App\Models\WilayahModel;
use CodeIgniter\Shield\Models\UserModel;

/**
 * Controller untuk mengatur user
 * Hanya dapat diakses oleh akun dengan role superadmin
 */
class Users extends BaseController
{
    protected UsersModel $model;
    
    public function index()
    {
        $this->model = new UsersModel();
        if(auth()->user()->inGroup('adminkab')){
            return $this->adminKabPage();
        };
        $list = $this->model->getAllUser();
        $data = ['list' => $list];
        return view('superadmin_pages/list_user', $data);
    }

    protected function adminKabPage()
    {
        $user = new WilayahUserModel();
        $kode_desa = $user->getWilayah(auth()->getUser()->id);
        $kode_kab=substr($kode_desa,0,4);
        $list = $this->model->getAllUserByKab($kode_kab);
        $data = ['list' => $list];
        return view('list_user_kab', $data);
    }

    public function detail($id){
        if (! auth()->loggedIn()) {
            return redirect()->back();
        }

        $this->model = new UsersModel();
        $user = $this->model->detailUser($id)[0];
        
        // Nama Kabupaten
        $wil = new WilayahModel;
        $wil = $wil->namaKab(substr($user['kode_desa'],2,2));
        $user['nama_kab'] = $wil ? $wil[0]['nama_kab']:null;
        
        if(auth()->user()->inGroup('adminkab')){
            $wilayah = new WilayahUserModel();
            $kode_kab1 = substr($wilayah->getWilayah(auth()->user()->id),2,2);
            $kode_kab2 = substr($user['kode_desa'],2,2);
            if($kode_kab1 == $kode_kab2){
                return $this->response->setJSON($user);
            }
            return $this->response->setJSON(null);
        };

        return $this->response->setJSON($user);
    }

    public function editview($id){
        if (! auth()->loggedIn()) {
            return redirect()->back();
        }
        $desa = new WilayahModel();

        $this->model = new UsersModel();
        $user = $this->model->detailUser($id)[0];

        // Nama Kabupaten
        $wil = new WilayahModel;
        $wil = $wil->namaKab(substr($user['kode_desa'],2,2));
        $user['nama_kab'] = $wil ? $wil[0]['nama_kab']:null;
        
        if (auth()->user()->inGroup('adminkab')){
            $wilayah = new WilayahUserModel();
            $kode_kab1 = substr($wilayah->getWilayah(auth()->user()->id),0,4);
            $kode_kab2 = substr($user['kode_desa'],0,4);
            if($kode_kab1 !== $kode_kab2){
                return redirect()->back()->withInput()->with('errors', ['wrong-password' => 'Tidak dapat mengedit akun ini!']);
            }
        }

        $wilayah = new WilayahUserModel();
        $kode_kab = $wilayah->getWilayah(auth()->user()->id);
        $kode_kab = substr($kode_kab,2,2);
        return view('edit_user_kab', ['list' => $desa->findDescanByKab($kode_kab), 'user' => $user]);
    }

    public function edit(){
        if (! auth()->loggedIn()) {
            return redirect()->back();
        }
        $this->model = new UsersModel();
        $pos = $this->request->getPost();

        $this->model = new UsersModel();
        $user = $this->model->detailUser($pos['id'])[0];

        // Nama Kabupaten
        $wil = new WilayahModel;
        $wil = $wil->namaKab(substr($user['kode_desa'],2,2));
        $user['nama_kab'] = $wil ? $wil[0]['nama_kab']:null;

        if(auth()->user()->inGroup('adminkab')){            
            $wilayah = new WilayahUserModel();
            $kode_kab1 = substr($wilayah->getWilayah(auth()->user()->id),0,4);
            $kode_kab2 = substr($user['kode_desa'],0,4);
            if($kode_kab1 !== $kode_kab2){
                return redirect()->back()->withInput()->with('errors', ['wrong-password' => 'Tidak dapat mengedit akun ini!']);
            }
        }

    }

    public function nonaktifuser(){
        helper('oldpassword');
        // dd($this->request->getPost('old-password'));
        $pass = $this->request->getPost('old-password');
        if (!old_password_is_correct($pass)){
            return redirect()->back()->withInput()->with('errors', ['wrong-password' => 'Password Salah!']);
        };

        if($this->request->getPost('user_id') == auth()->user()->id){
            return redirect()->back()->withInput()->with('errors', ['wrong-password' => 'Tidak dapat menonaktifkan akun ini!']);
        }

        if(auth()->user()->inGroup('adminkab')){
            $this->model = new UsersModel();
            $user1 = $this->model->detailUser($this->request->getPost('user_id'))[0];

            // Nama Kabupaten
            $wil = new WilayahModel;
            $wil = $wil->namaKab(substr($user1['kode_desa'],2,2));
            $user1['nama_kab'] = $wil ? $wil[0]['nama_kab']:null;

            $wilayah = new WilayahUserModel();
            $kode_kab1 = substr($wilayah->getWilayah(auth()->user()->id),0,4);
            $kode_kab2 = substr($user1['kode_desa'],0,4);
            if($kode_kab1 !== $kode_kab2){
                return redirect()->back()->withInput()->with('errors', ['wrong-password' => 'Tidak dapat menonaktifkan akun ini!']);
            }

            if($user1['kode_desa'] == $wilayah->getWilayah(auth()->user()->id)){
                return redirect()->back()->withInput()->with('errors', ['wrong-password' => 'Tidak dapat menonaktifkan akun ini!']);
            }
        }

        $user = new UserModel();
        $user = $user->find($this->request->getPost('user_id'));
        
        if($user->isBanned()){
            $user->unBan();
            return redirect()->back()->withInput()->with('errors', ['wrong-password' => 'Akun Berhasil Diaktifkan Kembali!']);
        }
        $user->ban('Akun dinonaktifkan oleh Admin Kabupaten. Hubungi Admin untuk membuka kembali');
        return redirect()->back()->withInput()->with('errors', ['wrong-password' => 'Akun Berhasil Dinonaktifkan!']);
    }
}
