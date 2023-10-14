<?php

namespace App\Models;

use CodeIgniter\Model;

class PengajuanSkAgenModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'pengajuan_sk_agen';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['id', 'user_id', 'kode_desa', 'id_sk', 'nomor_sk', 'tanggal_sk', 'file', 'approval', 'tanggal_pengajuan', 'tanggal_konfirmasi'];

    public function getRiwayat($kode_desa){
        $data = $this->builder()
            ->select(['pengajuan_sk_agen.id', 'pengajuan_sk_agen.user_id', 'users.username', 'kode_desa', 'nomor_sk', 'file', 'approval', 'tanggal_pengajuan', 'tanggal_konfirmasi'])
            ->join('users', 'pengajuan_sk_agen.user_id=users.id')->where(['kode_desa'=>$kode_desa])->orderBy('tanggal_pengajuan DESC')->orderBy('tanggal_konfirmasi DESC')
            ->get()->getResultArray();
        return $data;
    }

    public function deleteBySk($id_sk){
        $data = $this->builder()->where(['id_sk'=>$id_sk])->delete();
        return $data;
    }

    public function cekHapus($id_sk){
        $data = $this->builder()->where(['id_sk'=>$id_sk, 'approval'=>'Hapus SK Diajukan'])->get();
        if(is_null($data)){
            return null;
        }else{
            return $data->getResultArray();
        }
    }

    public function cekEdit($id_sk){
        $data = $this->builder()->where(['id_sk'=>$id_sk, 'approval'=>'Perubahan SK Diajukan'])->get();
        if(is_null($data)){
            return null;
        }else{
            return $data->getResultArray();
        }
    }
}
