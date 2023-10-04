<?= $this->extend('template'); ?>

<?= $this->Section('content'); ?>
    <div class="container-fluid">

        <div class="card" style="background-color:#5D87FF;">
        <div class="card-body">
            <h2 class="fw-semibold mb-4 text-bg-primary">Pengajuan - SK Agen Desa</h2>
            <div class="card">
            <div class="card-body">
                <h4 class=" fw-semibold mb-4">Data Kepala Desa</h4>
                <form action="/pengajuanskagen" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="prov" class="form-label">Provinsi</label>
                        <input type="text" id="prov" name="prov" class="form-control" value="<?= $info_desa['nama_prov']?>" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="kabkot" class="form-label">Kabupaten/Kota</label>
                        <input type="kabkot" id="kabkot" name="kabkot" class="form-control" value="<?= $info_desa['nama_kab']?>" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="kec" class="form-label">Kecamatan</label>
                        <input type="kec" id="kec" name="kec" class="form-control" value="<?= $info_desa['nama_kec']?>" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="desa" class="form-label">Desa/Kelurahan</label>
                        <input type="desa" id="desa" name="desa" class="form-control" value="<?= $info_desa['nama_desa']?>" disabled >
                    </div>
                    <div class="mb-3">
                    <div class="mb-3">
                        <label for="no_sk" class="form-label">Nomor SK</label>
                        <input id="no_sk" name="no_sk" type="text" class="form-control <?php  if (session('validation')){if (array_key_exists("no_sk", session('validation'))) {echo 'is-invalid';};};?>" value="<?= old('no_sk');?>">
                        <div class="invalid-feedback"><?php  if (session('validation')){if (array_key_exists("no_sk", session('validation'))) {echo (session('validation')['no_sk']);};};?></div>
                    </div>
                    <div class="mb-3">
                        <label for="tanggal_sk" class="form-label">Tanggal SK</label>
                        <input id="tanggal_sk" name="tanggal_sk" type="date" class="form-control <?php  if (session('validation')){if (array_key_exists("tanggal_sk", session('validation'))) {echo 'is-invalid';};};?>" value="<?= old('tanggal_sk');?>">
                        <div class="invalid-feedback"><?php  if (session('validation')){if (array_key_exists("tanggal_sk", session('validation'))) {echo (session('validation')['tanggal_sk']);};};?></div>
                    </div>
                    <div class="mb-3">
                        <label for="file_sk" class="form-label">Upload SK Agen</label>
                        <input class="form-control <?php  if (session('validation')){if (array_key_exists("file_sk", session('validation'))) {echo 'is-invalid';};};?>" id="file_sk" name="file_sk" type="file">
                        <div class="invalid-feedback"><?php  if (session('validation')){if (array_key_exists("file_sk", session('validation'))) {echo (session('validation')['file_sk']);};};?></div>
                    </div>
                                        
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
            </div>
        </div>
        </div>
    </div>
<?= $this->endSection(); ?>