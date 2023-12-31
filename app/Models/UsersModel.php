<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model
{
    protected $table = 'Users';
    protected $allowedFields    = ['username'];

    public function getAllUser(){
        $data = $this->builder()
            ->select(['auth_groups_users.user_id','username','secret','group','kode_desa', 'status', 'last_active'])
            ->join('auth_groups_users', 'users.id = auth_groups_users.user_id')
            ->join('auth_identities', 'users.id=auth_identities.user_id')
            ->get()->getResultArray();
        return $data;
    }

    public function getAllUserByKab($kode_kab){
        $data = $this->builder()
            ->select(['auth_groups_users.user_id','username','secret','group','kode_desa', 'status','last_active'])
            ->join('auth_groups_users', 'users.id = auth_groups_users.user_id')
            ->like('kode_desa', $kode_kab, 'after')
            ->join('auth_identities', 'users.id=auth_identities.user_id')
            ->get()->getResultArray();
        return $data;
    }

    public function detailUser($id){
        $data = $this->builder()
        ->select(['auth_groups_users.user_id','username','secret','group','auth_groups_users.kode_desa', 'status', 'last_active', 'nama_desa'])
        ->where('auth_groups_users.user_id',$id)
        ->join('auth_groups_users', 'users.id = auth_groups_users.user_id')
        ->join('auth_identities', 'users.id=auth_identities.user_id')
        ->join('wilayah', 'auth_groups_users.kode_desa=wilayah.kode_desa', 'LEFT')
        ->get()->getResultArray();
    return $data;
    }

    public function deleteUser(String $id){
        
    }

    public function udateUser(String $id){
        
    }
}
