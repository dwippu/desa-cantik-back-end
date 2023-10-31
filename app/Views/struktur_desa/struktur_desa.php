<?= $this->extend('template'); ?>

<?= $this->Section('content'); ?>

<div class="container-fluid">
    <div class="card bg-primary">
    <div class="card-body">
        <div class="card bg-primary">
        <div class="card-body" style="padding:0;">
            <h2 class="fw-semibold text-bg-primary" style="float: left;">Struktur Organisasi Desa cantik</h2>
            <?php if (auth()->user()->inGroup('operator')): ?>
                <a type="button" class="btn btn-light m-1" href="/pengajuanstrukturdesa" style="float: right; box-shadow: 0 6px 20px 0 rgba(0,0,0,0.19);">Tambah Pengurus</a>
            <?php endif?>
        </div>
        </div>
        <div class="card">
        <div class="card-body">

        <!-- Data Tables -->
        <div class="container">
            <div class="row">
                <div class="col-12">
                        <table id="rpdesa" class="table table-striped" style="width:100%;">
                            <thead>
                                <tr>
                                    <th>Kode Desa</th>
                                    <th>Nama</th>
                                    <th>Jabatan</th>
                                    <th>Status</th>
                                    <th>Detail</th>
                                    <?php if (auth()->user()->inGroup('operator')): ?>
                                      <th>Aksi</th>
                                      <th>Aktif</th>
                                    <?php endif?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($perangkat_desa as $row):?>
                                    <tr>
                                        <td><?=$row['kode_desa']?></td>
                                        <td><?=$row['nama']?></td>
                                        <td><?=$row['jabatan']?></td>
                                        <td><?php if ($row['aktif']=='Aktif'){
                                                    echo '<span class="badge bg-success rounded-3 fw-semibold">',$row['aktif'],'</span>';
                                                }elseif ($row['aktif']=='Tidak Aktif'){
                                                  echo '<span class="badge bg-danger rounded-3 fw-semibold">',$row['aktif'],'</span>';
                                                };
                                            ?>
                                        </td>
                                        <td><button data-id="<?=$row['id']?>" data-keterangan="<?=$row['approval']?>" id="btnViewStruktur" class="btn btn-outline-primary rounded-pill" data-toggle="modal" data-target="#modalView"><i class="ti ti-search"></i>View</button></td>
                                        <?php if (auth()->user()->inGroup('operator')): ?>
                                            <td><a href="editstrukturdesa/<?=$row['id']?>" id="btnEditStruktur" class="btn btn-info rounded-pill"><i class="ti ti-pencil"></i>Edit</a></td>
                                        <?php endif?> 
                                        <?php if ($row['aktif']=='Aktif' && auth()->user()->inGroup('operator')){
                                                    echo '<td><button data-id=',$row['id'],' data-status="Non-Aktifkan" id="btnAktif" class="btn btn-dark rounded-pill" data-toggle="modal" data-target="#modalAktif"><span class="ti ti-analyze-off"></span> Non-Aktifkan</button></td>';
                                                }elseif ($row['aktif']=='Tidak Aktif' && auth()->user()->inGroup('operator')){
                                                    echo '<td><button data-id=',$row['id'],' data-status="Aktifkan" id="btnAktif" class="btn btn-outline-dark rounded-pill" data-toggle="modal" data-target="#modalAktif"><i class="ti ti-analyze"></i> Aktifkan</button></td>';
                                                };
                                            ?>
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
            </form>
        </div>
    </div>
  </div>
</div>

<!-- Modal aktif-->
<div class="modal fade" id="modalAktif" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="pesanAktif">Apakah anda yakin?</h5>
        <button type="button" class="btn btn-light rounded-pill closeModal" data-dismiss="modal">
          X
        </button>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-info closeModal" data-dismiss="modal">Tidak</button>
        <form method="post" class="d-inline">
            <input type="hidden" id="keteranganAktif" name="statusAktif">
            <button type="submit" class="btn btn-danger">Ya</button>
        </form> 
      </div>
    </div>
  </div>
</div>

<?= $this->endSection(); ?>