<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\WilayahModel;

class ListDesa extends BaseController
{
    public function index()
    {
        $desa = new WilayahModel();
        $desa = $desa->findDescan();
        return view('superadmin_pages/list_desa', ['desa' => $desa]);
    }

    public function tambahview()
    {
        echo 'ubah status desa menjadi desa cantik';
    }
}
