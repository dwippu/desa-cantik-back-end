<?php

namespace App\Controllers\Auth;

use CodeIgniter\Shield\Entities\User;
use App\Models\WilayahUserModel;

/**
 * Class WilayahController
 *
 * Controller untuk mengatur wilayah kerja setiap user
 * Fungsi akan mengakomodasi:
 * - addWilayah => untuk mengatur wilayah kerja bagi pengguna baru
 * - editWilayah => mengedit wilayah kerja untuk user yang sudah ada
 */
class WilayahUserController 
{
    public function addWilayah(User $user, String $wilayah)
    {
        $wil = new WilayahUserModel();
        $wil->setWilayah($user->id, $wilayah);
    }

    public function getWilayah(User $user){
        $wil = new WilayahUserModel();
        return $wil->getWilayah($user);
    }
}