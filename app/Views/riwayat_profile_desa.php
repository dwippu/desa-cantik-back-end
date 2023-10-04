<?= $this->extend('template'); ?>

<?= $this->Section('content'); ?>

<div class="container-fluid">
    <div class="card bg-primary">
    <div class="card-body">
        <div class="card bg-primary">
        <div class="card-body" style="padding:0;">
            <h2 class="fw-semibold text-bg-primary" style="float: left;">Riwayat Pengajuan - Perubahan Profile Desa</h2>
            <?php if (auth()->user()->inGroup('operator')): ?>
                <a type="button" class="btn btn-light m-1" href="/pengajuanprofiledesa" style="float: right; box-shadow: 0 6px 20px 0 rgba(0,0,0,0.19);">Ajukan Perubahan</a>
            <?php endif?>
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
                                    <th>Operator</th>
                                    <th>Kode Desa</th>
                                    <th>Keterangan</th>
                                    <th>Tanggal Pengajuan</th>
                                    <th>Tanggal Konfirmasi</th>
                                    <th>Detail</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($profil_desa as $row):?>
                                    <tr>
                                        <td><?=$row['username']?></td>
                                        <td><?=$row['kode_desa']?></td>
                                        <td><?php if ($row['approval'] == 'disetujui'){
                                                    echo '<span class="badge bg-success rounded-3 fw-semibold">Disetujui</span>';
                                                }elseif ($row['approval'] == 'diajukan'){
                                                    echo '<span class="badge bg-secondary rounded-3 fw-semibold">Diajukan</span>';
                                                }elseif ($row['approval'] == 'ditolak'){
                                                    echo '<span class="badge bg-danger rounded-3 fw-semibold">Ditolak</span>';
                                                }
                                            ?>
                                        </td>
                                        <td><?=$row['tanggal_pengajuan']?></td>
                                        <td><?=$row['tanggal_konfirmasi']?></td>
                                        <td><button data-id="<?=$row['id']?>" id="btnViewProfile" class="btn btn-outline-primary rounded-pill" data-toggle="modal" data-target="#modalView"><i class="ti ti-search"></i>View</button></td>
                                        <td><button data-id="<?=$row['id']?>" id="btnCancelProfile" class="btn btn-danger rounded-pill" data-toggle="modal" data-target="#modalCancel" <?php if ($row['tanggal_konfirmasi'] != null) echo 'disabled' ?> >Batalkan</button></td>
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
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Detail Pengajuan</h5>
        <button type="button" class="btn btn-light rounded-pill closeModal" data-dismiss="modal">
          X
        </button>
      </div>
        <div class="modal-body">
            <form action="/pengajuanprofiledesa" method="post">
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
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea id="alamat" name="alamat" rows="4" cols="50" class="form-control" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail</label>
                        <input type="email" id="email" name="email" class="form-control" value="" required>
                    </div>
                    <div class="mb-3">
                        <label for="telp" class="form-label">Telepon</label>
                        <input type="tel" id="telp" name="telp" class="form-control" minlength="7" maxlength="13" value="" required>
                    </div>
                    <div class="mb-3">
                        <label for="info" class="form-label">Informasi Umum</label></p>
                        <textarea id="info" name="info" rows="4" cols="50" class="form-control" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="maps" class="form-label">HTML Maps</label></p>
                        <textarea id="maps" name="maps" rows="4" cols="50" class="form-control" required></textarea>
                    </div>
                    <?php if (auth()->user()->inGroup('verifikator')): ?>
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
            <button type="submit" class="btn btn-danger">Ya</button>
        </form> 
      </div>
    </div>
  </div>
</div>


<?= $this->endSection(); ?>