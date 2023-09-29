<?php

namespace App\Controllers\Auth;

use CodeIgniter\Shield\Entities\User;
use CodeIgniter\Shield\Models\GroupModel;
use app\Models\WilayahModel;

/**
 * Class WilayahController
 *
 * Controller untuk mengatur wilayah kerja setiap user
 * Fungsi akan mengakomodasi:
 * - addWilayah => untuk mengatur wilayah kerja bagi pengguna baru
 * - editWilayah => mengedit wilayah kerja untuk user yang sudah ada
 */
class WilayahController
{
    public function addWilayah(User $user, String $wilayah)
    {
        $wil = new WilayahModel();
        $wil->setWilayah($user->id, $wilayah);
    }

    public function getWilayah(User $user){
        $wil = new WilayahModel();
        return $wil->getWilayah($user);
    }
}