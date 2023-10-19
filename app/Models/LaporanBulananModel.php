<?php

namespace App\Models;

use CodeIgniter\Model;

class LaporanBulananModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'laporan_bulanan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['id', 'kode_desa', 'nama_kegiatan', 'tanggal_kegiatan', 'peserta_kegiatan', 'file', 'last_edit'];

    public function getLaporanBulanan($kode_desa){
        $data = $this->builder()->where(['kode_desa'=>$kode_desa])->get()->getResultArray();
        return $data;
    }

    public function getLaporanBulananByKab($kode_kab){
        $data = $this->builder()->like('kode_desa', $kode_kab, 'after')->get()->getResultArray();
        return $data;
    }
}
