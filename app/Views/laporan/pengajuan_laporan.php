<?= $this->extend('template'); ?>

<?= $this->Section('content'); ?>
    <div class="container-fluid">

        <div class="card" style="background-color:#5D87FF;">
        <div class="card-body">
            <h2 class="fw-semibold mb-4 text-bg-primary">Pengajuan Laporan Bulanan</h2>
            <div class="card">
            <div class="card-body">
                <form action="/pengajuanlaporan" method="post" enctype="multipart/form-data">
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
                    </div>
                    <div class="mb-3 pt-2">
                        <label for="nama_kegiatan" class="form-label">Nama Kegiatan</label>
                        <input id="nama_kegiatan" name="nama_kegiatan" type="text" class="form-control <?php  if (session('validation')){if (array_key_exists("nama_kegiatan", session('validation'))) {echo 'is-invalid';};};?>" value="<?= old('nama_kegiatan');?>">
                        <div class="invalid-feedback"><?php  if (session('validation')){if (array_key_exists("nama_kegiatan", session('validation'))) {echo (session('validation')['nama_kegiatan']);};};?></div>
                    </div>
                    <div class="mb-3">
                        <label for="peserta_kegiatan" class="form-label">Peserta Kegiatan</label>
                        <input id="peserta_kegiatan" name="peserta_kegiatan" type="text" class="form-control <?php  if (session('validation')){if (array_key_exists("peserta_kegiatan", session('validation'))) {echo 'is-invalid';};};?>" value="<?= old('peserta_kegiatan');?>">
                        <div class="invalid-feedback"><?php  if (session('validation')){if (array_key_exists("peserta_kegiatan", session('validation'))) {echo (session('validation')['peserta_kegiatan']);};};?></div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label for="tanggal_kegiatan" class="form-label">Tanggal Kegiatan</label>
                            <input id="tanggal_kegiatan" name="tanggal_kegiatan" type="date" class="form-control <?php  if (session('validation')){if (array_key_exists("tanggal_kegiatan", session('validation'))) {echo 'is-invalid';};};?>" value="<?= old('tanggal_kegiatan');?>">
                            <div class="invalid-feedback"><?php  if (session('validation')){if (array_key_exists("tanggal_kegiatan", session('validation'))) {echo (session('validation')['tanggal_kegiatan']);};};?></div>
                        </div>
                        <div class="col-6">
                            <label for="file_laporan" class="form-label">Upload Laporan</label>
                            <input class="form-control <?php  if (session('validation')){if (array_key_exists("file_laporan", session('validation'))) {echo 'is-invalid';};};?>" id="file_pdf" name="file_laporan" type="file" onchange="previewpdf()">
                            <div class="invalid-feedback"><?php  if (session('validation')){if (array_key_exists("file_laporan", session('validation'))) {echo (session('validation')['file_laporan']);};};?></div>
                        </div>
                    </div><br>
                    <button type="submit" class="btn btn-primary">Submit</button><br><br>
                    <label class="form-label">Preview Laporan</label>
                    <embed id="file_view" type="application/pdf" width="100%" height="600px" style="border-style: solid;"></embed>
                
                </form>
            </div>
            </div>
        </div>
        </div>
    </div>
<?= $this->endSection(); ?>