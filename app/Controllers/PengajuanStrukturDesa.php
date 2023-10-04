<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class PengajuanStrukturDesa extends BaseController
{
    public function index()
    {
        return view('pengajuan_struktur_desa');
    }
}
