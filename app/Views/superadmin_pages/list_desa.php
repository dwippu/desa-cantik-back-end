<?= $this->extend('superadmin_pages/superadmin_template'); ?>

<?= $this->Section('content'); ?>

<div class="container-fluid">
    <div class="card" style="background-color:#5D87FF;">
    <div class="card-body">
        <h2 class="fw-semibold mb-4 text-bg-primary">Daftar Desa Cantik</h2>
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
                                    <th>Kode</th>
                                    <th>Desa</th>
                                    <th>Kecamatan</th>
                                    <th>Kota/Kabupaten</th>
                                    <th>Provinsi</th>
                                    <th>Laman Web</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($desa as $row):?>
                                <tr>
                                    <td><?=$row['kode_desa']?></td>
                                    <td><?=$row['nama_desa']?></td>
                                    <td><?=$row['nama_kec']?></td>
                                    <td><?=$row['nama_kab']?></td>
                                    <td><?=$row['nama_prov']?></td>
                                    <td>
                                        <span><a class="btn btn-outline-primary" href="http://localhost:8085/<?=$row['kode_desa']?>" target="_blank">Visit</a></span>
                                    </td>
                                    <td>
                                        <span><button type="button" id="deletebtn" class="btn btn-danger" data-id="<?= $row['kode_desa'] ?>">Hapus Status Desa Cantik</button></span>
                                    </td>
                                </tr>
                            <?php endforeach;?>
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

<!-- Modal Nonaktif Desa-->
<div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLongTitle"></h5>
        <button type="button" class="btn btn-light rounded-pill closeModal" data-dismiss="modal">
          X
        </button>
      </div>
      <div class="modal-body">
        <div class="alert alert-danger d-flex align-items-center" role="alert">
          <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
          <div id="warning-delete">
            Apakah Anda yakin untuk menghapus status Desa Cantik untuk Desa ini?
          </div>
        </div>
      </div>
      <div class="col">
        <div class="collapse multi-collapse pass-collapse">
          <div class="card card-body p-4">
            <form action="/nonaktifdescan" method="post" class="d-inline" id="form-delete-user">
                <?= csrf_field() ?>
                <label for="old-password" class="mb-2">Masukkan Password Anda</label>  
                <input type="password" name="old-password" class="form-control" id="old_password" placeholder="password" required>
                <input type="hidden" id="user_id_delete" name="kode_desa" value="">
            </form>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-info closeModal" data-dismiss="modal">Tidak</button>
        <button type="button" id="delaction" class="btn btn-danger">Ya</button>
      </div>
    </div>
  </div>
</div>

<?php  if (session('errors')): ?>
<!-- Modals Error -->
<p id="inValidName" hidden>in-valid name</p>
<div class="modal fade" id="modalInValid" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-body">
        <div class="alert alert-danger d-flex align-items-center" role="alert">
          <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
          <div id="danger-delete">
            <h5 class="modal-title"><?= session('errors') ?></h5>
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

<?php  if (session('succes')): ?>
<!-- Modals Sukses -->
<p id="inValidName" hidden>in-valid name</p>
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