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
    protected $allowedFields    = ['kode_desa', 'prov', 'nama_prov', 'kab', 'nama_kab', 'kec', 'nama_kec', 'desa', 'nama_desa'];
}
