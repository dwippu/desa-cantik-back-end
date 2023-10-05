<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UsersModel;
use App\Models\WilayahUserModel;

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

    protected function getuser(){

    }

    protected function deleteuser(){

    }

    protected function updateuser(){

    }
}
