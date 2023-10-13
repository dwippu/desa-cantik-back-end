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
    protected $allowedFields    = ['id', 'user_id', 'kode_desa', 'nama', 'email', 'instagram', 'jabatan', 'aktif', 'gambar', 'approval', 'tanggal_pengajuan', 'tanggal_konfirmasi', 'edit_from'];

    function validasiNama($kode_desa, $nama, $jabatan){
		$data = $this->db->table('perangkat_desa')->where(['kode_desa'=>$kode_desa, 'nama'=>$nama, 'jabatan'=>$jabatan])->get()->getNumRows();
        if ($data==0) {
            return true;
        } else {
            return false;
        }
	}

    function validasiPengajuan($kode_desa, $nama, $jabatan, $id){
        if($id==null){
            $data = $this->db->table('perangkat_desa')->where("approval='Aktifkan Diajukan' OR approval='Non-Aktifkan Diajukan'")->where(['kode_desa'=>$kode_desa, 'nama'=>$nama, 'jabatan'=>$jabatan])->get();
            if (($data->getNumRows()) == 0) {
                return null;
            } else {
                return $data->getResultArray();
            }
        }else{
            $data = $this->db->table('perangkat_desa')->where("approval='Aktifkan Diajukan' OR approval='Non-Aktifkan Diajukan'")->where(['kode_desa'=>$kode_desa, 'nama'=>$nama, 'jabatan'=>$jabatan])->get();
            $data1 = $this->db->table('perangkat_desa')->where("approval='Perubahan Diajukan'")->where(['edit_from'=>$id])->get();
            if (($data->getNumRows()) == 0 && ($data1->getNumRows()) == 0) {
                return null;
            } else {
                return $data1->getResultArray();
            }
        }
	}

    function checkUpdateExist($kode_desa, $edit_from){
        $data = $this->db->table('perangkat_desa')->where(['kode_desa'=>$kode_desa, 'approval'=>'Perubahan Diajukan','edit_from'=>$edit_from])->get();
        if (is_null($data)) {
            return null;
        } else {
            return $data->getResultArray();
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
        $data = $this->db->table('perangkat_desa')->where(['kode_desa'=>$kode_desa, 'nama'=>$nama, 'jabatan'=>$jabatan, 'aktif !='=>'NULL'])->get();
        if (is_null($data)) {
            return null;
        } else {
            return $data->getLastRow('array');
        }
    }

    function getLastActiveByJabatan($kode_desa, $jabatan){
        $data = $this->db->table('perangkat_desa')->where(['kode_desa'=>$kode_desa, 'jabatan'=>$jabatan, 'aktif'=>'Aktif'])->get();
        if (is_null($data)) {
            return null;
        } else {
            return $data->getResultArray();
        }
    }

    function getPerangkatByOpr($kode_desa){
        $data = $this->db->table('perangkat_desa')->where(['kode_desa'=>$kode_desa, 'aktif !='=>'NULL'])->orderBy('aktif ASC')->get();
        if (is_null($data)) {
            return null;
        } else {
            return $data->getResultArray();
        }
    }
}
