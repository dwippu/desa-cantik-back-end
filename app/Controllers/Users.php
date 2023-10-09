<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UsersModel;
use App\Models\WilayahUserModel;
use App\Models\WilayahModel;

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

    protected function deleteuser(){
        helper('oldpassword');
    }

    protected function updateuser(){

    }
}
