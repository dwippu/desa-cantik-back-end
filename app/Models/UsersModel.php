<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model
{
    protected $table = 'Users';
    public function getAllUser(){
        $data = $this->builder()
        // belum selesai
            ->select(['auth_groups_users.user_id','username','secret','group','kode_desa','last_active'])
            ->join('auth_groups_users', 'users.id = auth_groups_users.user_id')
            ->join('auth_identities', 'users.id=auth_identities.user_id')
            ->get()->getResultArray();
        return $data;
    }

    public function deleteUser(String $id){
        
    }

    public function udateUser(String $id){
        
    }
}
