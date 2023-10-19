<?php

namespace App\Models;

use CodeIgniter\Model;

class PengajuanLaporanBulananModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'pengajuan_laporan_bulanan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['id', 'user_id', 'kode_desa', 'id_kegiatan', 'nama_kegiatan', 'tanggal_kegiatan', 'peserta_kegiatan', 'file', 'approval', 'tanggal_pengajuan', 'tanggal_konfirmasi'];

    function getRiwayatByOpr($kode_desa, $user_id){
        $data = $this->builder()
            ->select(['pengajuan_laporan_bulanan.id', 'pengajuan_laporan_bulanan.user_id', 'users.username', 'kode_desa', 'id_kegiatan', 'nama_kegiatan', 'tanggal_kegiatan', 'peserta_kegiatan', 'file', 'approval', 'tanggal_pengajuan', 'tanggal_konfirmasi'])
            ->join('users', 'pengajuan_laporan_bulanan.user_id=users.id')->where(['kode_desa'=>$kode_desa, 'user_id'=>$user_id])->orderBy('tanggal_pengajuan DESC')->orderBy('tanggal_konfirmasi DESC')
            ->get()->getResultArray();
        return $data;
    }

    public function getRiwayatByDesa($kode_desa){
        $data = $this->builder()
            ->select(['pengajuan_laporan_bulanan.id', 'pengajuan_laporan_bulanan.user_id', 'users.username', 'kode_desa', 'id_kegiatan', 'nama_kegiatan', 'tanggal_kegiatan', 'peserta_kegiatan', 'file', 'approval', 'tanggal_pengajuan', 'tanggal_konfirmasi'])
            ->join('users', 'pengajuan_laporan_bulanan.user_id=users.id')->where(['kode_desa'=>$kode_desa])->orderBy('tanggal_pengajuan DESC')->orderBy('tanggal_konfirmasi DESC')
            ->get()->getResultArray();
        return $data;
    }

    function getRiwayatByKab($kode_kab){
        $data = $this->builder()
            ->select(['pengajuan_laporan_bulanan.id', 'pengajuan_laporan_bulanan.user_id', 'users.username', 'kode_desa', 'id_kegiatan', 'nama_kegiatan', 'tanggal_kegiatan', 'peserta_kegiatan', 'file', 'approval', 'tanggal_pengajuan', 'tanggal_konfirmasi'])
            ->join('users', 'pengajuan_laporan_bulanan.user_id=users.id')->like('kode_desa', $kode_kab, 'after')->orderBy('tanggal_pengajuan DESC')->orderBy('tanggal_konfirmasi DESC')
            ->get()->getResultArray();
        return $data;
    }

    public function cekHapus($id_kegiatan){
        $data = $this->builder()->where(['id_kegiatan'=>$id_kegiatan, 'approval'=>'Hapus Laporan Diajukan'])->get();
        if(is_null($data)){
            return null;
        }else{
            return $data->getResultArray();
        }
    }

    public function cekEdit($id_kegiatan){
        $data = $this->builder()->where(['id_kegiatan'=>$id_kegiatan, 'approval'=>'Perubahan Laporan Diajukan'])->get();
        if(is_null($data)){
            return null;
        }else{
            return $data->getResultArray();
        }
    }

    public function deleteByLaporan($id_kegiatan){
        $data = $this->builder()->where(['id_kegiatan'=>$id_kegiatan])->delete();
        return $data;
    }

}
