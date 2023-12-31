<?php

namespace App\Models;

use CodeIgniter\Model;

class WilayahModel extends Model
{
    protected $table            = 'wilayah';
    protected $primaryKey       = 'kode_desa';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    // protected $useSoftDeletes   = false;
    // protected $protectFields    = true;
    protected $allowedFields    = ['descan'];

    public function findDescan(){
        return $this->where(['descan'=>1])->findAll();
    }

    public function distinctProv(){
        return $this->builder()->select(['prov', 'nama_prov'])->distinct()->get()->getResultArray();
    }

    public function distinctKab(){
        return $this->builder()->select(['kab', 'nama_kab'])->distinct()->get()->getResultArray();
    }

    public function namaKab($id_kab){
        return $this->builder()->select(['nama_kab'])->distinct()->where('kab', $id_kab)->get()->getResultArray();
    }

    public function findDescanByKab($kab){
        return $this->where(['kab'=>$kab])->where(['descan'=>1])->findAll();
    }

    public function namaProv($id_prov){
        return $this->builder()->select(['nama_prov'])->distinct()->where('prov', $id_prov)->get()->getResultArray();
    }

    public function makeDescan($kode){
        
    }
}
