<?php
  if(auth()->user()->inGroup('adminkab')) {echo $this->extend('template');}
  if(auth()->user()->inGroup('superadmin')) {echo $this->extend('superadmin_template');}
?>

<?= $this->Section('content'); ?>

<div class="container-fluid">
    <div class="card" style="background-color:#5D87FF;">
    <div class="card-body">
        <h2 class="fw-semibold mb-4 text-bg-primary">Daftar Akun</h2>
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
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Kode Desa</th>
                                    <th>Status</th>
                                    <th>Terakhir Aktif</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($list as $row):?>
                                <tr>
                                    <td><?=$row['username']?></td>
                                    <td><?=$row['secret']?></td>
                                    <td><?=$row['group']?></td>
                                    <td><?=$row['kode_desa']?></td>
                                    <td>
                                      <?php if($row['status'] == 'banned'){
                                              echo '<span class="badge bg-danger rounded-3 fw-semibold">Nonaktif</span>';
                                            } else {
                                              echo '<span class="badge bg-success rounded-3 fw-semibold">Aktif</span>';
                                            }
                                      ?>
                                    </td>
                                    <td><?=$row['last_active']?></td>
                                    <td><button data-id="<?=$row['user_id']?>" id="btnViewUser" class="btn btn-outline-primary rounded-pill" data-toggle="modal" data-target="#modalView" <?php if ($row['user_id'] == auth()->user()->id){echo 'disabled';}?>><i class="fa fa-search"></i>Detail</button></td>
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

<!-- Modal View-->
<div class="modal fade" id="modalView" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Detail Akun</h5>
        <button type="button" class="btn btn-light rounded-pill closeModal" data-dismiss="modal">
          X
        </button>
      </div>
        <div class="modal-body">
            <form method="post">
                <div class="mb-3">
                    <label for="kabkot" class="form-label">Kabupaten/Kota</label>
                    <input type="kabkot" id="kabkot" name="kabkot" class="form-control" value="" disabled>
                </div>
                <div class="mb-3">
                    <label for="desa" class="form-label">Desa/Kelurahan</label>
                    <input type="desa" id="desa" name="desa" class="form-control" value="" disabled >
                </div>
                <div class="mb-3">
                    <label for="kode_desa" class="form-label">Kode Desa</label>
                    <input id="kode_desa" name="kode_desa" rows="4" cols="50" class="form-control" disabled></input>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">E-mail</label>
                    <input typ ="email" id="email" name="email" rows="4" cols="50" class="form-control" disabled></input>
                </div>
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input id="nama" name="nama" class="form-control" value="" disabled>
                </div>
                <div class="mb-3">
                    <label for="role" class="form-label">Role</label>
                    <input id="role" name="role" class="form-control" value="" disabled>
                </div>
                <div class="mb-3">
                    <label for="last_active" class="form-label">Terakhir Aktif</label>
                    <input id="last_active" name="last_active" class="form-control" value="" disabled>
                </div>
                <div class="modal-footer">
                    <button type="button" id="ubah_info" class="btn btn-success" data-id="">Ubah Informasi Akun</button>
                    <button type="button" id="resetbtn" class="btn btn-warning" data-id="">Reset Password</button>
                    <button type="button" id="deletebtn" class="btn btn-danger" data-id="">Nonaktifkan Akun</button>
                </div>     
            </form>
        </div>
    </div>
  </div>
</div>

<!-- Modal Nonaktif User-->
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
            Apakah Anda yakin untuk menonaktifkan akun ini?
          </div>
        </div>
      </div>
      <div class="col">
        <div class="collapse multi-collapse pass-collapse">
          <div class="card card-body p-4">
            <form action="/nonaktifuser" method="post" class="d-inline" id="form-delete-user">
              <label for="old-password" class="mb-2">Masukkan Password Anda</label>  
              <input type="password" name="old-password" class="form-control" id="old_password" placeholder="password" required>
              <input type="hidden" id="user_id_delete" name="user_id" value="">
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

<!-- Modal Reset Password-->
<div class="modal fade" id="modalReset" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLongTitle"></h5>
        <button type="button" class="btn btn-light rounded-pill closeModal" data-dismiss="modal">
          X
        </button>
      </div>
      <div class="modal-body">
        <div class="alert alert-warning d-flex align-items-center" role="alert">
          <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
          <div>
            Reset password dari akun ini?
          </div>
        </div>
      </div>
      <div class="col">
        <div class="collapse multi-collapse pass-collapse">
          <div class="card card-body p-4">
            <form action="/resetpassword" method="post" class="d-inline" id="form-reset-user">
              <label for="old-password" class="mb-2">Masukkan Password Anda</label>  
              <input type="password" name="old-password" class="form-control" placeholder="password" required>
              <input type="hidden" id="user_id_reset" name="user_id" value="">
            </form>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-info closeModal" data-dismiss="modal">Batal</button>
        <button type="button" id="resetaction" class="btn btn-danger">Ya</button>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection(); ?>