<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UsersModel;

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
        $list = $this->model->getAllUser();
        $data = ['list' => $list];
        return view('superadmin_pages/list_user', $data);
    }

    protected function getuser(){

    }

    protected function deleteuser(){

    }

    protected function updateuser(){

    }
}
