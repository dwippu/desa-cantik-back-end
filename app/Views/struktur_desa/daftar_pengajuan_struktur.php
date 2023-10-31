<?= $this->extend('template'); ?>

<?= $this->Section('content'); ?>

<div class="container-fluid">
    <div class="card bg-primary">
    <div class="card-body">
        <div class="card bg-primary">
        <div class="card-body" style="padding:0;">
            <h2 class="fw-semibold text-bg-primary" style="float: left;">Daftar Pengajuan Struktur Organisasi Desa cantik</h2>
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
                                    <th>Pemohon</th>
                                    <th>Jabatan</th>
                                    <th>Nama</th>
                                    <th>Keterangan</th>
                                    <th>Tanggal Pengajuan</th>
                                    <th>Tanggal Konfirmasi</th>
                                    <th>Detail</th>
                                    <?php if (auth()->user()->inGroup('operator')): ?>
                                      <th>Aksi</th>
                                    <?php endif?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($perangkat_desa as $row):?>
                                    <tr>
                                        <td><?=$row['username']?></td>
                                        <td><?=$row['jabatan']?></td>
                                        <td><?=$row['nama']?></td>
                                        <td><?php if (str_contains($row['approval'],'Disetujui')){
                                                    echo '<span class="badge bg-success rounded-3 fw-semibold">',$row['approval'],'</span>';
                                                }elseif (str_contains($row['approval'],'Diajukan')){
                                                  echo '<span class="badge bg-secondary rounded-3 fw-semibold">',$row['approval'],'</span>';
                                                }elseif (str_contains($row['approval'],'Ditolak')){
                                                  echo '<span class="badge bg-danger rounded-3 fw-semibold">',$row['approval'],'</span>';
                                                }
                                            ?>
                                        </td>
                                        <td><?=$row['tanggal_pengajuan']?></td>
                                        <td><?=$row['tanggal_konfirmasi']?></td>
                                        <td><button data-id="<?=$row['id']?>" data-keterangan="<?=$row['approval']?>" id="btnViewStruktur" class="btn btn-outline-primary rounded-pill" data-toggle="modal" data-target="#modalView"><i class="ti ti-search"></i>View</button></td>
                                        <?php if (auth()->user()->inGroup('operator')): ?>
                                            <td><button data-id="<?=$row['id']?>" data-keterangan="<?=$row['approval']?>" id="btnCancelStruktur" class="btn btn-danger rounded-pill" data-toggle="modal" data-target="#modalCancel" <?php if ($row['tanggal_konfirmasi'] != null) echo 'disabled' ?> >Batalkan</button></td>
                                        <?php endif?> 
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

<?php  if (session('validationExist')): ?>
<!-- Modals Nama sudah ada -->
<p id="inValidName" hidden>in-valid name</p>
<div class="modal fade" id="modalInValid" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">PENGAJUAN TIDAK TERSIMPAN !!!</h5>
        <button type="button" class="btn btn-light rounded-pill closeModal" data-dismiss="modal">
            X
        </button>
      </div>
      <div class="modal-body">
        <p style="font-weight: bold;"><?= session('validationExist')?></p>
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
        <h5 class="modal-title" id="exampleModalLongTitle">Detail Pengajuan</h5>
        <button type="button" class="btn btn-light rounded-pill closeModal" data-dismiss="modal">
          X
        </button>
      </div>
        <div class="modal-body">
              <form method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="prov" class="form-label">Provinsi</label>
                    <input type="text" id="prov" name="prov" class="form-control" value="" disabled>
                </div>
                <div class="mb-3">
                    <label for="kabkot" class="form-label">Kabupaten/Kota</label>
                    <input type="kabkot" id="kabkot" name="kabkot" class="form-control" value="" disabled>
                </div>
                <div class="mb-3">
                    <label for="kec" class="form-label">Kecamatan</label>
                    <input type="kec" id="kec" name="kec" class="form-control" value="" disabled>
                </div>
                <div class="mb-3">
                    <label for="desa" class="form-label">Desa/Kelurahan</label>
                    <input type="desa" id="desa" name="desa" class="form-control" value="" disabled >
                </div>
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input id="nama" name="nama" type="text" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="jabatan" class="form-label">Jabatan</label>
                    <select id="jabatan" name="jabatan" class="form-select">
                        <option value="">-- Pilih Jabatan --</option>
                        <option value="Kepala Desa">Kepala Desa</option>
                        <option value="Sekretaris Desa">Sekretaris Desa</option>
                        <option value="Pembina Desa Cantik">Pembina Desa Cantik</option>
                        <option value="Agen Statistik">Agen Statistik</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">E-mail</label>
                    <input type="email" id="email" name="email" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="ig" class="form-label">Instagram</label>
                    <input id="ig" name="ig" type="text" class="form-control">
                </div>
                <div class="mb-3">
                  <label class="form-label">Photo Preview</label><br>
                  <img src="../assets/images/products/s4.jpg" id="foto" class="card-img-top rounded w-25" alt="Foto Perangkat Desa">
                </div>
                <input type="hidden" id="keteranganView" name="keterangan">
                <?php if (auth()->user()->inGroup('verifikator') || auth()->user()->inGroup('adminkab')): ?>
                <div class="modal-footer">
                    <button id="setujui" type="submit" class="btn btn-success">Setujui</button>
                    <button id="tolak" type="submit" class="btn btn-danger">Tolak</button>
                </div>  
                <?php endif?>
            </form>
        </div>
    </div>
  </div>
</div>

<!-- Modal Cancel-->
<div class="modal fade" id="modalCancel" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Apakah anda yakin membatalkan pengajuan?</h5>
        <button type="button" class="btn btn-light rounded-pill closeModal" data-dismiss="modal">
          X
        </button>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-info closeModal" data-dismiss="modal">Tidak</button>
        <form method="post" class="d-inline">
            <input type="hidden" name="_method" value="DELETE">
            <input type="hidden" id="keteranganCancel" name="keterangan" value="sadas">
            <button type="submit" class="btn btn-danger">Ya</button>
        </form> 
      </div>
    </div>
  </div>
</div>

<?= $this->endSection(); ?>