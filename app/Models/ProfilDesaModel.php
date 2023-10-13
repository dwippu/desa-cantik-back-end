<?php

namespace App\Models;

use CodeIgniter\Model;

class ProfilDesaModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'profil_desa';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['id', 'user_id', 'kode_desa', 'alamat', 'email', 'telp', 'info_umum', 'html_tag', 'approval', 'tanggal_pengajuan', 'tanggal_konfirmasi'];

    function nowProfil($kode_desa){
		$data = $this->db->table('profil_desa')->where(['kode_desa'=>$kode_desa, 'approval'=>'disetujui'])->orderBy('id ASC')->get();
        if (is_null($data)) {
            return null;
        } else {
            return $data->getLastRow('array');
        }
	}

    public function getRiwayatByOpr($kode_desa, $user_id){
        $data = $this->builder()
            ->select(['profil_desa.id', 'profil_desa.user_id', 'users.username', 'kode_desa', 'approval', 'tanggal_pengajuan', 'tanggal_konfirmasi'])
            ->join('users', 'profil_desa.user_id=users.id')->where(['kode_desa'=>$kode_desa, 'user_id'=>$user_id])->orderBy('tanggal_pengajuan DESC')
            ->get()->getResultArray();
        return $data;
    }

    public function getRiwayatByDesa($kode_desa){
        $data = $this->builder()
            ->select(['profil_desa.id', 'profil_desa.user_id', 'users.username', 'kode_desa', 'approval', 'tanggal_pengajuan', 'tanggal_konfirmasi'])
            ->join('users', 'profil_desa.user_id=users.id')->where(['kode_desa'=>$kode_desa])->orderBy('tanggal_pengajuan DESC')
            ->get()->getResultArray();
        return $data;
    }

    public function getRiwayatByKab($kode_kab){
        $data = $this->builder()
            ->select(['profil_desa.id', 'profil_desa.user_id', 'users.username', 'kode_desa', 'approval', 'tanggal_pengajuan', 'tanggal_konfirmasi'])
            ->join('users', 'profil_desa.user_id=users.id')->like('kode_desa', $kode_kab, 'after')->orderBy('tanggal_pengajuan DESC')
            ->get()->getResultArray();
        return $data;
    }

}
