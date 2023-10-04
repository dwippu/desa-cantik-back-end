<?php

namespace App\Models;

use CodeIgniter\Model;

class PeangkatDesaModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'perangkat_desa';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [];
}
