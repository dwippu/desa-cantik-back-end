<?= $this->extend('superadmin_pages/superadmin_template'); ?>

<?= $this->Section('content'); ?>
    <div class="container-fluid">

        <div class="card" style="background-color:#5D87FF;">
        <div class="card-body">
            <h2 class="fw-semibold mb-4 text-bg-primary">Upload - SK Desa Cantik</h2>
            <div class="card">
            <div class="card-body">
                <h4 class=" fw-semibold mb-4">Data Kepala Desa</h4>
                <form action="/uploadskdescan" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="no_sk" class="form-label">Nomor SK</label>
                        <input id="no_sk" name="no_sk" type="text" class="form-control <?php  if (session('validation')){if (array_key_exists("no_sk", session('validation'))) {echo 'is-invalid';};};?>" value="<?= old('no_sk');?>" required>
                        <div class="invalid-feedback"><?php  if (session('validation')){if (array_key_exists("no_sk", session('validation'))) {echo (session('validation')['no_sk']);};};?></div>
                    </div>
                    <div class="mb-3">
                        <label for="tahun" class="form-label">Tahun</label>
                        <input id="tahun" name="tahun" type="number" class="form-control <?php  if (session('validation')){if (array_key_exists("tahun", session('validation'))) {echo 'is-invalid';};};?>" value="<?= old('tanggal_sk');?>" required>
                        <div class="invalid-feedback"><?php  if (session('validation')){if (array_key_exists("tahun", session('validation'))) {echo (session('validation')['tahun']);};};?></div>
                    </div>
                    <div class="mb-3">
                        <label for="tanggal_sk" class="form-label">Tanggal SK</label>
                        <input id="tanggal_sk" name="tanggal_sk" type="date" class="form-control <?php  if (session('validation')){if (array_key_exists("tanggal_sk", session('validation'))) {echo 'is-invalid';};};?>" value="<?= old('tanggal_sk');?>" required>
                        <div class="invalid-feedback"><?php  if (session('validation')){if (array_key_exists("tanggal_sk", session('validation'))) {echo (session('validation')['tanggal_sk']);};};?></div>
                    </div>
                    <div class="mb-3">
                        <label for="file_sk" class="form-label">Upload File SK Desa Cantik</label>
                        <input class="form-control <?php  if (session('validation')){if (array_key_exists("file_sk", session('validation'))) {echo 'is-invalid';};};?>" id="file_sk" name="file_sk" type="file" required>
                        <div class="invalid-feedback"><?php  if (session('validation')){if (array_key_exists("file_sk", session('validation'))) {echo (session('validation')['file_sk']);};};?></div>
                    </div>
                    <div class="mb-3">
                        <label for="jumlah" class="form-label">Daftar Desa dalam SK</label>
                        <br><b>Jumlah Desa Cantik Provinsi Jawa Barat</b>
                        <input type="number" name="jumlah" class="form-control mb-2" id="jumlahdescan" value="<?= old('jumlah');?>" required>
                        <b id="label-input-kode-desa">Masukkan kode desa</b>
                        <div class="container">
                            <div class="row input-kode-desa">
                                <?php if(old('kode_desa')): ?>
                                    <?php foreach (old('kode_desa') as $kode_desa): ?>
                                        <div class="col-3 pt-2"><input name="kode_desa[]" type="text" class="form-control kode-desa" value="<?= $kode_desa ?>" required></div>
                                    <?php endforeach ?>
                                <?php endif ?>
                            </div>
                        </div>
                        <div class="invalid-feedback"><?php  if (session('validation')){if (array_key_exists("no_sk", session('validation'))) {echo (session('validation')['no_sk']);};};?></div>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
            </div>
        </div>
        </div>
    </div>
<?= $this->endSection(); ?>