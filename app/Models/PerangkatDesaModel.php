<?php

namespace App\Models;

use CodeIgniter\Model;

class PerangkatDesaModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'perangkat_desa';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['id', 'user_id', 'kode_desa', 'nama', 'email', 'instagram', 'jabatan', 'aktif', 'gambar', 'approval', 'tanggal_pengajuan', 'tanggal_konfirmasi'];

    function validasiNama($kode_desa, $nama, $jabatan){
		$data = $this->db->table('perangkat_desa')->where(['kode_desa'=>$kode_desa, 'nama'=>$nama, 'jabatan'=>$jabatan])->get()->getNumRows();
        if ($data==0) {
            return true;
        } else {
            return false;
        }
	}

    function getRiwayatByOpr($kode_desa, $user_id){
        $data = $this->builder()
            ->select(['perangkat_desa.id', 'perangkat_desa.user_id', 'users.username', 'kode_desa', 'nama', 'email', 'instagram', 'jabatan', 'aktif', 'gambar', 'approval', 'tanggal_pengajuan', 'tanggal_konfirmasi'])
            ->join('users', 'perangkat_desa.user_id=users.id')->where(['kode_desa'=>$kode_desa, 'user_id'=>$user_id])->orderBy('tanggal_pengajuan DESC')
            ->get()->getResultArray();
        return $data;
    }

    function getRiwayatByDesa($kode_desa){
        $data = $this->builder()
            ->select(['perangkat_desa.id', 'perangkat_desa.user_id', 'users.username', 'kode_desa', 'nama', 'email', 'instagram', 'jabatan', 'aktif', 'gambar', 'approval', 'tanggal_pengajuan', 'tanggal_konfirmasi'])
            ->join('users', 'perangkat_desa.user_id=users.id')->where(['kode_desa'=>$kode_desa])->orderBy('tanggal_pengajuan DESC')
            ->get()->getResultArray();
        return $data;
    }

    function getRiwayatByKab($kode_kab){
        $data = $this->builder()
            ->select(['perangkat_desa.id', 'perangkat_desa.user_id', 'users.username', 'kode_desa', 'nama', 'email', 'instagram', 'jabatan', 'aktif', 'gambar', 'approval', 'tanggal_pengajuan', 'tanggal_konfirmasi'])
            ->join('users', 'perangkat_desa.user_id=users.id')->like('kode_desa', $kode_kab, 'after')->orderBy('tanggal_pengajuan DESC')
            ->get()->getResultArray();
        return $data;
    }

    function getLastActive($kode_desa, $nama, $jabatan){
        $data = $this->db->table('perangkat_desa')->where(['kode_desa'=>$kode_desa, 'nama'=>$nama, 'jabatan'=>$jabatan, 'aktif'=>'Aktif'])->get();
        if (is_null($data)) {
            return null;
        } else {
            return $data->getResultArray();
        }
    }
}
