<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UsersModel;

class Users extends BaseController
{
    protected UsersModel $model;
    
    public function index()
    {
        $this->model = new UsersModel();
        $list = $this->model->getAllUser();
        $data = ['list' => $list];
        return view('list_user', $data);
    }

    protected function getuser(){

    }

    protected function deleteuser(){

    }

    protected function updateuser(){

    }
}
