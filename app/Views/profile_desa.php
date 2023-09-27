<?= $this->extend('template'); ?>

<?= $this->Section('content'); ?>
    <div class="container-fluid">
        <div class="card" style="background-color:#5D87FF;">
        <div class="card-body">
            <h2 class="fw-semibold mb-4 text-bg-primary">Profile Desa</h2>
            <div class="card">
            <div class="card-body">
                <form>
                    <div class="mb-3">
                        <label for="prov" class="form-label">Provinsi</label>
                        <select id="prov" name="prov" class="form-select" required>
                            <option value="">None</option>
                            <option value="volvo">Volvo</option>
                            <option value="saab">Saab</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="kabkot" class="form-label">Kabupaten/Kota</label>
                        <select id="kabkot" name="kabkot" class="form-select" required>
                            <option value="">None</option>
                            <option value="volvo">Volvo</option>
                            <option value="saab">Saab</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="kec" class="form-label">Kecamatan</label>
                        <select id="kec" name="kec" class="form-select" required>
                            <option value="">None</option>
                            <option value="volvo">Volvo</option>
                            <option value="saab">Saab</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="desa" class="form-label">Desa/Kelurahan</label>
                        <select id="desa" name="desa" class="form-select" required>
                            <option value="">None</option>
                            <option value="volvo">Volvo</option>
                            <option value="saab">Saab</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea id="alamat" name="alamat" rows="4" cols="50" class="form-control" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail</label>
                        <input type="email" id="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="telp" class="form-label">Telepon</label>
                        <input type="tel" id="telp" name="telp" class="form-control" minlength="7" maxlength="13" required>
                    </div>
                    <div class="mb-3">
                        <label for="info" class="form-label">Informasi Umum</label></p>
                        <textarea id="info" name="info" rows="4" cols="50" class="form-control" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="maps" class="form-label">HTML Maps</label></p>
                        <textarea id="maps" name="maps" rows="4" cols="50" class="form-control" required></textarea>
                    </div>

                    
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
            </div>
        </div>
        </div>
    </div>
<?= $this->endSection(); ?>