<?= $this->extend('template'); ?>

<?= $this->Section('content'); ?>

<div class="container-fluid">
    <div class="card bg-primary">
    <div class="card-body">
        <div class="card bg-primary">
        <div class="card-body" style="padding:0;">
            <h2 class="fw-semibold text-bg-primary" style="float: left;">Daftar SK Pembina Desa</h2>
            <a type="button" class="btn btn-light m-1" href="/pengajuanskpembina" style="float: right; box-shadow: 0 6px 20px 0 rgba(0,0,0,0.19);">Tambah SK</a>
        </div>
        </div>
        <div class="card">
        <div class="card-body">

        <!-- Data Tables -->
        <div class="container">
            <div class="row">
                <div class="col-12">
                        <table id="rpdesa" class="table table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Kode Kab/Kota</th>
                                    <th>Nomor SK</th>
                                    <th>Tanggal SK</th>
                                    <th>Detail</th>
                                    <th>Aksi</th>
                                    <th>Hapus</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($sk_pembina as $row):?>
                                    <tr>
                                        <td><?=$row['kode_kab']?> - <?= $kab?></td>
                                        <td><?=$row['nomor_sk']?></td>
                                        <td><?=$row['tanggal_sk']?></td>
                                        <td><button data-file="<?=$row['file']?>" data-sk="<?=$row['nomor_sk']?>" id="btnViewSkPembina" class="btn btn-outline-primary rounded-pill" data-toggle="modal" data-target="#modalView"><i class="ti ti-search"></i>View</button></td>
                                        <td><a href="editskpembina/<?=$row['id']?>" class="btn btn-info rounded-pill"><i class="ti ti-pencil"></i>Edit</a></td>
                                        <td><button data-id="<?=$row['id']?>" id="btnHapusSkPembina" class="btn btn-danger rounded-pill" data-toggle="modal" data-target="#modalHapusSk"><span class="ti ti-trash"></span> Hapus</button></td>
                                    </tr>
                                <?php endforeach;?>
                            </tbody>
                        </table>
                </div>
            </div>
        </div>
        <!-- End Data Tables -->
        </div>
        </div>
    </div>
    </div>
</div>

<!-- Modal View-->
<div class="modal fade" id="modalView" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="namaSK">Surat Keputusan Agen</h5>
        <button type="button" class="btn btn-light rounded-pill closeModal" data-dismiss="modal">
          X
        </button>
      </div>
        <div class="modal-body">
            <embed id="fileSkAgen" type="application/pdf" width="100%" height="675px"></embed>
        </div>
    </div>
  </div>
</div>

<!-- Modal hapus-->
<div class="modal fade" id="modalHapusSk" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="pesanAktif">Hapus SK Pembina ini?</h5>
        <button type="button" class="btn btn-light rounded-pill closeModal" data-dismiss="modal">
          X
        </button>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-info closeModal" data-dismiss="modal">Tidak</button>
        <form method="post" class="d-inline">
            <input type="hidden" name="_method" value="DELETE">
            <button type="submit" class="btn btn-danger">Ya</button>
        </form> 
      </div>
    </div>
  </div>
</div>

<?= $this->endSection(); ?>