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

    public function getRiwayat($kode_desa){
        $data = $this->builder()
            ->select(['profil_desa.id', 'profil_desa.user_id', 'users.username', 'kode_desa', 'approval', 'tanggal_pengajuan', 'tanggal_konfirmasi'])
            ->join('users', 'profil_desa.user_id=users.id')->where(['kode_desa'=>$kode_desa])
            ->get()->getResultArray();
        return $data;
    }

}
