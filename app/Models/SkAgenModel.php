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
    protected $allowedFields    = ['id', 'kode_desa', 'nomor_sk', 'tanggal_sk', 'file', 'last_edit'];

    public function getSkAgen($kode_desa){
        $data = $this->builder()->where(['kode_desa'=>$kode_desa])->get()->getResultArray();
        return $data;
    }

    public function getSkAgenByKab($kode_kab){
        $data = $this->builder()->like('kode_desa', $kode_kab, 'after')->get()->getResultArray();
        return $data;
    }

    public function cekNomorSk($nomor_sk){
        $data = $this->builder()->where(['nomor_sk'=>$nomor_sk])->get();
        if(is_null($data)){
            return null;
        }else{
            return $data->getResultArray();
        }
    }
}
