<?= $this->extend('template'); ?>

<?= $this->Section('content'); ?>
    <div class="container-fluid">

        <div class="card" style="background-color:#5D87FF;">
        <div class="card-body">
            <h2 class="fw-semibold mb-4 text-bg-primary">Struktur Desa</h2>
            <div class="card">
            <div class="card-body">
                <h4 class=" fw-semibold mb-4">Data Kepala Desa</h4>
                <form action="/pengajuanstrukturdesa" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input id="nama" name="nama" type="text" class="form-control <?php  if (session('validation')){if (array_key_exists("nama", session('validation'))) {echo 'is-invalid';};};?>" value="<?= old('nama');?>">
                        <div class="invalid-feedback"><?php  if (session('validation')){if (array_key_exists("nama", session('validation'))) {echo (session('validation')['nama']);};};?></div>
                    </div>
                    <div class="mb-3">
                        <label for="jabatan" class="form-label">Jabatan</label>
                        <select id="jabatan" name="jabatan" class="form-select <?php  if (session('validation')){if (array_key_exists("jabatan", session('validation'))) {echo 'is-invalid';};};?>">
                            <option value="" <?php if (old('jabatan')==""){echo 'selected';}; ?>>-- Pilih Jabatan --</option>
                            <option value="Kepala Desa" <?php if (old('jabatan')=="Kepala Desa"){echo 'selected';}; ?>>Kepala Desa</option>
                            <option value="Sekretaris Desa" <?php if (old('jabatan')=="Sekretaris Desa"){echo 'selected';}; ?>>Sekretaris Desa</option>
                            <option value="Pembina Desa Cantik" <?php if (old('jabatan')=="Pembina Desa Cantik"){echo 'selected';}; ?>>Pembina Desa Cantik</option>
                            <option value="Agen Statistik" <?php if (old('jabatan')=="Agen Statistik"){echo 'selected';}; ?>>Agen Statistik</option>
                        </select>
                        <div class="invalid-feedback"><?php  if (session('validation')){if (array_key_exists("jabatan", session('validation'))) {echo (session('validation')['jabatan']);};};?></div>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail</label>
                        <input type="email" id="email" name="email" class="form-control <?php  if (session('validation')){if (array_key_exists("email", session('validation'))) {echo 'is-invalid';};};?>" value="<?= old('email');?>">
                        <div class="invalid-feedback"><?php  if (session('validation')){if (array_key_exists("email", session('validation'))) {echo (session('validation')['email']);};};?></div>
                    </div>
                    <div class="mb-3">
                        <label for="ig" class="form-label">Instagram</label>
                        <input id="ig" name="ig" type="text" class="form-control" value="<?= old('ig');?>">
                    </div>
                    <div class="mb-3">
                        <label for="foto" class="form-label">Upload Foto</label>
                        <input class="form-control <?php  if (session('validation')){if (array_key_exists("foto", session('validation'))) {echo 'is-invalid';};};?>" id="foto" name="foto" type="file">
                        <div class="invalid-feedback"><?php  if (session('validation')){if (array_key_exists("foto", session('validation'))) {echo (session('validation')['foto']);};};?></div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
            </div>
        </div>
        </div>
    </div>
<?= $this->endSection(); ?>