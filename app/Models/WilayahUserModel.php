<?php

namespace App\Models;

use CodeIgniter\Shield\Models\GroupModel;

class WilayahUserModel extends GroupModel
{
    protected $allowedFields = ['kode_desa'];

    /**
     * @param String|int $id dari user yang akan diubah wilayahnya
     * @param String $wilayah kode desa yang yang baru
     */
    public function setWilayah($id, String $wilayah)
    {
        $usergroup = $this->where('user_id', $id)->findAll();
        $this->update($usergroup[0]['id'], ['kode_desa' => $wilayah]);
    }
    
    public function getWilayah($id){
        $usergroup = $this->where('user_id', $id)->findAll();
        return $usergroup[0]['kode_desa'];
    }
}
