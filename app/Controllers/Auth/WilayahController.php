<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use CodeIgniter\Events\Events;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Shield\Authentication\Authenticators\Session;
use CodeIgniter\Shield\Authentication\Passwords;
use CodeIgniter\Shield\Config\Auth;
use CodeIgniter\Shield\Entities\User;
use CodeIgniter\Shield\Exceptions\ValidationException;
use CodeIgniter\Shield\Models\UserModel;
use CodeIgniter\Shield\Models\GroupModel;
use CodeIgniter\Shield\Traits\Viewable;
use Psr\Log\LoggerInterface;

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
        $group = new GroupModel();
        $usergroup = $group->where('user_id', $user->id)->findAll();
        $group->update($usergroup[0]['id'], ['kode_desa' => $wilayah]);
    }
}