<?php

namespace App\Models;

use CodeIgniter\Model;

class SkDescanModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'sk_descan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['id', 'nomor_sk', 'tanggal_sk', 'file', 'list_descan', 'status', 'tanggal_upload'];

    public function getRiwayat($kode_desa){
        // $data = $this->builder()
        //     ->select(['sk_agen.id', 'nomor_sk', 'file'])
        //     ->join('users', 'sk_agen.user_id=users.id')->where(['kode_desa'=>$kode_desa])
        //     ->get()->getResultArray();
        // return $data;
    }    
}
