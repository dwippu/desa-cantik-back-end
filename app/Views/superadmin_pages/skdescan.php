<?= $this->extend('superadmin_pages/superadmin_template'); ?>

<?= $this->Section('content'); ?>

<div class="container-fluid">
    <div class="card bg-primary">
    <div class="card-body">
        <div class="card bg-primary">
        <div class="card-body" style="padding:0;">
            <h2 class="fw-semibold text-bg-primary" style="float: left;">SK Desa Cantik BPS RI</h2>
            <a type="button" class="btn btn-light m-1" href="/uploadskdescan" style="float: right; box-shadow: 0 6px 20px 0 rgba(0,0,0,0.19);">Upload SK</a>
        </div>
        </div>
    <div class="card">
    <div class="card-body">

        <!-- Data Tables -->
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="data_tablesk">
                        <table id="user" class="table table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Tahun</th>
                                    <th>Nomor SK</th>
                                    <th>Tanggal SK</th>
                                    <th>Status</th>
                                    <th>Detail</th>
                                    <th>Aksi</th>
                                    <th>Hapus</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach($sk as $sk): ?>
                                <tr>
                                    <td><?= $sk['tahun'] ?></td>
                                    <td><?= $sk['nomor_sk'] ?></td>
                                    <td><?= $sk['tanggal_sk'] ?></td>
                                    <td><?= $sk['status'] ?></td>
                                    <td><button data-file="<?=$sk['file']?>" data-sk="<?=$sk['nomor_sk']?>" id="btnViewSk" class="btn btn-outline-primary rounded-pill" data-toggle="modal" data-target="#modalView"><i class="ti ti-search"></i> View</button></td>
                                    <td><a href="editskdescan/<?=$sk['id']?>" id="btnEditSk" class="btn btn-info rounded-pill"><i class="ti ti-pencil"></i>Edit</a></td>
                                    <td><button data-id="<?=$sk['id']?>" id="btnHapusSkdescan" class="btn btn-danger rounded-pill" data-toggle="modal" data-target="#modalHapusSk"><span class="ti ti-trash"></span> Hapus</button></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
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
        <h5 class="modal-title" id="namaSK">Surat Keputusan Desa Cantik</h5>
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
        <h5 class="modal-title" id="pesanAktif">Ajukan Hapus SK ini?</h5>
        <button type="button" class="btn btn-light rounded-pill closeModal" data-dismiss="modal">
          X
        </button>
      </div>
      <div class="col">
        <div class="collapse multi-collapse pass-collapse">
          <div class="card card-body p-4">
            <form action="" method="post" class="d-inline" id="hapusskdescan">
              <label for="old-password" class="mb-2">Masukkan Password Anda</label>  
              <input type="password" name="old-password" class="form-control" id="old_password" placeholder="password" required>
              <input type="hidden" name="_method" value="DELETE">
            </form>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-info closeModal" data-dismiss="modal">Tidak</button>
        <button type="button" id="delactionsk" class="btn btn-danger">Ya</button>
      </div>
    </div>
  </div>
</div>

<?php  if (session('succes')): ?>
<!-- Modals Sukses -->
<div class="modal fade" id="modalInValid" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-body">
        <div class="alert alert-success d-flex align-items-center" role="alert">
          <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
          <div id="danger-delete">
            <h5 class="modal-title"><?= session('succes') ?></h5>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger closeModal" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- End Modals -->
<?php  endif?>

<?= $this->endSection(); ?>