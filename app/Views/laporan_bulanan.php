<?= $this->extend('template'); ?>

<?= $this->Section('content'); ?>

<div class="container-fluid">
    <div class="card bg-primary">
    <div class="card-body">
        <div class="card bg-primary">
        <div class="card-body" style="padding:0;">
            <h2 class="fw-semibold text-bg-primary" style="float: left;">Daftar Laporan Bulanan</h2>
            <?php if (auth()->user()->inGroup('operator')): ?>
                <a type="button" class="btn btn-light m-1" href="/pengajuanlaporan" style="float: right; box-shadow: 0 6px 20px 0 rgba(0,0,0,0.19);">Tambah Laporan</a>
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
                                    <th>Kode Desa</th>
                                    <th>Nama Kegiatan</th>
                                    <th>Tanggal Kegiatan</th>
                                    <th>Detail</th>
                                    <?php if (auth()->user()->inGroup('operator')): ?>
                                        <th>Aksi</th>
                                        <th>Hapus</th>
                                    <?php endif ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($laporan as $row):?>
                                    <tr>
                                        <td><?=$row['kode_desa']?></td>
                                        <td><?=$row['nama_kegiatan']?></td>
                                        <td><?=$row['tanggal_kegiatan']?></td>
                                        <td><button data-id="<?=$row['id']?>" id="btnViewLaporan" class="btn btn-outline-primary rounded-pill" data-toggle="modal" data-target="#modalView"><i class="ti ti-search"></i>View</button></td>
                                        <?php if (auth()->user()->inGroup('operator')): ?>
                                            <td><a href="editlaporan/<?=$row['id']?>" id="btnEditLaporan" class="btn btn-info rounded-pill"><i class="ti ti-pencil"></i>Edit</a></td>
                                            <td><button data-id="<?=$row['id']?>" id="btnHapusLaporan" class="btn btn-danger rounded-pill" data-toggle="modal" data-target="#modalHapusLaporan"><span class="ti ti-trash"></span> Hapus</button></td>
                                        <?php endif ?>
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
        <h5 class="modal-title" id="namalaporan">Laporan Bulanan</h5>
        <button type="button" class="btn btn-light rounded-pill closeModal" data-dismiss="modal">
          X
        </button>
      </div>
        <div class="modal-body">
            <form method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="nama_kegiatan" class="form-label">Nama Kegiatan</label>
                    <input id="nama_kegiatan" name="nama_kegiatan" type="text" class="form-control <?php  if (session('validation')){if (array_key_exists("nama_kegiatan", session('validation'))) {echo 'is-invalid';};};?>" value="<?= old('nama_kegiatan');?>">
                    <div class="invalid-feedback"><?php  if (session('validation')){if (array_key_exists("nama_kegiatan", session('validation'))) {echo (session('validation')['nama_kegiatan']);};};?></div>
                </div>
                <div class="mb-3">
                    <label for="peserta_kegiatan" class="form-label">Peserta Kegiatan</label>
                    <input id="peserta_kegiatan" name="peserta_kegiatan" type="text" class="form-control <?php  if (session('validation')){if (array_key_exists("peserta_kegiatan", session('validation'))) {echo 'is-invalid';};};?>" value="<?= old('peserta_kegiatan');?>">
                    <div class="invalid-feedback"><?php  if (session('validation')){if (array_key_exists("peserta_kegiatan", session('validation'))) {echo (session('validation')['peserta_kegiatan']);};};?></div>
                </div>
                <div class="col-6">
                    <label for="tanggal_kegiatan" class="form-label">Tanggal Kegiatan</label>
                    <input id="tanggal_kegiatan" name="tanggal_kegiatan" type="date" class="form-control <?php  if (session('validation')){if (array_key_exists("tanggal_kegiatan", session('validation'))) {echo 'is-invalid';};};?>" value="<?= old('tanggal_kegiatan');?>">
                    <div class="invalid-feedback"><?php  if (session('validation')){if (array_key_exists("tanggal_kegiatan", session('validation'))) {echo (session('validation')['tanggal_kegiatan']);};};?></div>
                </div><br>
                <embed id="file_view" type="application/pdf" width="100%" height="600px"></embed>
            </form>
        </div>
    </div>
  </div>
</div>

<!-- Modal hapus-->
<div class="modal fade" id="modalHapusLaporan" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="pesanAktif">Ajukan Hapus Laporan ini?</h5>
        <button type="button" class="btn btn-light rounded-pill closeModal" data-dismiss="modal">
          X
        </button>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-info closeModal" data-dismiss="modal">Tidak</button>
        <form method="post" class="d-inline">
            <button type="submit" class="btn btn-danger">Ya</button>
        </form> 
      </div>
    </div>
  </div>
</div>

<?= $this->endSection(); ?>