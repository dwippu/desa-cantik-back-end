<?php
  if(auth()->user()->inGroup('adminkab')) {echo $this->extend('template');}
  if(auth()->user()->inGroup('superadmin')) {echo $this->extend('superadmin_pages/superadmin_template');}
?>

<?= $this->Section('content'); ?>

<svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
  <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
  </symbol>
  <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
  </symbol>
  <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
    <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
  </symbol>
</svg>

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
<!-- Modals Nama sudah ada -->
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
<!-- Modals Nama sudah ada -->
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