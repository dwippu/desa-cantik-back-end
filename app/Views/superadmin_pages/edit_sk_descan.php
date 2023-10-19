<?= $this->extend('superadmin_pages/superadmin_template'); ?>

<?= $this->Section('content'); ?>
    <div class="container-fluid">

        <div class="card" style="background-color:#5D87FF;">
        <div class="card-body">
            <h2 class="fw-semibold mb-4 text-bg-primary">Edit - SK Desa Cantik</h2>
            <div class="card">
            <div class="card-body">
                <form action="/editskdescan/<?= $sk_descan['id']?>" method="post" enctype="multipart/form-data">
                    <div class="mb-3 pt-2">
                        <label for="no_sk" class="form-label">Nomor SK</label>
                        <input id="no_sk" name="no_sk" type="text" class="form-control <?php  if (session('validation')){if (array_key_exists("no_sk", session('validation'))) {echo 'is-invalid';};};?>" value="<?php if($sk_descan){echo $sk_descan['nomor_sk'];}else{echo old('no_sk');};?>">
                        <div class="invalid-feedback"><?php  if (session('validation')){if (array_key_exists("no_sk", session('validation'))) {echo (session('validation')['no_sk']);};};?></div>
                    </div>
                    <div class="mb-3 row">
                        <div class="col-6">
                            <label for="tanggal_sk" class="form-label">Tanggal SK</label>
                            <input id="tanggal_sk" name="tanggal_sk" type="date" class="form-control <?php  if (session('validation')){if (array_key_exists("tanggal_sk", session('validation'))) {echo 'is-invalid';};};?>" value="<?php if($sk_descan){echo $sk_descan['tanggal_sk'];}else{echo old('tanggal_sk');};?>">
                            <div class="invalid-feedback"><?php  if (session('validation')){if (array_key_exists("tanggal_sk", session('validation'))) {echo (session('validation')['tanggal_sk']);};};?></div>
                        </div>
                        <div class="col-6">
                            <label for="file_sk" class="form-label">Upload SK</label>
                            <input class="form-control <?php  if (session('validation')){if (array_key_exists("file_sk", session('validation'))) {echo 'is-invalid';};};?>" id="file_sk" name="file_sk" type="file" onchange="previewpdf()">
                            <div class="invalid-feedback"><?php  if (session('validation')){if (array_key_exists("file_sk", session('validation'))) {echo (session('validation')['file_sk']);};};?></div>
                        </div>
                        <input name="skLama" type="hidden" value="<?= $sk_descan['file']?>">
                    </div>
                    <label for="kode_desa[]" class="form-label" id="label-input-kode-desa">Kode Desa dalam SK</label>
                    <div class="container">
                        <div class="row input-kode-desa">
                            <?php foreach ($sk_descan['list_descan'] as $kode_desa): ?>
                                <div class="col-3 pt-2">
                                    <input name="kode_desa[]" type="text" class="form-control kode-desa <?php  if (session('validation')){if (array_key_exists("kode_desa".$i, session('validation'))) {echo 'is-invalid';};};?>" value="<?= $kode_desa ?>" required>
                                </div>
                            <?php endforeach ?>
                            <div id="tambah_kurang_list" class="col-3 pt-2">
                                <span class="btn btn-outline-secondary" id="tambah_descan"><b>+</b></span>
                                <span class="btn btn-outline-secondary" id="pop_descan"><b>-</b></span>
                            </div>
                        </div>
                    </div>
                    <br>
                    <button type="submit" class="btn btn-primary">Submit</button><br><br>
                    <label class="form-label">Preview SK Agen</label>
                    <embed src="../SK Descan/<?=$sk_descan['file']?>" id="fileSkAgen" type="application/pdf" width="100%" height="500px" style="border-style: solid;"></embed>
                </form>
            </div>
            </div>
        </div>
        </div>
    </div>
<?= $this->endSection(); ?>