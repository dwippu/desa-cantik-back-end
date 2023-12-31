<?= $this->extend('template'); ?>

<?= $this->Section('content'); ?>
    <div class="container-fluid">
        <div class="card" style="background-color:#5D87FF;">
        <div class="card-body">
            <h2 class="fw-semibold mb-4 text-bg-primary">Profile Desa</h2>

            <div class="card">
            <div class="card-body">
                <form action="/pengajuanprofiledesa" method="post">
                    <div class="row">
                        <div class="col-6">
                            <label for="prov" class="form-label">Provinsi</label>
                            <input type="text" id="prov" name="prov" class="form-control" value="<?= $info_desa['nama_prov']?>" disabled>
                        </div>
                        <div class="col-6">
                            <label for="kabkot" class="form-label">Kabupaten/Kota</label>
                            <input type="kabkot" id="kabkot" name="kabkot" class="form-control" value="<?= $info_desa['nama_kab']?>" disabled>
                        </div>
                    </div>
                    <div class="row pt-2">
                        <div class="col-6">
                            <label for="kec" class="form-label">Kecamatan</label>
                            <input type="kec" id="kec" name="kec" class="form-control" value="<?= $info_desa['nama_kec']?>" disabled>
                        </div>
                        <div class="col-6">
                            <label for="desa" class="form-label">Desa/Kelurahan</label>
                            <input type="desa" id="desa" name="desa" class="form-control" value="<?= $info_desa['nama_desa']?>" disabled >
                        </div>
                    </div><br>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea id="alamat" name="alamat" rows="4" cols="50" class="form-control" required><?php if($profil_desa){echo $profil_desa['alamat'];};?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail</label>
                        <input type="email" id="email" name="email" class="form-control" value="<?php if($profil_desa){echo $profil_desa['email'];};?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="telp" class="form-label">Telepon</label>
                        <input type="tel" id="telp" name="telp" class="form-control" minlength="7" maxlength="13" value="<?php if($profil_desa){echo $profil_desa['telp'];};?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="info" class="form-label">Informasi Umum</label></p>
                        <textarea id="info" name="info" rows="4" cols="50" class="form-control" required><?php if($profil_desa){echo $profil_desa['info_umum'] ;};?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="maps" class="form-label">HTML Maps</label></p>
                        <textarea id="maps" name="maps" rows="4" cols="50" class="form-control" required><?php if($profil_desa){echo $profil_desa['html_tag'] ;};?></textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Ajukan Perubahan</button>
                </form>
            </div>
            </div>

        </div>
        </div>
    </div>
<?= $this->endSection(); ?>