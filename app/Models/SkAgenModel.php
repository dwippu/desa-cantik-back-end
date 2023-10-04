<?php

namespace App\Models;

use CodeIgniter\Model;

class SkAgenModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'sk_agen';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['id', 'user_id', 'kode_desa', 'nomor_sk', 'tanggal_sk', 'file', 'approval', 'tanggal_pengajuan', 'tanggal_konfirmasi', 'edit form'];

    public function getRiwayat($kode_desa){
        $data = $this->builder()
            ->select(['sk_agen.id', 'sk_agen.user_id', 'users.username', 'kode_desa', 'nomor_sk', 'file', 'approval', 'tanggal_pengajuan', 'tanggal_konfirmasi'])
            ->join('users', 'sk_agen.user_id=users.id')->where(['kode_desa'=>$kode_desa])
            ->get()->getResultArray();
        return $data;
    }
}
