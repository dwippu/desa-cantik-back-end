<?php

namespace App\Models;

use CodeIgniter\Model;

class ProfilDesaModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'profil_desa';
    protected $primaryKey       = 'kode_desa';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['id', 'kode_desa', 'alamat', 'email', 'telp', 'info_umum', 'html_tag', 'approval'];

    function nowProfil($kode_desa){
		$data = $this->db->table('profil_desa')->where(['kode_desa'=>$kode_desa, 'approval'=>'diterima'])->orderBy('id ASC')->get();
        if (is_null($data)) {
            return null;
        } else {
            return $data->getLastRow('array');
        }
	}

}
